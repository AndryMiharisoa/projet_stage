<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twilio\Rest\Client;
use App\Entity\Etudient;
use App\Form\EtudientType;
use App\Repository\EtudientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EtudiantController extends AbstractController
{
    
     private $etudients = [];
    #[Route('/etudiant', name: 'app_etudiant')]
 
    public function index(Request $request): Response
    {
        $etudients = $this->getDoctrine()->getRepository(Etudient::class)->findAll();
    
        // Filtrage par nom, prénom ou convocation
        $searchInput = $request->query->get('searchInput');
        $serieFilter = $request->query->get('serieFilter');
        $convocation= $request->query->get('convocationFilter');
    
        if ($searchInput) {
            $etudiants = $this->getDoctrine()->getRepository(Etudient::class)->findByNomPrenom($searchInput);
        }
    
        if ($serieFilter) {
            $etudiants = $this->getDoctrine()->getRepository(Etudient::class)->findBySerie($serieFilter);
        }
        if($convocation){
            $etudients = $this->getDoctrine()->getRepository(Etudient::class)->findByConvocation($convocation);
        }
        return $this->render('Etudiant/index.html.twig', [
            'etudients' => $etudients,
        ]);
    }



    #[Route('/inscription', name: 'inscription', methods: ['POST', 'GET'])]
  
    public function Inscription(Request $request, EntityManagerInterface $entityManager):  Response
    {
        $etudiant = new Etudient();
        
        $form = $this->createForm(EtudientType::class, $etudiant, [
            'action' => 'inscription',
            'method' => 'POST'
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('Image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gestion des erreurs si nécessaire
                }

                $etudiant->setImage($newFilename);
            }

        }
        if($form->isSubmitted() && $form->isValid()) {  
            $etudiant->setConvocation($this->generateNumeroConvaction());
            $entityManager->persist($etudiant);
            $entityManager->flush();
         
                // Envoi d'un message à l'étudiant après l'inscription
            $nom = $etudiant->getNom();
            $prenom = $etudiant->getPrenom();
            $etablissement=$etudiant->getEtablissement();
            $serie = $etudiant->getSerie();
            $candidat= $etudiant->getCandidat();
            $collective= $etudiant->getFacultative();
            $facultative= $etudiant->getCollective();

            $numero = $etudiant->getTelephone();
            // Remplacez ces informations par vos identifiants Twilio
            $twilioSid = 'ACfbb8f77bca4e6fbf7c78d58c6e0e65d6';
            $twilioToken = 'c989e4b7a75c22267a7abf85ece555d2';
            $twilioPhoneNumber = '+17067176317';

            $twilio = new Client($twilioSid, $twilioToken);
            $message = $twilio->messages->create(
                $numero, // Numéro du destinataire
              
                [
                    'from' => $twilioPhoneNumber, // Votre numéro Twilio
                    'body' => "Bonjour $prenom $nom , Etudiant du $etablissement, $serie,$ $collective  $facultative  merci pour votre inscription. Veuillez repondre à ce message pour confirmer votre identite."
                ]
            );
            return $this->redirectToRoute('inscription');
        }

        return $this->renderForm('etudiant/inscription.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form
        ]);
    }
    #[Route('/etudiant/edit/{id}', name: 'edit_student')]

public function edite(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    $etudiant = $this->getDoctrine()->getRepository(Etudient::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException('Étudiant non trouvé avec l\'identifiant '.$id);
        }

        $form = $this->createFormBuilder($etudiant)
            ->add('nom') // Ajoutez tous les champs nécessaires ici
            ->add('prenom')
            ->add('mere')
            ->add('pere')
            ->add('collective')
            ->add('individuel')
            // Ajoutez d'autres champs requis pour l'édition
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_etudiant');
            // Redirection ou affichage d'un message de succès
        }

        return $this->render('etudiant/edite.html.twig', [
            'form' => $form->createView(),
            'etudiant' => $etudiant,
        ]);
    }
    #[Route('/etudiant/delete/{id}', name: 'delete_student')]
  
public function deleteStudent(int $id, EntityManagerInterface $entityManager): Response
{
    $etudiant = $this->getDoctrine()->getRepository(Etudient::class)->find($id);

    if (!$etudiant) {
        throw $this->createNotFoundException('Étudiant non trouvé');
    }

    $entityManager->remove($etudiant);
    $entityManager->flush();

    // Rediriger vers la page d'affichage des étudiants après suppression
    return $this->redirectToRoute('app_etudiant');
}



    private function generateNumeroConvaction(): string
    {
        // Générez votre numéro_convaction ici, par exemple : 125/21
        $year = date('y');
        $numero = rand(10000, 2000000); // Numéro aléatoire

       return $numero . '/' . $year;
       
        return $numero ;
    }

/**
     * @Route("/add_selected_to_pdf", name="add_selected_to_pdf", methods={"POST"})
     */
    public function addSelectedToPdf(Request $request): Response
    {
        // Récupérer les IDs des étudiants sélectionnés depuis le formulaire
        $selectedStudentIds = $request->request->get('selected_students');

        // Récupérer les données des étudiants sélectionnés depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $selectedStudents = $entityManager->getRepository(Etudient::class)->findBy(['id' => $selectedStudentIds]);

        // Générer le contenu HTML du PDF avec les étudiants sélectionnés
        $html = $this->renderView('etudiant/convocation.html.twig', [
            'etudients' => $selectedStudents,
        ]);

        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Réglages du papier et du format du PDF
        $dompdf->setPaper('A4', 'portrait');

        // Génération du contenu PDF
        $dompdf->render();

        // Enregistrer le fichier PDF dans le dossier spécifié sur le serveur
        $destinationPath = 'E:/boky'; // Remplacez par votre chemin absolu
        $pdfFileName = 'liste_etudiants.pdf';
        $pdfFilePath = $destinationPath . $pdfFileName;

    file_put_contents($pdfFilePath, $dompdf->output());
   
    // Création d'une réponse de téléchargement pour l'utilisateur
    $response = new Response(
        file_get_contents($pdfFilePath),
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . '; filename=' . $pdfFileName,
        ]
    );

    // Suppression du fichier après envoi au téléchargement
    unlink($pdfFilePath);

    return $response;
}

   

}
<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Etudient;
use App\Form\EtudientType;
use App\Repository\EtudientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtudiantController extends AbstractController
{
    
     private $etudients = [];
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        // Récupérer les données de la table "personne" depuis la base de données
        $etudients = $this->getDoctrine()->getRepository(Etudient::class)->findAll();

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

        if($form->isSubmitted() && $form->isValid()) {  
            $etudiant->setConvocation($this->generateNumeroConvaction());
            $entityManager->persist($etudiant);
            $entityManager->flush();
         

            return $this->redirectToRoute('inscription');
        }

        return $this->renderForm('etudiant/inscription.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form
        ]);
    }
    private function generateNumeroConvaction(): string
    {
        // Générez votre numéro_convaction ici, par exemple : 125/21
        $year = date('y');
        $numero = rand(10000, 2000000); // Numéro aléatoire

       // return $numero . '/' . $year;
       
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
        $destinationPath = 'E:/Boky/'; // Remplacez par votre chemin absolu
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

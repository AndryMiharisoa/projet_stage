<?php

namespace App\Controller;

use App\Entity\Etudient;
use App\Entity\Note;
use App\Entity\Matiere;
use App\Repository\NoteRepository;
use App\Repository\MatiereRepository;
use App\Repository\EtudientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{
    #[Route('/note', name: 'app_note')]
    public function index( EtudientRepository $etudiantRepository,MatiereRepository $matiereRepository,NoteRepository $noteRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'etudiant'=>$etudiantRepository->findAll(),
            'matiere'=>$matiereRepository->findAll(),
            'note'=>$noteRepository->findAll(),
        ]);
    }
 /**
     * @Route("/new", name="entree_new", methods={"GET","POST"})
     */
    
     public function createEntry(Request $request): Response
     {
         $data = json_decode($request->getContent(), true);
        // $data = array(
        //    "nom" => "son",
        //    "prenom" => "azerty"
        //);

              dd($data);
         if (!isset($data['entries']) || !is_array($data['entries'])) {
             return new Response('Données invalides', Response::HTTP_BAD_REQUEST);
         }
 
         $entityManager = $this->getDoctrine()->getManager();
 
         foreach ($data['entries'] as $entryData) {
             if (!isset($entryData['etudient_id'], $entryData['matiere'], $entryData['coefficient'], $entryData['note'])) {
                 return new Response('Données incomplètes', Response::HTTP_BAD_REQUEST);
             }
 
             $etudient = $this->getDoctrine()->getRepository(Etudient::class)->findOneBy(['convocation' => $entryData['etudient_id']]);
             
             if (!$etudient) {
                 return new Response('Numéro de convocation non trouvé : ' . $entryData['etudient_id'], Response::HTTP_BAD_REQUEST);
             }
 
             $matiere = new Matiere();
             $matiere->setNom($entryData['matiere']);
             $matiere->setCoefficient($entryData['coefficient']);
             
             $note = new Note();
             $note->setValeur($entryData['note']);
             $note->setEtudient($etudient);
             $note->setMatiere($matiere);
             
             $entityManager->persist($matiere);
             $entityManager->persist($note);
         }
         
         $entityManager->flush();
         return $this->render('liste.html.twig', [
            'entries' => $data, // Envoyer les données collectées à la vue
        ]);
         
         return new Response('Données enregistrées avec succès !', Response::HTTP_OK);
     }
    }


<?php

namespace App\Controller;

use App\Entity\Etudient;
use App\Entity\Note;
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
     * @Route("/save-notes", name="save-notes", methods={"GET","POST"})
     */
    public function note(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data['entries'])) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($data['entries'] as $entry) {
                $note = new Note();
                $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->find($entry['etudiant_id']);

                if ($etudiant) {
                    //$note->setEtudiant($etudiant);
                    $note->setValeur($entry['note']);

                    $entityManager->persist($note);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Données enregistrées avec succès');
            return $this->render('note.html.twig'); // Rediriger vers une page de succès
        } else {
            $this->addFlash('error', 'Aucune donnée reçue');
            return $this->redirectToRoute('save-notes'); // Rediriger vers une page d'erreur si aucune donnée n'est reçue
        }
    }
}

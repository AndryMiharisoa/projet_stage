<?php

namespace App\Controller;

use App\Entity\Etudient;
use App\Form\EtudientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\RedirectResponse;

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
            $entityManager->persist($etudiant);
            $entityManager->flush();
         

            return $this->redirectToRoute('inscription');
        }

        return $this->renderForm('etudiant/inscription.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form
        ]);
    }
    
}

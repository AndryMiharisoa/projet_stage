<?php

namespace App\Controller;

use App\Entity\Direction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectionController extends AbstractController
{
    #[Route('/direction', name: 'app_direction')]
    public function index(): Response
    {
        $directions = $this->getDoctrine()->getRepository(Direction::class)->findAll();
        return $this->render('direction/index.html.twig', [
            'directions' => $directions,
        ]);
    }

    #[Route('/inscription_direction', name: 'direction', methods: ['POST', 'GET'])]
    public function inscriptionDirection(Request $request, EntityManagerInterface $entityManager): Response
    { 
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $dateNaissance = \DateTime::createFromFormat('Y-m-d', $request->request->get('date_naissance'));
            $adresse = $request->request->get('adresse');
            $mail = $request->request->get('mail');
            $etablissement = $request->request->get('etablissement');
            $motPass = $request->request->get('mot_pass');
            $lieu = $request->request->get('lieu');
            $region = $request->request->get('region');

            $direction = new Direction();
            $direction->setNom($nom);
            $direction->setPrenom($prenom);
            $direction->setDateNaissance($dateNaissance);
            $direction->setAdresse($adresse);
            $direction->setMail($mail);
            $direction->setEtablissement($etablissement);
            $direction->setMotPass($motPass);
            $direction->setLieu($lieu);
            $direction->setRegion($region);

            $entityManager->persist($direction);
            $entityManager->flush();

            return $this->redirectToRoute('app_direction');
        }

        return $this->render('direction/inscription_direction.html.twig');
    }
}

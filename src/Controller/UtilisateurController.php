<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        $utulisateurs = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        return $this->render('utilisateur/index.html.twig',[
            'utilisateurs' => $utulisateurs,
        ]);
    }
   
    #[Route('/adimine', name:'admin_registre', methods: ['POST', 'GET'])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Récupération des données de la requête
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $adresse = $request->request->get('adresse');
            $email = $request->request->get('email');
            $telephone = $request->request->get('telephone');
            $password = $request->request->get('password');
            $type = $request->request->get('type');

            // Création d'une nouvelle instance d'Utilisateur et configuration des valeurs
            $user = new Utilisateur();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setAdress($adresse);
            $user->setMail($email);
            $user->setPhone($telephone);
            $user->setMotDePass($password);
            $user->setType($type);

            // Encodage et définition du mot de passe
        
    

            // Enregistrement de l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection vers la page de connexion après l'inscription
            return $this->redirectToRoute('admin_registre');
        }

        return $this->render('Utilisateur/register.html.twig');
    }
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Utilisateur/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/deconnexion', name: 'app_logout')]
    public function logout()
    {
        // Cette méthode ne sera jamais exécutée,
        // car elle est interceptée par le composant de sécurité
    }
} 
    


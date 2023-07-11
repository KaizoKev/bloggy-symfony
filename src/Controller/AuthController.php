<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Création d'un nouvel utilisateur
        $user = new Users();

        // Récupération des données du formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Configuration de l'utilisateur
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));

        // Enregistrement de l'utilisateur
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // Redirection vers la page de connexion (à remplacer par votre propre route si nécessaire)
        return $this->redirectToRoute('app_auth');
    }
}

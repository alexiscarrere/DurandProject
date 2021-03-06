<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {  
        $user = new User();
       
        $donnees = json_decode($request->getContent());
       
            if (isset($donnees->username)) {
            $user->setUsername($donnees->username);}     
            $user->setCreatedAt(new DateTime());
            $roles[] = 'ROLE_USER';
            $user->setRoles($roles);
            if (isset($donnees->password)) {
            $user->setPassword($passwordEncoder->encodePassword($user, $donnees->password));}
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);
        
    }
}

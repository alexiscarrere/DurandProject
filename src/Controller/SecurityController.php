<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="app_login")
     * @return JsonResponse
     * */
    public function login(): JsonResponse
    {
        $user = $this->getUser();
        
        return $this->json(array(
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
         ));
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

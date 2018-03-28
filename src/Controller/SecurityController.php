<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $auth)
    {
        $error = $auth->getLastAuthenticationError();
        
        $lastUsername = $auth->getLastUsername();
        
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }
}

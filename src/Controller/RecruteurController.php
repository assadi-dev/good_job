<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RecruteurController extends AbstractController
{


    /**
     * @Route("/recruteur/login", name = "login_recruteur")
     */

    public function login(AuthenticationUtils $auth)
    {


        return $this->render('recruteur/login_form.html.twig', [
            "lastUsername" => $auth->getLastUsername(),
            "error" => $auth->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/espace/recruteur", name="espace_recruteur")
     */
    public function espace(): Response
    {
        return $this->render('recruteur/index.html.twig', [
            'controller_name' => 'RecruteurController',
        ]);
    }


    /**
     * @Route("/recruteur/logout", name = "logout_recruteur")
     */

    public function logout()
    {
    }
}

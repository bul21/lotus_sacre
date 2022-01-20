<?php

namespace App\Controller;
/* c'est une importation */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/* c'est un raccourci pour http*/ 
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    /* response est une réponse représenté en http */
    public function index(): Response
    {
        /*acces à ma methode $this =>render pour la page d'accueil comme vue*/
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

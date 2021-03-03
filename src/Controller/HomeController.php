<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/accueil.html.twig');
    }

    /**
     * @Route("/plansite", name="plansite")
     */
    public function plansite()
    {
        return $this->render('sitemap.html.twig');
    }
}

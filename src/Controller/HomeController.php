<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/homei", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("", name="app_home")
     */
    public function Home():Response
    {

        return $this->render('home/home.html.twig');
    
    }

/**
     * @Route("/blog", name="blog_home")
     */
    public function blog():Response
    {

        return $this->render('home/widgets.html.twig');
    
    }

}

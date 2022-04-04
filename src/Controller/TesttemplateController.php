<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesttemplateController extends AbstractController
{
    /**
     * @Route("/testtemplate", name="app_testtemplate")
     */
    public function index(): Response
    {
        return $this->render('testtemplate/index.html.twig', [
            'controller_name' => 'TesttemplateController',
        ]);
    }

    /**
     * @Route("/front", name="app_testtemplate")
     */
    public function show(): Response
    {
        return $this->render('home/store.html.twig');
    }
}

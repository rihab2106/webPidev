<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
     * @Route("/admin")
     * class AdminController
     * @package App\Contrller\Admin
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/xxx", name="app_admi")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
     * @Route("/home", name="admin")
     */
    public function homeadmin(): Response
    {
        return $this->render('back/index.html.twig');
    }
    
     /**
     * @Route("/shop", name="adminshop")
     */
    public function shopadmin(): Response
    {
        return $this->render('back/ecommerce-products.html.twig');
    }

     /**
     * @Route("/addProduct", name="adminaddproduct")
     */
    public function Productadmin(): Response
    {
        return $this->render('back/ecommerce-add-new-products.html.twig');
    }
}

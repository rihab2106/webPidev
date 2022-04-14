<?php

namespace App\Controller;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductfrontController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'ProductfrontController',
        ]);
    }
    /**
     * @Route("/display", name="app_product_display", methods={"GET"})
     */
    public function display(EntityManagerInterface $entityManager): Response
    {

        $products = $entityManager
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/display.html.twig', [
            'products' => $products,
        ]);
    }
    /**
     * @Route("/{idProduct}", name="app_productfront_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }


}

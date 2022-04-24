<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TryController extends AbstractController
{
    /**
     * @Route("/all", name="app_all")
     * @param SessionInterface $session
     * @param $ProductRepository
     * @return Response
     */
    public function index(SessionInterface $session, ProductRepository $ProductRepository )
    {
        $cart = $session->get('cart',[]);
        $completecart= [];
        foreach ($cart as $idProduct => $quantity){
            $completecart[]= [
                'Product'=> $ProductRepository->find($idProduct),
                'quantity'=>$quantity
            ];
        }
        $total =0.0;
        foreach ($completecart as $item) {
            $totalproduct =$item['Product']->getPrice()+($item['Product']->getPrice() * (($item['Product']->getDiscount())/100));
            $total += $totalproduct;

        }
        return $this->render('home/front_base.html.twig', [
            'Items' => $completecart,


        ]);

    }
}

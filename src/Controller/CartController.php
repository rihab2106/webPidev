<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
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
        return $this->render('cart/display.html.twig', [
            'items' => $completecart,
            'total' => $total,
            'completecard'=>$completecart

        ]);

    }
    /**
     * @Route("/cart/add/{idProduct}", name="cart_add")
     */
    public function add($idProduct, SessionInterface $session): Response
    {
        $cart = $session->get('cart',[]);
        if (!empty($cart[$idProduct])){
           echo "you can add a game once !";
        }else {$cart[$idProduct]=1;}

        $session->set('cart',$cart);
        return $this-> redirectToRoute("app_cart");
    }

    /**
     * @Route("/cart/remove/{idProduct}", name="cart_remove")
     */
    public function remove($idProduct, SessionInterface $session)
    {
     $cart = $session->get('cart',[]);
     if(!empty($cart[$idProduct])){
         unset($cart[$idProduct]);
     }
     $session -> set('cart', $cart);
     return $this-> redirectToRoute("app_cart");
    }
}

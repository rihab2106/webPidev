<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use Twilio\Rest\Client;

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
            $totalproduct =$item['Product']->getPrice()-($item['Product']->getPrice() * (($item['Product']->getDiscount())/100));
            if(($item['Product']->getQuantity())>0){

                $item['Product']->setQuantity(($item['Product']->getQuantity())-1);

            }
$this->getDoctrine()->getManager()->flush();
if (($item['Product']->getQuantity())==0){
    $sid    = "AC97b9b1afb3b68605a0dbec9ce9567174";
    $token  = "bedb866cd96c88f020e87879b89a749a";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
        ->create("+21628564711", // to
            array(
                "messagingServiceSid" => "MGe9c9b8c623ffc333c419a522028b894f",
                "body" => "Product ".$item['Product']->getprodName()."is expired , please delete it"
            )
        );
//    return $this->redirectToRoute("app_product_display");
}
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






//    /**
//     * @Route("/display/c", name="cart_show")
//     */
//    public function indexcart(SessionInterface $session, ProductRepository $ProductRepository )
//    {
//        $cart = $session->get('cart',[]);
//        $completecart= [];
//        foreach ($cart as $idProduct => $quantity){
//            $completecart[]= [
//                'Product'=> $ProductRepository->find($idProduct),
//                'quantity'=>$quantity
//            ];
//        }
//        $total =0.0;
//        foreach ($completecart as $item) {
//            $totalproduct =$item['Product']->getPrice()+($item['Product']->getPrice() * (($item['Product']->getDiscount())/100));
//            $item['Product']->setQuantity(($item['Product']->getQuantity())-1);
//            $this->getDoctrine()->getManager()->flush();
//
//            $total += $totalproduct;
//
//        }
//
//        return $this->render('home/front_base.html.twig', [
//            'items' => $completecart,
//            'total' => $total,
//            'completecard'=>$completecart
//
//        ]);
//
//    }
}


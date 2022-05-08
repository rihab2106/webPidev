<?php

namespace App\Controller;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\Payment;
use App\Entity\Product;
use App\Form\PaymentType;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

use Stripe\Checkout\Session;
use Stripe\Stripe;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/", name="app_payment_index", methods={"GET"})
     */
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $transactionRepository->findAll(),
        ]);
    }


    /**
     * @Route("/checkout", name="app_payment_check", methods={"GET"})
     */
    public function checkout( $stripeSK,SessionInterface $sessionc, ProductRepository $ProductRepository): Response
    {
        $cart = $sessionc->get('cart',[]);
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
             $total +=round($totalproduct, 2);

        }
        $cartcontroller = new CartController();

        Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' =>['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Your Games are ready',
                    ],

                    'unit_amount' => $total*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);
        return $this->redirect($session->url, 303);
    }

    /**
     * @Route("/success-url", name="success_url")
     */
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', []);
    }
    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }






    /**
     * @Route("/new", name="app_payment_new")
     */
    public function new(Request $request): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($payment);
            $em->flush();

            $sid    = "AC97b9b1afb3b68605a0dbec9ce9567174";
            $token  = "bedb866cd96c88f020e87879b89a749a";
            $twilio = new Client($sid, $token);

            $message = $twilio->messages
                ->create("+21628564711", // to
                    array(
                        "messagingServiceSid" => "MGe9c9b8c623ffc333c419a522028b894f",
                        "body" => "Your message"
                    )
                );



            return $this->redirectToRoute('app_payment_new');
        }

        return $this->render('payment/new.html.twig', [

            'formpay' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPayment}", name="app_payment_show", methods={"GET"})
     */
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{idPayment}/edit", name="app_payment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Payment $payment, TransactionRepository $transactionRepository): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($payment);
            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPayment}", name="app_payment_delete", methods={"POST"})
     */
    public function delete(Request $request, Payment $payment, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getIdPayment(), $request->request->get('_token'))) {
            $transactionRepository->remove($payment);
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }
}

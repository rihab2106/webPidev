<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Trophies;
use App\Form\TrophiesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrophiesController extends AbstractController
{
    /**
     * @Route("/trophies", name="app_trophies")
     */
    public function index(): Response
    {
        return $this->render('trophies/index.html.twig', [
            'controller_name' => 'TrophiesController',
        ]);
    }
    /**
     * @Route("/displayTrophies", name="displayTrophies")
     */
    public function display()
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        return $this->render("trophies/displayTrophies.html.twig", [
            "trophies"=> $rep->findAll()
        ]);
    }
    /**
     * @Route("/addTrophies", name="addTrophies")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $t=new Trophies();
        $form=$this->createForm(TrophiesFormType::class,$t);
        $form->add("Add_Trophy", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $mng->persist($g=$form->getData());
            $mng->flush();
            return $this->redirectToRoute("displayTrophies");
        }
        return $this->render("trophies/AddTrophies.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/updateTrophies/{id}" , name="updateTrophies")
     */
    public function update($id, Request $request)
    {
        $mng = $this->getDoctrine()->getManager();
        $rep= $this->getDoctrine()->getRepository(Trophies::class);
        $t = $rep->find($id);
        $form = $this->createForm(TrophiesFormType::class, $t);
        $form->add("Update_Trophy", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $g = $form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayTrophies");
        }
        return $this->render("trophies/AddTrophies.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/deleteTrophies" ,name="deleteTrophies")
     */
    public function delete()
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $mng=$this->getDoctrine()->getManager();
        if (isset($_POST["check[]"])){
            $check=$_POST["check[]"];
            foreach ($check as $c)
                $mng->remove($rep->find($c));
        }
    }

}

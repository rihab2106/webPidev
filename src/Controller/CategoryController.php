<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    /**
     * @Route("/displayCat", name="displayCat")
     */
    public function Display()
    {
        $rep=$this->getDoctrine()->getRepository(Category::class);
        $response=new Response("<h1>No one will save you </h1>",Response::HTTP_NOT_FOUND,[]);
        return $this->render("category/displayCat.html.twig", [
            "data"=> $rep->findAll(),
            "cat"=>$rep->findAll()
        ],$response);
    }
    /**
     * @Route("/addCat", name="addCat")
     */
    public function add(Request $request)
    {

        $mng=$this->getDoctrine()->getManager();
        $c=new Category();
       $form=$this->createForm(CategoryFormType::class,$c);
       $form->add("Add", SubmitType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()){
           $c=$form->getData();

           $mng->persist($c);
           $mng->flush();
           $this->redirectToRoute("displayCat");
       }
       return $this->render("category/addCat.html.twig", [
           "fo"=>$form->createView()
       ]);
    }

    /**
     * @Route("/updateCat/{id}", name="updateCat")
     */
    public function update($id, Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Category::class);
        $mng=$this->getDoctrine()->getManager();
        $c=$rep->find($id);
        $form=$this->createForm(CategoryFormType::class,$c);
        $form->add("Update",SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $c=$form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayCat");
        }
        return $this->render("category/addCat.html.twig",[
            "fo"=>$form->createView()
        ]);
    }
    /**
     * @Route("/deleteCat/{id}", name="deleteCat")
     */
    public function delete($id)
    {
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($this->getDoctrine()->getRepository(Category::class)->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayCat");
    }

}

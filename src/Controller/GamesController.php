<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Games;
use App\Entity\Trophies;
use App\Form\GamesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesController extends AbstractController
{
    /**
     * @Route("/games", name="app_games")
     */
    public function index(): Response
    {
        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
    /**
     * @Route("/displayGames", name="displayGames")
     */
    public function display()
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);
        $repCat=$this->getDoctrine()->getRepository(Category::class);
        return $this->render("games/displayGames.html.twig", [
            "cat"=>$repCat->findAll(),
            "games"=> $rep->findAll()
        ]);
    }
    /**
     * @Route("/addGames", name="addGames")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $g=new Games();
        $form=$this->createForm(GamesFormType::class,$g);
        $form->add("Add Game", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $g=$form->getData();
            $mng->persist($g);
            $mng->flush();
            return $this->redirectToRoute("displayGames");
        }
        return $this->render("games/addGames.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/updateGames/{id}", name="updateGames")
     */
    public function update($id, Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);
        $mng=$this->getDoctrine()->getManager();
        $g=$rep->find($id);
        $form=$this->createForm(GamesFormType::class, $g);
        $form->add("Update", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $g=$form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayGames");
        }
        return $this->render("games/addGames.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/deleteGames/{id}",  name="deleteGames")
     */
    public function delete($id)
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);

        $this->getDoctrine()->getManager()->remove($rep->find($id));
        return $this->redirectToRoute("displayGames");
    }
    /**
     * @Route("/GamesTrophies/{id}", name="GamesTrophies")
     */
    public function displayById($id)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $repg=$this->getDoctrine()->getRepository(Games::class);
        return $this->render("trophies/displayTrophies.html.twig", [
            "trophies"=> $rep->findBy(["idGame"=> $repg->find($id)])
        ]);
    }
    /**
     * @Route("/filterGames/{id}", name="filterGames")
     */
    public function filter($id)
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);
        $repCat=$this->getDoctrine()->getRepository(Category::class);
        return $this->render("games/displayGames.html.twig", [
            "cat"=>$repCat->findAll(),
            "games"=> $rep->filterbyCat($id)
        ]);
    }



}

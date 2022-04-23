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
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
        if ($form->isSubmitted() && $form->isValid()){
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
        if ($form->isSubmitted() && $form->isValid()) {
            $g = $form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayTrophies");
        }
        return $this->render("trophies/AddTrophies.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/deleteTrophies/{id}" ,name="deleteTrophies")
     */
    public function delete($id , Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayTrophies");
    }
    /**
     * @Route("/displayGamesTro/{id}", name="displayGamesTro")
     */
    public function displayGamesTrophies($id)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $repGame=$this->getDoctrine()->getRepository(Games::class);
        $game=$repGame->find($id);
        $trophies=$rep->findBy(["idGame"=> $game]);
        return $this->render("trophies/FrontDisplayTrophies.html.twig", [
            "trophies"=> $trophies,
            "game"=> $game
        ]);
    }
    /**
     * @Route("/admin/displayGamesTro/{id}", name="displayGamesTroAdmin")
     */
    public function displayGamesTrophiesAdmin($id, HttpClientInterface $client)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);

        $repGame=$this->getDoctrine()->getRepository(Games::class);
        $game=$repGame->find($id);
        $res=$client->request("GET","https://www.googleapis.com/youtube/v3/search?q="
            .urldecode($game->getName()." trailer")."&key=AIzaSyAv2wjYsP23B90uykgf3jpX8Dtpwsmze3U");
        $content=json_decode($res->getContent());
        $Vid=$content->{"items"}[0]->{"id"}->{"videoId"};

        $trophies=$rep->findBy(["idGame"=> $game]);
        return $this->render("trophies/AdminDisplayTrophies.html.twig", [
            "trophies"=> $trophies,
            "game"=> $game,
            "vid"=> $Vid
        ]);
    }


}

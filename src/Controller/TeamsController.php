<?php

namespace App\Controller;

use App\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TeamsFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class TeamsController extends AbstractController
{
    /**
     * @Route("/teams", name="app_teams")
     */
    public function index(): Response
    {
        return $this->render('teams/index.html.twig', [
            'controller_name' => 'TeamsController',
        ]);
    }


    /**
     * @Route("/displayTeams", name="displayTeams")
     */
    public function display()
    {
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        return $this->render('teams/displayTeams.html.twig', [
            'teams' => $rep->findAll()
        ]);
    }

    /**
     * @Route("/displayTeamsFront", name="displayTeamsFront")
     */
    public function displayFront()
    {
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        return $this->render('teams/displayTeamsFront.html.twig', [
            'teams' => $rep->findAll()
        ]);
    }

    /**
     * @Route("/addTeams", name="addTeams")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $c=new Teams();
        $form=$this->createForm(TeamsFormType::class,$c);
        $form->add("Add Team",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $c=$form->getData();
            $mng->persist($c);
            $mng->flush();
            return $this->redirectToRoute("displayTeams");

        }
        return $this->render('teams/addTeams.html.twig', [
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/addTeamsFront", name="addTeamsFront")
     */
    public function addFront(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $c=new Teams();
        $formf=$this->createForm(TeamsFormType::class,$c);
        $formf->add("Add Team",SubmitType::class);
        $formf->handleRequest($request);
        if($formf->isSubmitted() && $formf->isValid())
        {
            $c=$formf->getData();
            $mng->persist($c);
            $mng->flush();
            return $this->redirectToRoute("displayTeamsFront");

        }
        return $this->render('teams/addTeamsFront.html.twig', [
            "formf"=>$formf->createView()
        ]);
    }

    /**
     * @Route("/updateTeams/{id}", name="updateTeams")
     */
    public function update($id,Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        $c=$rep->find($id);
        $form=$this->createForm(TeamsFormType::class,$c);
        $form->add("Update Teams",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $c=$form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayTeams");

        }
        return $this->render('teams/addTeams.html.twig', [
            "form"=>$form->createView()
        ]);
    }


    /**
     * @Route("/updateTeamsFront/{id}", name="updateTeamsFront")
     */
    public function updateFront($id,Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        $c=$rep->find($id);
        $formf=$this->createForm(TeamsFormType::class,$c);
        $formf->add("Update Teams",SubmitType::class);
        $formf->handleRequest($request);
        if($formf->isSubmitted() && $formf->isValid())
        {
            $c=$formf->getData();
            $mng->flush();
            return $this->redirectToRoute("displayTeamsFront");

        }
        return $this->render('teams/addTeamsFront.html.twig', [
            "formf"=>$formf->createView()
        ]);
    }

    /**
     * @Route("/deleteTeams/{id}", name="deleteTeams")
     */
    public function delete($id)
    {
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayTeams");

    }


    /**
     * @Route("/deleteTeamsFront/{id}", name="deleteTeamsFront")
     */
    public function deleteFront($id)
    {
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayTeamsFront");

    }





}

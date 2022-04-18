<?php

namespace App\Controller;

use App\Entity\Competitions;
use App\Entity\Teams;
use App\Form\CompetitionsFormType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionsController extends AbstractController
{
    /**
     * @Route("/competitions", name="app_competitions")
     */
    public function index(): Response
    {
        return $this->render('competitions/index.html.twig', [
            'controller_name' => 'CompetitionsController',
        ]);
    }

    /**
     * @Route("/displayCompetitions", name="displayCompetitions")
     */
    public function display(Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Competitions::class);


        $form=$this->createForm(FormType::class);
        $form->add("gameName", TextType::class)
            ->add("search", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            return $this->render("competitions/displayCompetitions.html.twig", [


                "competitions" => $rep->findByName($form->getData()["gameName"]),
                "search"=> $form->createView()
            ]);
        }

        return $this->render('competitions/displayCompetitions.html.twig', [
            'competitions' => $rep->findAll(),
            "search"=> $form->createView()
        ]);
    }

    /**
     * @Route("/displayCompetitionsFront", name="displayCompetitionsFront")
     */
    public function displayFront()
    {
        $rep=$this->getDoctrine()->getRepository(Competitions::class);
        return $this->render('competitions/displayCompetitionsFront.html.twig', [
            'competitions' => $rep->findAll()
        ]);

    }


    /**
     * @Route("/addCompetitions", name="addCompetitions")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $c=new Competitions();
        $form=$this->createForm(CompetitionsFormType::class,$c);
        $form->add("Add Competition",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $c=$form->getData();
            $mng->persist($c);
            $mng->flush();
            return $this->redirectToRoute("displayCompetitions");

        }
        return $this->render('competitions/addCompetitions.html.twig', [
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/addCompetitionsFront", name="addCompetitionsFront")
     */
    public function addFront(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $c=new Competitions();
        $formf=$this->createForm(CompetitionsFormType::class,$c);
        $formf->add("Add Competition",SubmitType::class);
        $formf->handleRequest($request);
        if($formf->isSubmitted() && $formf->isValid())
        {
            $c=$formf->getData();
            $mng->persist($c);
            $mng->flush();
            return $this->redirectToRoute("displayCompetitionsFront");

        }
        return $this->render('competitions/addCompetitionsFront.html.twig', [
            "formf"=>$formf->createView()
        ]);
    }



    /**
     * @Route("/updateCompetitions/{id}", name="updateCompetitions")
     */
    public function update($id,Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Competitions::class);
        $mng=$this->getDoctrine()->getManager();
        $c=$rep->find($id);
        $form=$this->createForm(CompetitionsFormType::class,$c);
        $form->add("Update Competition",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $c=$form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayCompetitions");

        }
        return $this->render('competitions/addCompetitions.html.twig', [
            "form"=>$form->createView()
        ]);
    }



    /**
     * @Route("/updateCompetitionsFront/{id}", name="updateCompetitionsFront")
     */
    public function updateFront($id,Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Competitions::class);
        $mng=$this->getDoctrine()->getManager();
        $c=$rep->find($id);
        $formf=$this->createForm(CompetitionsFormType::class,$c);
        $formf->add("Update Competition",SubmitType::class);
        $formf->handleRequest($request);
        if($formf->isSubmitted() && $formf->isValid())
        {
            $c=$formf->getData();
            $mng->flush();
            return $this->redirectToRoute("displayCompetitionsFront");

        }
        return $this->render('competitions/addCompetitionsFront.html.twig', [
            "formf"=>$formf->createView()
        ]);
    }





    /**
     * @Route("/deleteCompetitions/{id}", name="deleteCompetitions")
     */
    public function delete($id)
    {
       $rep=$this->getDoctrine()->getRepository(Competitions::class);
       $mng=$this->getDoctrine()->getManager();
       $mng->remove($rep->find($id));
       $mng->flush();
       return $this->redirectToRoute("displayCompetitions");

    }


    /**
     * @Route("/deleteCompetitionsFront/{id}", name="deleteCompetitionsFront")
     */
    public function deleteFront($id)
    {
        $rep=$this->getDoctrine()->getRepository(Competitions::class);
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayCompetitionsFront");

    }




    /**
     * @Route("/CompetitionsTeams/{id}", name="CompetitionsTeams")
     */
    public function displayById($id)
    {
        $rep=$this->getDoctrine()->getRepository(Teams::class);
        $repc=$this->getDoctrine()->getRepository(Competitions::class);
        return $this->render("teams/displayTeams.html.twig", [
            "teams"=> $rep->findBy(["idCompetion"=>$repc->find($id)])

            ]);
    }




}

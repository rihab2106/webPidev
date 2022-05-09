<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Serializer;
use App\Entity\Competitions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class CompetitionsMobileController extends AbstractController
{
    /**
     * @Route("/competitions/mobile", name="app_competitions_mobile")
     */
    public function index(): Response
    {
        return $this->render('competitions_mobile/index.html.twig', [
            'controller_name' => 'CompetitionsMobileController',
        ]);
    }



    /**
     * @Route("/Competitions/getCompetitions", name="GetCompetitionsMobile")
     */
    public function getCompetitionsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Competitions = $em->getRepository(Competitions::class)->findAll();
        $json = $normalizer->normalize($Competitions, "json");
        return new Response(json_encode($json));
    }



    /**
     * @Route("/mobile/addCompetitions", name="AddCompetitionsMobile", methods={"POST","GET"})
     */
    public function addCompetitionsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Competitions=new Competitions();
        $Competitions->setgameName($request->get('gameName'));
        $d = new \DateTime('now');
        $Competitions->setdateofcomp(new \DateTime($request->get('dateofcomp')));

        $json= $normalizer->normalize($Competitions, "json", [
            'attributes' => [
                'gameName',
                'dateofcomp']
        ]);
        $em->persist($Competitions);
        $em->flush();
        return new Response(json_encode($json));

    }


    /**
     * @Route("/mobile/deleteCompetitions", name="m", methods={"POST","GET"})
     */
    public function delete(Request $request)
    {
        $idCompetion=$request->get("idCompetion");
        $em =$this->getDoctrine()->getManager();
        $Competitions=$em->getRepository(Competitions::class)->find($idCompetion);
        if($Competitions!=null){
            $em->remove($Competitions);
            $em->flush();
            $serialize= new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("Competition is deleted.");
            return new JsonResponse($formatted);
        }

        return new JsonResponse("Competition is invalid");


    }



    /**
     * @Route("/mobile/updateCompetitions", name="UpdateCompetitionsMobile")
     */
    public function updateCompetitionsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Competitions= $em->getRepository(Competitions::class)->find($request->get('idCompetion'));
        $Competitions->setgameName($request->get('gameName'));
        $Competitions->setdateofcomp(new \DateTime($request->get('dateofcomp')));
        $em->flush();
        $json= $normalizer->normalize($Competitions, "json", [
            'attributes' => [
                'gameName',
                'dateofcomp']
        ]);
        return new Response(json_encode($json));

    }





}

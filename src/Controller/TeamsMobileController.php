<?php

namespace App\Controller;

use App\Entity\Competitions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Teams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class TeamsMobileController extends AbstractController
{
    /**
     * @Route("/teams/mobile", name="app_teams_mobile")
     */
    public function index(): Response
    {
        return $this->render('teams_mobile/index.html.twig', [
            'controller_name' => 'TeamsMobileController',
        ]);
    }


    /**
     * @Route("/Teams/getTeams", name="GetTeamsMobile")
     */
    public function getTeamsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Teams = $em->getRepository(Teams::class)->findAll();
        $json = $normalizer->normalize($Teams, "json");
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/addTeams", name="AddTeamsMobile", methods={"POST","GET"})
     */
    public function addTeamsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Teams=new Teams();
        $Teams->setTeamName($request->get('teamName'));
        $comp=$this->getDoctrine()->getRepository(Competitions::class)->find($request->get("idCompetion"));
        $Teams->setIdCompetion($comp);

        $json= $normalizer->normalize($Teams, "json", [
            'attributes' => [
                'teamName',
                'idCompetion']
        ]);
        $em->persist($Teams);
        $em->flush();
        return new Response(json_encode($json));

    }



    /**
     * @Route("/deleteTeamsMobile", name="app_mobile_delete")
     *
     */
    public function delete(Request $request)
    {
        $idTeam=$request->get("idTeam");
        $em =$this->getDoctrine()->getManager();
        $Teams=$em->getRepository(Teams::class)->find($idTeam);
        if($Teams!=null){
            $em->remove($Teams);
            $em->flush();
            $serialize= new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("Team is deleted.");
            return new JsonResponse($formatted);
        }

        return new JsonResponse("Teams is invalid");


    }



    /**
     * @Route("/mobile/updateTeams", name="UpdateTeamsMobile")
     */
    public function updateTeamsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Teams= $em->getRepository(Teams::class)->find($request->get('idTeam'));

        $Teams->setTeamName($request->get('teamName'));
        $comp=$this->getDoctrine()->getRepository(Competitions::class)->find($request->get("idCompetion"));
        $Teams->setIdCompetion($comp);


        $em->flush();
        $json= $normalizer->normalize($Teams, "json", [
            'attributes' => [
                'teamName',
                'idCompetion']
        ]);
        return new Response(json_encode($json));
    }

}

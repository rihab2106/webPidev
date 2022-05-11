<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Trophies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrophiesMobileController extends AbstractController
{
    /**
     * @Route("/admin/mobile/addTrophies", name="addTrophies")
     */
    public function addTrophies(Request $request, NormalizerInterface $normalizer){
        $trophy=new Trophies();
        $trophy->setTitle($request->get('title'));
        $trophy->setDescription($request->get('description'));
        $trophy->setDifficulity($request->get('difficulity'));
        $trophy->setPlatform($request->get('platform'));
        $trophy->setIdGame($this->getDoctrine()->getRepository(Games::class)->find($request->get('idGame')));
        $this->getDoctrine()->getManager()->persist($trophy);
        $this->getDoctrine()->getManager()->flush();
        $json=$normalizer->normalize($trophy, "json");
        return new Response(json_encode($json));
    }
    /**
     * @Route("/admin/mobile/updateTrophies", name="updateTrophies")
     */
    public function updateTrophies(Request $request, NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $trophy = $this->getDoctrine()->getRepository(Trophies::class)->find($request->get('idTrophy'));
        //$trophy->setId($request->get('idTrophy'));
        $trophy->setTitle($request->get('title'));
        $trophy->setDescription($request->get('description'));
        $trophy->setDifficulity($request->get('difficulity'));
        $trophy->setPlatform($request->get('platform'));
        $trophy->setIdGame($this->getDoctrine()->getRepository(Games::class)->find($request->get('idGame')));
        $em->flush();
        $json = $normalizer->normalize($trophy, "json", [
            'attributes' => [
                'idTrophy',
                'title',
                'description',
                'difficulity',
                'platform',
                'idGame'
            ]
        ]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/admin/mobile/deleteTrophies", name="deleteTrophies")
     */
    public function deleteTrophies(Request $request, NormalizerInterface $normalizer){
        $trophy=$this->getDoctrine()->getRepository(Trophies::class)->find($request->get('idTrophy'));
        $this->getDoctrine()->getManager()->remove($trophy);
        $this->getDoctrine()->getManager()->flush();
        $json=$normalizer->normalize($trophy, "json", [
            'attributes' => [
                'idTrophy',
                'title',
                'description',
                'difficulity',
                'platform',
                'idGame'
            ]
        ]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/mobile/getTrophies", name="getTrophies")
     */
    public function getTrophies(Request $request, NormalizerInterface $normalizer)
    {
        $trophies = $this->getDoctrine()->getRepository(Trophies::class)->findAll();
        $json = $normalizer->normalize($trophies, "json");
        return new Response(json_encode($json));
    }
    /**
     * @Route("/mobile/getGamesTrailer/{id}", name="getGamesTrailer")
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
        return new Response($Vid);


    }
}

<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Games;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GamesMobileController extends AbstractController
{
    /**
     * @Route("/admin/mobile/addGames", name="AddGamesMobile")
     */
    public function addGamesMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $game=new Games();
        $game->setName($request->get('name'));
        $game->setDescription($request->get('description'));
        $game->setRate($request->get('rate'));
        $game->setImg($request->get('img'));
        $cat= $em->getRepository(Category::class)->findOneBy(["category"=>$request->get('category')]);
       $game->setCategory($cat);
        $em->persist($game);
        $em->flush();
        $json= $normalizer->normalize($game, "json", [
            'attributes' => [
                'id_game',
                'name',
                'description',
                'rate',
                'img'
            ]
        ]);
        return new Response(json_encode($json));

    }
    /**
     * @Route("/admin/mobile/deleteGames", name="DeleteGamesMobile")
     */
    public function deleteGamesMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository(Games::class)->find($request->get('idGame'));
        $em->remove($game);
        $em->flush();
        $json = $normalizer->normalize($game, "json", [
            'attributes' => [
                'id_game',
                'name',
                'description',
                'rate',
                'img'
            ]
        ]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/admin/mobile/updateGames", name="UpdateGamesMobile")
     */
    public function updateGamesMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $game= $em->getRepository(Games::class)->find($request->get('idGame'));
        $game->setName($request->get('name'));
        $game->setDescription($request->get('description'));
        $game->setRate($request->get('rate'));
        $game->setImg($request->get('img'));
        $cat= $em->getRepository(Category::class)->findOneBy(["category"=>$request->get('category')]);
        $game->setCategory($cat);
        //$em->persist($game);
        $em->flush();
        $json= $normalizer->normalize($game, "json", [
            'attributes' => [
                'id_game',
                'name',
                'description',
                'rate',
                'img'
            ]
        ]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/mobile/getGames", name="GetGamesMobile")
     */
    public function getGamesMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository(Games::class)->findAll();
        $json = $normalizer->normalize($games, "json");
        return new Response(json_encode($json));
    }
    /**
     * @Route("/mobile/uploadImg", name="uploadImg")
     */
    public function uploadImg(Request $request, NormalizerInterface $normalizer){
        //houni uploadi image 
       if (isset($_FILES['file']["name"])){
           $img=file_get_contents($_FILES["file"]["tmp_name"]);
           $fp=fopen("BackAssets\\images\\GameImgs\\".$_FILES['file']["name"].".jpg","w");
           fwrite($fp,$img);
           fclose($fp);

       }
       
        return new Response('json_encode($_FILES)');
    }
    
}

<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class NewsMobileController extends AbstractController


{

    /**
     * @Route("/mobile/getNews", name="GetNewsMobile")
     */
    public function getNewsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->findAll();
        $json = $normalizer->normalize($news, "json");
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/addNews", name="AddNewsMobile", methods={"POST","GET"})
     */
    public function addNewsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $news=new News();
        $news->setContent($request->get('content'));
        $news->setHeadline($request->get('headline'));
        $news->setImg($request->get('img'));
       
        
        $json= $normalizer->normalize($news, "json", [
            'attributes' => [
                'content',
                'headline',
                'img']
        ]);
        $em->persist($news);
        $em->flush();
        return new Response(json_encode($json));

    }

    /**
     * @Route("/news/mobile/deleteNews", name="DeleteNewsMobile", methods={"POST","GET","DELETE"})
     */
    public function deleteNewsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($request->get('idNews'));
        $em->remove($news);
        $em->flush();
        $json= $normalizer->normalize($news, "json", [
            'attributes' => 
                ['idNews']]);           
       
        return new Response(json_encode($json));
    }



    /**
     * @Route("/mobile/updateNews", name="UpdateNewsMobile")
     */
    public function updateNewsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $news= $em->getRepository(News::class)->find($request->get('idnews'));
        $news->setContent($request->get('content'));
        $news->setHeadline($request->get('headline'));
        $news->setImg($request->get('img'));
        //$em->persist($news);
        $em->flush();
        $json= $normalizer->normalize($news, "json", [
            'attributes' => [
                'idnews',
                'content',
                'headline',
                'img']
        ]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/news/mobile/uploadImg", name="uploadImg")
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
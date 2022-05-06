<?php

namespace App\Controller;

use App\Entity\Comments;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommentsMobileController extends AbstractController


{

    /**
     * @Route("/Comments/getComments", name="GetCommentsMobile")
     */
    public function getCommentsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Comments = $em->getRepository(Comments::class)->findAll();
        $json = $normalizer->normalize($Comments, "json");
        return new Response(json_encode($json));
    }

    /**
     * @Route("/admin/mobile/addComments", name="AddCommentsMobile", methods={"POST","GET"})
     */
    public function addCommentsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Comments=new Comments();
        $Comments->setComment($request->get('comment'));
        $Comments->setIdNews($request->get('idnews'));
       
        
        $json= $normalizer->normalize($Comments, "json", [
            'attributes' => [
                'comment',
                'idnews']
        ]);
        $em->persist($Comments);
        $em->flush();
        return new Response(json_encode($json));

    }

    /**
     * @Route("/admin/mobile/deleteComments", name="DeleteCommentsMobile")
     */
    public function deleteCommentsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Comments = $em->getRepository(Comments::class)->find($request->get('idComments'));
        $em->remove($Comments);
        $em->flush();
        $json= $normalizer->normalize($Comments, "json", [
            'attributes' => 
                ['idComments']]);           
       
        return new Response(json_encode($json));
    }



    /**
     * @Route("/admin/mobile/updateComments", name="UpdateCommentsMobile")
     */
    public function updateCommentsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Comments= $em->getRepository(Comments::class)->find($request->get('idComments'));
        $Comments->setContent($request->get('content'));
        $Comments->setHeadline($request->get('headline'));
        $Comments->setImg($request->get('img'));
        //$em->persist($Comments);
        $em->flush();
        $json= $normalizer->normalize($Comments, "json", [
            'attributes' => [
                'idComments',
                'content',
                'headline',
                'img']
        ]);
        return new Response(json_encode($json));
    }






    



}
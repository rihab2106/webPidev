<?php

namespace App\Controller;

use Twig\Template;
use App\Entity\News;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Controller\NewsController;
use App\Repository\CommentsRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/", name="app_comments_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $comments = $entityManager
            ->getRepository(Comments::class)
            ->findAll();

        return $this->render('comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/test", name="test",methods={"GET", "POST"})
     * 
     */
    public function testAction($variable)
    {
        dd($variable);
    }







    /**
     * @Route("/addcomment", name="add_comment", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rep = $this->getDoctrine()->getRepository(News::class)->find($request->query->get('news'));
        $comment = new Comments();
        $defaultData = ['likes' => 0, 'dislikes' => 0, 'idNews' => $request->query->get('news')];

        /* $form = $this->createFormBuilder($defaultData)
            ->add('comment', TextType::class)
            ->getForm(); */
            $form=$this->createForm(CommentsType::class,$comment);
       /*  $form->add("Add",SubmitType::class); */
       $form->add('Add Comment',SubmitType::class,[
        'disabled' => 'true',
        
        'attr' => ['class' => 'save btn-primary btn'],
       
       
       ]);
        $form->handleRequest($request);

        /*  $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request); */
       
        if ($form->isSubmitted() && $form->isValid()) {
            $arr = $form->getData();
           /*  $comment->setComment($arr['comment']);
            $comment->setLikes($arr['likes']);
            $comment->setDislikes($arr['dislikes']);*/
            $comment->setIdNews($rep); 
            $comment->setLikes(0); 
            $comment->setDislikes(0); 
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_news_show', [

                'idNews'=>$request->query->get('news')
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }



     /**
     * @Route("/addcommentuser", name="add_comment_user", methods={"GET", "POST"})
     */
    public function newusercom(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rep = $this->getDoctrine()->getRepository(News::class)->find($request->query->get('news'));

        $comment = new Comments();
        $defaultData = ['likes' => 0, 'dislikes' => 0, 'idNews' => $request->query->get('news')];

        /* $form = $this->createFormBuilder($defaultData)
            ->add('comment', TextType::class)
            ->getForm(); */
            $form=$this->createForm(CommentsType::class,$comment);
       // $form->add("Add",SubmitType::class);
       $form->add('Add Comment',SubmitType::class,[
        'disabled' => 'true',
        
        'attr' => ['class' => 'save btn-primary btn'],
       
       
       ]);
        $form->handleRequest($request);

        /*  $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request); */
       
        if ($form->isSubmitted() && $form->isValid()) {
            $arr = $form->getData();
           /*  $comment->setComment($arr['comment']);
            $comment->setLikes($arr['likes']);
            $comment->setDislikes($arr['dislikes']);*/
            $comment->setIdNews($rep); 
            $comment->setLikes(0); 
            $comment->setDislikes(0); 
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_news_show_user', [

                'idNews'=>$request->query->get('news')
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/newusercom.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idComment}", name="app_comments_show", methods={"GET"})
     */
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{idComment}/edit", name="app_comments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$entityManager->flush();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }


   

    /**
     * @Route("/{idComment}", name="app_comments_delete", methods={"POST"})
     */
    public function delete(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getIdComment(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }
   /**
    *@Route("/{idComment}/like/" , name="salem_sahbi",methods={"GET"})
    * @param EntityManagerInterface $entityManager
    * @param Request $request
    * @return void
    */
    public function addlike(EntityManagerInterface $entityManager, Request $request,$idComment)
    {   
        $ses=new Session();
        
        

        /* 
        $ses->get('like');
        $like = $this->get('session')->get('like');
        $like=$this->get('session')->set("like",5);
         */
        
        
        $commentid = array('idComment'=>$idComment);
        
        $rep = $this->getDoctrine()->getRepository(Comments::class)->find(($commentid["idComment"]));
        if ($ses->get('like')=="159")
        {
            $rep->setLikes($rep->getLikes()+1);
            $ses->set("like","10");
        }
        else 
        {
            $rep->setLikes($rep->getLikes()-1);
            $ses->set("like","159");
        }
        
        $entityManager->flush();
        
        return $this->redirectToRoute('app_news_show_user', [
            'idComment'=>$idComment,
            'idNews'=>$request->query->get('idNews'),
            'ses'=>$ses
        ], Response::HTTP_SEE_OTHER);

        


    }

    
}

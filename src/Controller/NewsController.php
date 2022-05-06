<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Entity\Comments;
use Doctrine\ORM\Mapping\Id;
use App\Repository\CommentsRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="app_news_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }



    /**
     * @Route("/newss", name="app_news_index_suer", methods={"GET"})
     */
    public function indexuser(EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $session->start();
        $session->set("like", "159");
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();

        return $this->render('news/indexuser.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/new", name="app_news_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $n = $form->getData();
            $file = $form["img"]->getData();
            $file->move("C:\\xampp\\htdocs\\TrophyHunter\\public\\assets\\images", $file->getClientOriginalName());
            $n->setImg("public\\assets\\images\\" . $file->getClientOriginalName());
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/comments/{idNews}", name="app_news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        $rep = $this->getDoctrine()->getRepository(Comments::class);
        return $this->render('news/show.html.twig', [
            'news' => $news,
            'idNews' => $news->getIdNews(),
            'com' => $rep->findBy(['idNews' => $news])
        ]);
    }

    /**
     * @Route("/commentsuser/{idNews}", name="app_news_show_user", methods={"GET"})
     */
    public function showusernews(News $news): Response
    {
        $rep = $this->getDoctrine()->getRepository(Comments::class);
        return $this->render('news/showusernews.html.twig', [
            'news' => $news,
            'idNews' => $news->getIdNews(),
            'com' => $rep->findBy(['idNews' => $news])
        ]);
    }

    /**
     * @Route("/{idNews}/edit", name="app_news_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/edit.html.twig', [
            'news' => $news,

            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{idNews}", name="app_news_delete", methods={"POST"})
     */
    public function delete(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $news->getIdNews(), $request->request->get('_token'))) {
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/comments/{idNews}",name ="app_news_comments", methods={"POST","GET"})
     */
    public function gotonews(Request $request, News $news): Response
    {

        return $this->render("news/news_wahda.html.twig", [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/newssss" , name ="app_news_refresh" , methods={"POST","GET"})
     * 
     */
    public function refreshnews(EntityManagerInterface $entityManager):Response
    {
        // VideoGameNews API url
        /* $url = "https://gaming-news.p.rapidapi.com/news";
        $data = [
            'collection' => 'RapidAPI'
        ];
        $curl = curl_init($url);
        // Set the CURLOPT_RETURNTRANSFER option to true
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Set the CURLOPT_POST option to true for POST request
        curl_setopt($curl, CURLOPT_POST, true);
        // Set the request data as JSON using json_encode function
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
        // Set custom headers for RapidAPI Auth and Content-Type header
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-RapidAPI-Host: gaming-news.p.rapidapi.com',
            'X-RapidAPI-Key: 0180b95259msh0f063eaab3962ecp1d38e7jsnfa35693d7d18',
            'Content-Type: application/json'
        ]); */

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://videogames-news2.p.rapidapi.com/videogames_news/recent",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: videogames-news2.p.rapidapi.com",
                "X-RapidAPI-Key: 0180b95259msh0f063eaab3962ecp1d38e7jsnfa35693d7d18"
            ],
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            dd($err);
        } else {
            
          
           $res=json_decode($response);
           foreach ($res as $key => $value) {
            $news=new News();
            $news->setHeadline($value->title);
            $news->setContent($value->description);
            $news->setImg($value->image);
            $entityManager->persist($news);
            $entityManager->flush();
            
        }
        }

         return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER); 
    }
    /**
     * @Route("/testpage",name="salem_bro", methods={"GET","POST"})
     */
    public function test(EntityManagerInterface $em):Response
    {
        $news = $em
        ->getRepository(News::class)
        ->findAll();
        return $this->render("news/test.html.twig", [
            'news'=>$news
            
        ]);

    }
}

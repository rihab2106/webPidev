<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Games;
use App\Entity\Trophies;
use App\Form\GamesFormType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class GamesController extends AbstractController
{
    /**
     * @Route("/games", name="app_games")
     */
    public function index(): Response
    {
        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
    /**
     * @Route("/displayGames", name="displayGames")
     */
    public function display(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Games::class);
        $repCat = $this->getDoctrine()->getRepository(Category::class);
        $form=$this->createForm(FormType::class);
        $form->add("name", TextType::class)
            ->add("search", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),

            "games" => $rep->findByName($form->getData()["name"]),
                "search"=> $form->createView()
            ]);
        }
        if (true) {

            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games" => $rep->findAll(),
                "search"=>$form->createView()
            ]);
        }
        else {
            return $this->render("games/FrontDisplayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games"=> $rep->findAll()
            ]);
        }
    }
    /**
     * @Route("/addGames", name="addGames")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $g=new Games();
        $form=$this->createForm(GamesFormType::class,$g);
        $form->add("Add Game", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $g=$form->getData();
            $file =$form["img"]->getData();
            $file->move("C:\\xampp\\htdocs\\TrophyHunter\\public\\BackAssets\\images\\GameImgs",$file->getClientOriginalName());
            $g->setImg("BackAssets\\images\\GameImgs\\".$file->getClientOriginalName());
            $mng->persist($g);
            $mng->flush();
            return $this->redirectToRoute("displayGames");
        }
        return $this->render("games/addGames.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/updateGames/{id}", name="updateGames")
     */
    public function update($id, Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);
        $mng=$this->getDoctrine()->getManager();
        $g=$rep->find($id);
        $form=$this->createForm(GamesFormType::class, $g);
        $form->add("Update", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $g=$form->getData();
            $file =$form["img"]->getData();
            $file->move("C:\\xampp\\htdocs\\TrophyHunter\\public\\BackAssets\\images\\GameImgs",$file->getClientOriginalName());
            $g->setImg("BackAssets\\images\\GameImgs\\".$file->getClientOriginalName());
            $mng->flush();
            return $this->redirectToRoute("displayGames");
        }
        return $this->render("games/addGames.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/deleteGames/{id}",  name="deleteGames")
     */
    public function delete($id)
    {
        $rep=$this->getDoctrine()->getRepository(Games::class);

        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();

       return $this->redirectToRoute("displayGames");
    }
    /**
     * @Route("/GamesTrophies/{id}", name="GamesTrophies")
     */
    public function displayById($id)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $repg=$this->getDoctrine()->getRepository(Games::class);
        return $this->render("trophies/displayTrophies.html.twig", [
            "trophies"=> $rep->findBy(["idGame"=> $repg->find($id)])
        ]);
    }
    /**
     * @Route("/filterGames/{id}", name="filterGames")
     */
    public function filter($id)
    {
        $rep = $this->getDoctrine()->getRepository(Games::class);
        $repCat = $this->getDoctrine()->getRepository(Category::class);
        if (1<0) {
            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games" => $rep->filterbyCat($id)
            ]);
        }
        else
            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games" => $rep->filterbyCat($id)
            ]);
    }
    /**
     * @Route("/admin/stat", name="Gamestat")
     */
    public function stat(ChartBuilderInterface $chartBuilder)
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('games/stat.html.twig', [
            'chart' => $chart,
        ]);
    }
    /**
     * @Route("/admin/fetchOnline/{id}", name="fetchOnline")
     */
    public function fetchOnline($id,HttpClientInterface $client)
    {
        $game=new Games();
        $game=$this->getDoctrine()->getRepository(Games::class)->find($id);
        $name=$game->getName();
        $res=$client->request("GET","https://rawg-video-games-database.p.rapidapi.com/games/".
            $name."?key=0b1f1156cb1546dabef544af6d565b4b",[
            "headers"=>[
                "x-rapidapi-host"=> "rawg-video-games-database.p.rapidapi.com",
                "x-rapidapi-key"=> "64097372bemsh474baf260df44b5p187695jsn0d1f86c219e8"
            ]
        ]);
        $cont=$res->getContent();
        $obj=json_decode($cont);
        $game->setDescription($obj->{"description"});
        $game->setRate($obj->{"metacritic"});
        $game->setName($obj->{"slug"});
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("displayGames");


    }

    /**
     * @Route("/admin/translate/{id}", name="translate")
     */
    public function translate($id,HttpClientInterface $client)
    {
        $game=new Games();
        $game=$this->getDoctrine()->getRepository(Games::class)->find($id);

        $res=$client->request("POST","https://api.nlpcloud.io/v1/opus-mt-en-fr/translation",[
            "headers"=>[
                "Authorization"=> "Token 7b152b2c977a6b885aebc85b8b508f60a6298da6"
            ],
            "body"=> ["text"=>"hello there "]
        ]);
        $cont=$res->getContent();
        $obj=json_decode($cont);
        $game->setDescription($obj->{"translation_text"});
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("displayGames");


    }




}

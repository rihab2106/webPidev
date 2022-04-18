<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Games;
use App\Entity\Trophies;
use App\Form\GamesFormType;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Middleware\ApiAi;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Client;
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
    public function display(Request $request, PaginatorInterface $paginator)
    {
        $rep = $this->getDoctrine()->getRepository(Games::class);
        $repCat = $this->getDoctrine()->getRepository(Category::class);
        $games=$paginator->paginate(
            $rep->findAll(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );
        $form=$this->createForm(FormType::class);
        $form->add("name", TextType::class)
            ->add("search", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $games=$paginator->paginate(
                $rep->findByName($form["name"]->getData()),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 2)
            );
            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),

            "games" => $games,
                "search"=> $form->createView()
            ]);
        }
        if (true) {

            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games" => $games,
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
    public function add(Request $request, HttpClientInterface $client)
    {
        $res=$client->request("GET","https://api.api-ninjas.com/v1/facts", [
            "headers"=>[
                "X-Api-Key"=>"F5coi8YxdewL4rDKo0FVVw==mM5geLpb1Ki9o5P0"
            ]
        ]);
        $content=$res->getContent();
        $ff=json_decode($content);
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
            "form"=> $form->createView(),
            "fact"=>$ff[0]->{"fact"}
        ]);
    }
    /**
     * @Route("/updateGames/{id}", name="updateGames")
     */
    public function update($id, Request $request,HttpClientInterface $client)
    {
        $res=$client->request("GET","https://api.api-ninjas.com/v1/facts", [
            "headers"=>[
                "X-Api-Key"=>"F5coi8YxdewL4rDKo0FVVw==mM5geLpb1Ki9o5P0"
            ]
        ]);
        $content=$res->getContent();
        $ff=json_decode($content);
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
            "form"=> $form->createView(),
            "fact"=>$ff[0]->{"fact"}
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
    public function filter($id, PaginatorInterface $paginator, Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Games::class);
        $repCat = $this->getDoctrine()->getRepository(Category::class);
        $games=$paginator->paginate(
            $rep->filterbyCat($repCat->find($id)),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );
        $form=$this->createForm(FormType::class);
        $form->add("name", TextType::class)
            ->add("search", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $games=$paginator->paginate(
                $rep->findByName($form["name"]->getData()),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 2)
            );
            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),

                "games" => $games,
                "search"=> $form->createView()
            ]);
        }
        if (true) {

            return $this->render("games/displayGames.html.twig", [
                "cat" => $repCat->findAll(),
                "games" => $games,
                "search"=>$form->createView()
            ]);
        }
    }
    /**
     * @Route("/admin/stat", name="Gamestat")
     */
    public function stat(ChartBuilderInterface $chartBuilder)
    {
       $rep=$this->getDoctrine()->getRepository(Games::class);
       $reptr=$this->getDoctrine()->getRepository(Trophies::class);
        return $this->render('games/stat.html.twig', [
            'games' => $rep->findAll(),
            'trophies' => $reptr->findAll(),
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
        $img_url=$obj->{"background_image"};
        $img=file_get_contents($img_url);
        $fp=fopen("BackAssets\\images\\GameImgs\\".$obj->{"slug"}.".jpg","w");
        fwrite($fp,$img);
        fclose($fp);
        $game->setImg("BackAssets\\images\\GameImgs\\".$obj->{"slug"}.".jpg");
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
                "Authorization"=> "Token c9cb714f93d7e4caf20485a6d314f08b1ad7a9f3"
            ],
            "body"=>["text"=>"hello there "]
        ]);
        $cont=$res->getContent();
        $obj=json_decode($cont);
        $game->setDescription($obj->{"translation_text"});
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("displayGames");


    }
    /**
     * @Route("/admin/msg",name="msg")
     */
    public function msg(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $config=[];
        $botman = BotManFactory::create($config);
        $botman->hears("(hello|h|hel)",function(BotMan $botman){
            $botman->reply("Well, hello there!\n What can I do for you?");
        });
        $botman->hears("remove game {name}",function(BotMan $botman,$name){
            $game=$this->getDoctrine()->getRepository(Games::class)->findOneBy(["name"=>$name]);
            $this->getDoctrine()->getManager()->remove($game);
            $this->getDoctrine()->getManager()->flush();
            $botman->reply("the game ".$name." has been removed");
            return $this->redirectToRoute("displayGames");
        });
        $botman->hears("add game {name}",function(BotMan $botman,$name){
            $game=new Games();
            $game->setName($name);
            $game->setDescription("");
            $game->setRate(0);
            $this->getDoctrine()->getManager()->persist($game);
            $this->getDoctrine()->getManager()->flush();
            $botman->reply("the game ".$name." has been added");
            return $this->redirectToRoute("displayGames");
        });
        $botman->hears("update game {name}",function(BotMan $botman,$name){
            $game=$this->getDoctrine()->getRepository(Games::class)->findOneBy(["name"=>$name]);
            $botman->reply("what do you want to update?");
            $botman->hears("description",function(BotMan $botman,$name){
                $botman->reply("what is the new description?");
                $botman->hears("{desc}",function(BotMan $botman,$desc,$name){
                    $game=$this->getDoctrine()->getRepository(Games::class)->findOneBy(["name"=>$name]);
                    $game->setDescription($desc);
                    $this->getDoctrine()->getManager()->flush();
                    $botman->reply("the description has been updated");
                    return $this->redirectToRoute("displayGames");
                });
            });
            $botman->hears("rate",function(BotMan $botman,$name){
                $botman->reply("what is the new rate?");
                $botman->hears("{rate}",function(BotMan $botman,$rate,$name){
                    $game=$this->getDoctrine()->getRepository(Games::class)->findOneBy(["name"=>$name]);
                    $game->setRate($rate);
                    $this->getDoctrine()->getManager()->flush();
                    $botman->reply("the rate has been updated");
                    return $this->redirectToRoute("displayGames");
                });
            });
        });
        $botman->hears("display games",function(BotMan $botman){
            $games=$this->getDoctrine()->getRepository(Games::class)->findAll();
            $botman->reply("the games are:\n");
            foreach ($games as $game){
                $botman->reply($game->getName()."\n");
            }
        });
        $botman->fallback(function($bot){
            $bot->reply("Sorry, I don't understand you");
        });
        $botman->listen();
        return new Response();
    }
    /**
     * @Route("/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('games/chatframe.html.twig');
        //create new file

    }





}

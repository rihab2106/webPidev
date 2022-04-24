<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Trophies;
use App\Form\TrophiesFormType;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrophiesController extends AbstractController
{
    /**
     * @Route("/trophies", name="app_trophies")
     */
    public function index(): Response
    {
        return $this->render('trophies/index.html.twig', [
            'controller_name' => 'TrophiesController',
        ]);
    }
    /**
     * @Route("/admin/displayTrophies", name="displayTrophies")
     */
    public function display()
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        return $this->render("trophies/displayTrophies.html.twig", [
            "trophies"=> $rep->findAll()
        ]);
    }
    /**
     * @Route("/addTrophies", name="addTrophies")
     */
    public function add(Request $request)
    {
        $mng=$this->getDoctrine()->getManager();
        $t=new Trophies();
        $form=$this->createForm(TrophiesFormType::class,$t);
        $form->add("Add_Trophy", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $mng->persist($g=$form->getData());
            $mng->flush();
            return $this->redirectToRoute("displayTrophies");
        }
        return $this->render("trophies/AddTrophies.html.twig", [
            "form"=> $form->createView()
        ]);
    }
    /**
     * @Route("/updateTrophies/{id}" , name="updateTrophies")
     */
    public function update($id, Request $request)
    {
        $mng = $this->getDoctrine()->getManager();
        $rep= $this->getDoctrine()->getRepository(Trophies::class);
        $t = $rep->find($id);
        $form = $this->createForm(TrophiesFormType::class, $t);
        $form->add("Update_Trophy", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $g = $form->getData();
            $mng->flush();
            return $this->redirectToRoute("displayTrophies");
        }
        return $this->render("trophies/AddTrophies.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/deleteTrophies/{id}" ,name="deleteTrophies")
     */
    public function delete($id , Request $request)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $mng=$this->getDoctrine()->getManager();
        $mng->remove($rep->find($id));
        $mng->flush();
        return $this->redirectToRoute("displayTrophies");
    }
    /**
     * @Route("/displayGamesTro/{id}", name="displayGamesTro")
     */
    public function displayGamesTrophies($id)
    {
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $repGame=$this->getDoctrine()->getRepository(Games::class);
        $game=$repGame->find($id);
        $trophies=$rep->findBy(["idGame"=> $game]);
        return $this->render("trophies/FrontDisplayTrophies.html.twig", [
            "trophies"=> $trophies,
            "game"=> $game
        ]);
    }
    /**
     * @Route("/admin/displayGamesTro/{id}", name="displayGamesTroAdmin")
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
        return $this->render("trophies/AdminDisplayTrophies.html.twig", [
            "trophies"=> $trophies,
            "game"=> $game,
            "vid"=> $Vid
        ]);


    }

    /**
     * @Route("/admin/exportCSV",name="exportCSV")
     */
    public function ExportCSV()
    {
        $spreadSheet = new Spreadsheet();
        $sheet=$spreadSheet->getActiveSheet();
        $sheet->setTitle("Trophies");
        $sheet->fromArray(["id","title","Description","Platform","Difficulty", "Game"],NULL, "A1");
        $rep=$this->getDoctrine()->getRepository(Trophies::class);
        $trophies=$rep->findAll();
        for( $i=0; $i<count($trophies); $i++)
        {
            $sheet->fromArray([$trophies[$i]->getIdTrophy(),
                $trophies[$i]->getTitle(),
                $trophies[$i]->getDescription(),
                $trophies[$i]->getPlatform(),
                $trophies[$i]->getDifficulity(),
                $trophies[$i]->getIdGame()->getName()],
                NULL, "A".($i+2));
        }
       /* $xAxisTickValues = [

            New DataSeriesValues (DataSeriesValues::DATASERIES_TYPE_STRING, 'sheet!$F$2:$F$6', Null, 5),

        ];

        $dataSeriesValues = [

            New DataSeriesValues (DataSeriesValues::DATASERIES_TYPE_NUMBER, 'sheet!$B$2:$B$6', Null, 5),//each value of the number of passengers

        ];
        $series = new DataSeries(

            DataSeries::TYPE_PIECHART,//plotType

            null,//plotGrouping

            range(0, count($dataSeriesValues) - 1),//plotOrder

            [],//plotLabel

            $xAxisTickValues,//plotCategory

            $dataSeriesValues//plotValues

        );

        $series->setPlotDirection(DataSeries::DIRECTION_COL);
        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $Title = new Title ( 'number of passengers per day');

        $chart = new Chart(

            'pie chart',//name

            $Title,//title

            $legend,//legend

            $plotArea,//plotArea

            true,//plotVisibleOnly

            0,//displayBlanksAs

            null,//xAxisLabel

            null  //yAxisLabel

        );
        $chart->setTopLeftPosition('H8');

        $chart->setBottomRightPosition('N24');



        $sheet->addChart($chart);*/

        $writer = new Xlsx($spreadSheet);

        // Create a Temporary file in the system
        $fileName = 'DB.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->setIncludeCharts(TRUE);
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }


}

<?php

namespace App\Controller;
use App\Data\SearchInfo;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use ContainerB5MtGwC\PaginatorInterface_82dac15;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductfrontController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'ProductfrontController',
        ]);
    }
    /**
     * @Route("/display", name="app_product_display", methods={"GET","POST"})
     */
    public function display(ProductRepository $productRepository,EntityManagerInterface $entityManager,PaginatorInterface $paginator,Request $request): Response
    {

          $data = new SearchInfo();
          $data->page=$request->get('page',1);
          $form =$this->createForm(SearchForm::class,$data);
          $form->handleRequest($request);
          $products =$productRepository->search($data);
//        $repCat = $this->getDoctrine()->getRepository(Category::class);
//        $prod = $entityManager->getRepository(Product::class)->findAll();
//        $products = $paginator->paginate(
//            $prod,
//             /* query NOT result */
//            $request->query->getInt('page', 1), /*page number*/
//            4 /*limit per page*/
//        );
//


        return $this->render('product/display.html.twig', [
            'products' => $products,

             'form'=>$form->createView()




        ]);
    }
    /**
     * @Route("/{idProduct}", name="app_productfront_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
    /**
     * @Route("/search", name="app_product_search")
     */
    public function searchbyname(Request $request):Response
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class);
        $repCat = $this->getDoctrine()->getRepository(Category::class);
        $form=$this->createForm(FormType::class);
        $form->add("prodName",TextType::class)
            ->add("search",submitType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted()){
            return $this->render("product/display.html.twig",[
                "cat" => $repCat->findAll(),
                "product" => $product->findByName($form["prodName"]->getData()),
                "search"=>$form->createView()
            ]);

        }
        return $this->render("product/display.html.twig",[
            "cat" => $repCat->findAll(),
            "product" => $product->findAll(),
            "search"=>$form->createView()
        ]);

    }

}

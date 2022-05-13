<?php

namespace App\Controller;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CodenameoneController extends AbstractController
{


///**
//* @Route("/display", name="app_product_displaymobile", methods={"GET","POST"})
//*/
//public function display(UsersRepository $productRepository,EntityManagerInterface $entityManager, NormalizerInterface $normalizer,Request $request): Response
//{
//
//$products = $this->getDoctrine()->getRepository(Users::class)->findAll();
//$json = $normalizer->normalize($products, "json");
//return new Response(json_encode($json));
//
//}

    /**
     * @Route("/Competitions/getCompetitions", name="GetCompetitionsMobile")
     */
    public function getCompetitionsMobile(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $Competitions = $em->getRepository(Users::class)->findAll();
        $json = $normalizer->normalize($Competitions, "json");
        return new Response(json_encode($json));
    }
/**
* @Route("/delete", name="app_mobile_delete")
*
*/
public function delete(Request $request)
{
$idProduct=$request->get("ID_USER");
$em =$this->getDoctrine()->getManager();
$products=$em->getRepository(Users::class)->find($idProduct);
if($products!=null){
$em->remove($products);
$em->flush();
$serialize= new Serializer([new ObjectNormalizer()]);
$formatted=$serialize->normalize("user is deleted.");
return new JsonResponse($formatted);
}

return new JsonResponse("id user is invalid");





}

/**
* @Route("/update", name="app_mobile_update")
*
*/
public function update(Request $request, NormalizerInterface $normalizer)
{

$em =$this->getDoctrine()->getManager();
$users=$this->getDoctrine()->getManager()->getRepository(Users::class)
->find($request->get('id'));
$users->setFULLNAME($request->get('fullName'));
$users->setPassword($request->get('password'));
//        $products->setDescription($request->get("description"));
//        $products->setPrice($request->get("price"));
//        $products->setDiscount($request->get("discount"));
//        $products->setQuantity($request->get("quantity"));
//        $products->setImage($request->get("image"));
//        $cat= $em->getRepository(Category::class)->findOneBy(["category"=>$request->get('category')]);
//        $products->setCategory($cat);

    $json= $normalizer->normalize($users, "json", [
        'attributes' => [
            'id',
            'fullName',
            'password']
    ]);

    $em->flush();
    return new Response(json_encode($json));


}
/**
* @Route("/add", name="app_mobile_add")
*/
public function addGamesMobile(Request $request, NormalizerInterface $normalizer){
$em =$this->getDoctrine()->getManager();
$users= new Users();
$users->setFULLNAME($request->get('fullName'));
$users->setEmail($request->get('email'));
$users->setPassword($request->get('password'));
//        $products->setDescription($request->get("description"));
//        $products->setPrice($request->get("price"));
//        $products->setDiscount($request->get("discount"));
//        $products->setQuantity($request->get("quantity"));
//        $products->setImage($request->get("image"));
//        $cat= $em->getRepository(Category::class)->findOneBy(["category"=>$request->get('category')]);
//        $products->setCategory($cat);
    $json= $normalizer->normalize($users, "json", [
        'attributes' => [
            'fullName',
            'email',
            'password']
    ]);
    $em->persist($users);
    $em->flush();
    return new Response(json_encode($json));

}


    /**
     * @Route("/loginuser", name="login_user")
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function loginapi( UsersRepository $repo,Request $request, serializerInterface $serializer, UserPasswordEncoderInterface $encoder
    ){


        $user=new Users();

        $hash =$encoder->encodePassword($user,$request->query->get("password"));
        $user->setPassword($hash);
        $user=$this->getDoctrine()->getRepository(Users::class)->findOneBy(array('email'=>$request->query->get("login")));
        $userCheck = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array('password'=>$user->getPassword()));

        if($encoder->isPasswordValid($user,$request->query->get("password"))) {
            $json = $serializer->serialize($user, 'json');
            return new Response($json);
        }

        return new Response('Bad credentials');

    }
    /**
     * @Route("/mobile/addCompetitions", name="AddCompetitionsMobile", methods={"POST","GET"})
     */
    public function addCompetitionsMobile(Request $request, NormalizerInterface $normalizer){
        $em= $this->getDoctrine()->getManager();
        $Competitions=new Users();
        $Competitions->setFULLNAME($request->get('fullName'));
        $Competitions->setEmail($request->get('email'));
        $Competitions->setPassword($request->get('password'));

        $json= $normalizer->normalize($Competitions, "json", [
            'fullName' => [
                'email',
                'password']
        ]);
        $em->persist($Competitions);
        $em->flush();
        return new Response(json_encode($json));

    }




}


<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Form\ProfileType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admin")
 */
class BackanduserController extends AbstractController
{
    /**
     * @Route("/", name="backanduser_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
    /**
     * @Route("/listp", name="backanduser_list", methods={"GET"})
     */
    public function listp(UsersRepository $usersRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/listp.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render('user/index.html.twig');

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }


    /**
     * @Route("/new", name="backanduser_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UsersRepository $usersRepository): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user);
            return $this->redirectToRoute('backanduser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backanduser_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backanduser_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, UserPasswordEncoderInterface $userPasswordEncoder,UsersRepository $usersRepository): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )

            );



            $usersRepository->add($user);

            return $this->redirectToRoute('backanduser_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backanduser_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($user);
        }

        return $this->redirectToRoute('backanduser_index', [], Response::HTTP_SEE_OTHER);}

    /**
     * @Route("/profile/{email}", name="backend_profile", methods={"GET"})
     */
    public function showOne($email, Users $user): Response
    {
        $user=$this->getDoctrine()->getRepository(Users::class)->findOneBy(['email' => $email]);
        return $this->render('bachendprofile/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/{email}/edit", name="backend_profile_edit", methods={"GET", "POST"})
     */
    public function editProfile(Request $request, Users $user, UserPasswordEncoderInterface $userPasswordEncoder, UsersRepository $userRepository): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->add($user);
            return $this->redirectToRoute('backend_profile', ['email' => $user->getEmail()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bachendprofile/editProfile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




}

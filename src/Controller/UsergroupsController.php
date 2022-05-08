<?php

namespace App\Controller;

use App\Entity\UserGroups;
use App\Form\UserGroupsType;
use App\Repository\UserGroupsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usergroups")
 */
class UsergroupsController extends AbstractController
{
    /**
     * @Route("/", name="app_usergroups_index", methods={"GET"})
     */
    public function index(UserGroupsRepository $userGroupsRepository): Response
    {
        return $this->render('usergroups/index.html.twig', [
            'user_groups' => $userGroupsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_usergroups_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserGroupsRepository $userGroupsRepository): Response
    {
        $userGroup = new UserGroups();
        $form = $this->createForm(UserGroupsType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userGroupsRepository->add($userGroup);
            return $this->redirectToRoute('app_usergroups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usergroups/new.html.twig', [
            'user_group' => $userGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idUsersGps}", name="app_usergroups_show", methods={"GET"})
     */
    public function show(UserGroups $userGroup): Response
    {
        return $this->render('usergroups/show.html.twig', [
            'user_group' => $userGroup,
        ]);
    }

    /**
     * @Route("/{idUsersGps}/edit", name="app_usergroups_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UserGroups $userGroup, UserGroupsRepository $userGroupsRepository): Response
    {
        $form = $this->createForm(UserGroupsType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userGroupsRepository->add($userGroup);
            return $this->redirectToRoute('app_usergroups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usergroups/edit.html.twig', [
            'user_group' => $userGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idUsersGps}", name="app_usergroups_delete", methods={"POST"})
     */
    public function delete(Request $request, UserGroups $userGroup, UserGroupsRepository $userGroupsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userGroup->getIdUsersGps(), $request->request->get('_token'))) {
            $userGroupsRepository->remove($userGroup);
        }

        return $this->redirectToRoute('app_usergroups_index', [], Response::HTTP_SEE_OTHER);
    }
}

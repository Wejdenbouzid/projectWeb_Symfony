<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController{

/**
     * @Route("/userpage", name="userpage")
     */
    public function userpage(EntityManagerInterface $manager){
        $userRepo = $manager->getRepository(User::class);
        $users = $userRepo->findAll();
        return $this->render("users/userpage.html.twig", [
            "users" => $users
        ]);
    }

    /**
 * @Route("/user", name="user")
 */
public function user(Request $request, EntityManagerInterface $manager){
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $manager->persist($user);
        $manager->flush();
        $this->addFlash("messages", "user ajoutée!");
        return $this->redirectToRoute("userpage");
    }
    return $this->render("users/user.html.twig", [
        "user_form" => $form->createView()
    ]);
}

/**
     * @Route("/users/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("messages", "user modifiée!");
            return $this->redirectToRoute('userpage');
        }

        return $this->render('users/edite.html.twig', [
            'edit' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/usersdelete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
{
    if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash("messages", "user supprimée!");
    }
    return $this->redirectToRoute('userpage');

    
}



}
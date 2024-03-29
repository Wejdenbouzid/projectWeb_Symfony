<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController{

/**
 * @Route("/register", name="register_user")
 */
public function register(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager){
    $user = new User();
    $form = $this->createForm(InscriptionType::class, $user);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $crypted = $encoder->hashPassword($user, $user->getPassword());
        $user->setPassword($crypted);
        $manager->persist($user);
        $manager->flush();
        $this->addFlash("messages", "Utilisateur inscrit!");
        return $this->redirectToRoute("user_login");
    }
    return $this->render("users/registrer.html.twig", [
        "form" => $form->createView()
    ]);
}

/**
 * @Route("/", name="user_login")
 */
public function login(AuthenticationUtils $utils){
    $errors = $utils->getLastAuthenticationError();
    $user = $utils->getLastUsername();
    return $this->render("users/login.html.twig", [
        "error" => $errors,
        "user" => $user
    ]);
    
}

/**
 * @Route("/logout", name="logout")
 */
public function logout(){
}


}
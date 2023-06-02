<?php

namespace App\Controller;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Form\ReponseType;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    /**
     * @Route("/home", name="homepage")
     */
    public function index(EntityManagerInterface $manager){
        $questionRepo = $manager->getRepository(Question::class);
        $questions = $questionRepo->findAll();
        return $this->render("pages/home.html.twig", [
            "questions" => $questions
        ]);
    }

    /**
     * @Route("/show/{titre}/{id<\d+>}", name="show_question")
     */
    public function show($titre, $id, QuestionRepository $questionRepo,Request $request, EntityManagerInterface $manager){
        $question = $questionRepo->find($id);
        if($question == null){
            throw $this->createNotFoundException("Question introuvable!!");
        }
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $reponse->setCreatedAt(new \DateTimeImmutable());
            $reponse->setQuestion($question);
            $manager->persist($reponse);
            $manager->flush();
            $this->addFlash("messages", "Réponse publiée!");
            return $this->redirectToRoute("homepage");
        }
        return $this->render("pages/show.html.twig", [
            "question" => $question,
            "reponses" => $question->getReponses(),
            "states" => Question::$states,
            "form" =>$form->createView()
        ]);
    }

    /**
     * @Route("/create", name="create_question")
     */
    public function create(Request $request, EntityManagerInterface $manager){
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $question->setEtat(1);
            $question->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($question);
            $manager->flush();
            $this->addFlash("messages", "Question publiée!");
            return $this->redirectToRoute("homepage");
        }
        return $this->render("pages/create.html.twig", [
            "question_form" => $form->createView()
        ]);
    }




}
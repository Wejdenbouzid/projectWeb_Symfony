<?php

namespace App\Controller;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Entity\Categorie;
use App\Entity\Formation;
use App\Form\CategorieType;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController{

/**
     * @Route("/categoriepage", name="categoriepage")
     */
    public function categoriepage(EntityManagerInterface $manager){
        $CategorieRepo = $manager->getRepository(Categorie::class);
        $Categories = $CategorieRepo->findAll();
        return $this->render("pages/categoriepage.html.twig", [
            "Categories" => $Categories
        ]);
    }


/**
     * @Route("/showcat/{id<\d+>}", name="show_categorie")
     */
    public function show( $id, CategorieRepository $categorieRepo,Request $request, EntityManagerInterface $manager){
        $categorie = $categorieRepo->find($id);
        if($categorie == null){
            throw $this->createNotFoundException("categorie introuvable!!");
        }
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $livre->setCategorie($categorie);
            $manager->persist($livre);
            $manager->flush();
            $this->addFlash("messages", "livre publiée!");
            return $this->redirectToRoute("livrepage");
        }
        return $this->render("livres/show.html.twig", [
            "categorie" => $categorie,
            "livres" => $categorie->getLivres(),
            "form" =>$form->createView()
        ]);
    }

    /**
     * @Route("/showform/{id<\d+>}", name="show_formation")
     */
    public function showform( $id, CategorieRepository $categorieRepo,Request $request, EntityManagerInterface $manager){
        $categorie = $categorieRepo->find($id);
        if($categorie == null){
            throw $this->createNotFoundException("categorie introuvable!!");
        }
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $formation->setDate(new \DateTimeImmutable());
            $formation->setCategorie($categorie);
            $manager->persist($formation);
            $manager->flush();
            $this->addFlash("messages", "Formation publiée!");
            return $this->redirectToRoute("formationpage");
        }
        return $this->render("formations/show.html.twig", [
            "categorie" => $categorie,
            "formations" => $categorie->getFormations(),
            "form" =>$form->createView()
        ]);
    }


/**
 * @Route("/categorie", name="categorie")
 */
public function categorie(Request $request, EntityManagerInterface $manager){
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $manager->persist($categorie);
        $manager->flush();
        $this->addFlash("messages", "categorie publiée!");
        return $this->redirectToRoute("categoriepage");
    }
    return $this->render("pages/categorie.html.twig", [
        "categorie_form" => $form->createView()
    ]);
}

/**
     * @Route("/categories/{id}/edit", name="Categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("messages", "categorie modifiée!");
            return $this->redirectToRoute('categoriepage');
        }

        return $this->render('pages/edite.html.twig', [
            'edit' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categoriesdelete/{id}", name="categorie_delete", methods={"POST"})
     */
    public function delete(Request $request, Categorie $categorie): Response
{
    if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categorie);
        $entityManager->flush();
        $this->addFlash("messages", "categorie supprimée!");
    }

    return $this->redirectToRoute('categoriepage');
}
    
}
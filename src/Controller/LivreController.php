<?php

namespace App\Controller;
use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Csrf\CsrfToken;

class LivreController extends AbstractController{

/**
     * @Route("/livrepage", name="livrepage")
     */
    public function livrepage(EntityManagerInterface $manager){
        $livreRepo = $manager->getRepository(Livre::class);
        $livres = $livreRepo->findAll();
        return $this->render("livres/livrepage.html.twig", [
            "livres" => $livres
        ]);
    }


/**
 * @Route("/creer", name="creer")
 */
public function creer(){
   
        return $this->redirectToRoute("categoriepage");
  
}

/**
     * @Route("/livre/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("messages", "livre modifiée!");
            return $this->redirectToRoute('livrepage');
        }

        return $this->render('livres/edite.html.twig', [
            'edit' => $livre,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/livresdelete/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre): Response
{
    if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($livre);
        $entityManager->flush();
        $this->addFlash("messages", "livre supprimée!");
    }

    return $this->redirectToRoute('livrepage');
}
    
}
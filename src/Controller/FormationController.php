<?php

namespace App\Controller;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController{

/**
     * @Route("/formationpage", name="formationpage")
     */
    public function formationpage(EntityManagerInterface $manager){
        $formationRepo = $manager->getRepository(Formation::class);
        $formations = $formationRepo->findAll();
        return $this->render("formations/formationpage.html.twig", [
            "formations" => $formations
        ]);
    }


/**
 * @Route("/creerformation", name="creerformation")
 */
public function creerformation(){
   
        return $this->redirectToRoute("categoriepage");
  
}

/**
     * @Route("/formation/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("messages", "formation modifiée!");
            return $this->redirectToRoute('formationpage');
        }

        return $this->render('formations/edite.html.twig', [
            'edit' => $formation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formationsdelete/{id}", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation): Response
{
    if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($formation);
        $entityManager->flush();
        $this->addFlash("messages", "formation supprimée!");
    }

    return $this->redirectToRoute('formationpage');
}
    
}
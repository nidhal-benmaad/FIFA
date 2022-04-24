<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoueurController extends AbstractController
{
    /**
     * @Route("/joueur", name="app_joueur")
     */
    public function index(): Response
    {
        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
        ]);
    }

    /**
     * @Route("/joueurList", name="joueurList")
     */
    public function joueurList(Request $request ): Response
    {
        $joueurs = $this->getDoctrine()->getRepository(Joueur::class)->orderByNbrBut();
        return $this->render("joueur/list.html.twig", array('tabJoueur' => $joueurs));
    }

    /**
     * @Route("/addJoueur", name="addJoueur")
     */
    public function addJoueur(Request $request): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
       $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('addJoueur');
        }

        return $this->render("joueur/add.html.twig", array('joueurForm' => $form->createView()
            ));
    }

    /**
     * @Route("/updateJoueur/{id}", name="updateJoueur")
     */
    public function updateJoueur(Request $request,$id): Response
    {
        $joueur = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('joueurList');
        }

        return $this->render("joueur/update.html.twig", array('joueurForm' => $form->createView()));
    }
}

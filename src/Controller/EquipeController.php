<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="app_equipe")
     */
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    /**
     * @Route("/equipeList", name="equipeList")
     */
    public function equipeList(): Response
    {
        $equipes = $this->getDoctrine()->getRepository(Equipe::class)->findAll();
        $count= $this->getDoctrine()->getRepository(Equipe::class)->countEquipe();
        $searchForm= $this->createForm(SearchType::class);
        if($searchForm->isSubmitted()){
            $nom= $searchForm->getData();
            $result= $this->getDoctrine()->getRepository(Equipe::class)->searchByNom($nom);
            return $this->render("equipe/list.html.twig",
                array('tabEquipe'=>$result,
                    'count'=>$count,
                    'searchForm'=>$searchForm->createView()
                ));
        }
        return $this->render("equipe/list.html.twig", array('tabEquipe' => $equipes, 'count'=>$count,  'searchForm'=>$searchForm->createView()));
    }

    /**
     * @Route("/showEquipe/{id}", name="showEquipe")
     */
    public function showEquipe(Request $request, $id): Response
    {
        $equipe = $this->getDoctrine()->getRepository(Equipe::class)->find($id);
        return $this->render("equipe/show.html.twig", array('equipe' => $equipe));

    }
}

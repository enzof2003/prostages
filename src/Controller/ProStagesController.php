<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages-accueil")
     */
    public function index(): Response
    {
        return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
            'titrePage' => 'Page d\'accueil',
        ]);
    }
	/**
     * @Route("/entreprises/{entrepriseCherche}", name="pro_stages-entreprises")
     */
    public function entreprises($entrepriseCherche): Response
    {
        return $this->render('pro_stages/entreprises.html.twig', [
            'controller_name' => 'ProStagesController',
            'entrepriseCherche' => $entrepriseCherche,
            'titrePage' => 'Recherche par entreprise',
        ]);
    }
	
		/**
     * @Route("/formations/{formationCherche}", name="pro_stages-formations")
     */
    public function formations($formationCherche): Response
    {
        return $this->render('pro_stages/formations.html.twig', [
            'controller_name' => 'ProStagesController',
            'formationCherche' => $formationCherche,
            'titrePage' => 'Recherche par formation',
        ]);
    }
	
		/**
     * @Route("/stages/{id}", name="pro_stages-stages")
     */
    public function stages($id): Response
    {
		return $this->render('pro_stages/stages.html.twig',[
        'id' => $id,
        'titrePage' => 'Stage n°'.$id,
        'titreOffre' => 'Offre de test',
        'entreprise' => 'Entreprise',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce pulvinar a risus a varius. Aliquam id elementum arcu. Mauris non dapibus elit. Proin malesuada mauris et libero mollis, quis tristique justo aliquet. Mauris eu malesuada tellus. Nam sodales vitae mauris at consectetur. Sed sed arcu congue, elementum tortor id, fringilla mauris.',
        'formation' => 'DUT Info',
        'adrMail' => 'test@test.com',
        'siteWeb' => 'test.com',
        'secteur' => 'Debugger'
        ]);
    }
}

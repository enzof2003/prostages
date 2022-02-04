<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages-accueil")
     */
    public function index(): Response
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stages=$repositoryStage->retriveStagesEtEntreprises();
        return $this->render('pro_stages/index.html.twig', [
            'stages'=> $stages,
        ]);
    }
	/**
     * @Route("/entreprises/{id}", name="pro_stages-entreprises")
     */
    public function entreprises($id): Response
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $tupleEntreprise = $repositoryEntreprise->find($id);
        $stages=$repositoryStage->retriveStagesEtEntreprisesParEntreprise($tupleEntreprise->getId());
        $titreEntreprise=$tupleEntreprise->getNom();
        return $this->render('pro_stages/entreprises.html.twig', [
            'entrepriseCherche' => $titreEntreprise,
            'stages'=> $stages,
        ]);
        
    }
	
	/**
     * @Route("/formations/{id}", name="pro_stages-formations")
     */
    public function formations($id): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $formation=$repositoryFormation->Find($id);
        $titreFormation=$formation->getNomLong();
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $listeStages=$repositoryStage-> retriveStagesEtEntreprisesParFormation($titreFormation);
        
        return $this->render('pro_stages/formations.html.twig', [
            'formation'=>$formation,
            'titreFormation'=>$titreFormation,
            'listeStages'=>$listeStages,]);
    }
	
		/**
     * @Route("/stages/{id}", name="pro_stages-stages")
     */
    public function stages($id): Response
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        $stageSelectionne= $repositoryStage->find($id);
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        $tupleEntreprise = $repositoryEntreprise->find($stageSelectionne->getEntreprise());
        

		return $this->render('pro_stages/stages.html.twig',[
        'id' => $id,
        'stage'=> $stageSelectionne,
        'entreprise'=> $tupleEntreprise,
        ]);
    }

    /**
     * @Route("/ajouter/entreprise", name="pro_stages-ajouter-entreprise")
     */
    public function ajouterEntreprise(Request $request, ObjectManager $manager): Response
    {

        $entreprise = new Entreprise();

        //Création du formulaire

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
        ->add('activite')
        ->add('adresse')
        ->add('nom')
        ->add('URLSite')
        ->getForm();

        $formulaireEntreprise->handleRequest($request);

        
        if($formulaireEntreprise->isSubmitted())
        {
            $manager->persist($entreprise);
            $manager->flush();
        }
        
        dump($entreprise);


        //Représentation graphique du form
        $vueFormulaire = $formulaireEntreprise->createView();

        return $this->render('pro_stages/ajoutEntreprise.html.twig', ['vueFormulaire' => $vueFormulaire]);
    }
}

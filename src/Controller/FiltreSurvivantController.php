<?php

namespace App\Controller;


use App\Form\FiltreType;
use App\Repository\SurvivantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\All;

final class FiltreSurvivantController extends AbstractController
{
    #[Route('/filtre/survivant', name: 'app_filtre_survivant')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
	
	    $form = $this->createForm(FiltreType::class);
	    $form->handleRequest($request);

	    if($form->isSubmitted()&&$form->isValid()){
			$data=$form->getData();
			$puissance=$data["puissance"];
			$race=$data['race'];
			$namerace=$race->getRaceName();
			
			
			$survivants = $repository->filters($puissance,$namerace);
			// dd($race->getRaceName());
	    }else{
	    		$survivants = $repository->findAll();
			    
			//     $survivants = $repository->filters("nain");
		}
        return $this->render('filtre_survivant/filtreSurvivant.html.twig', [
            'survivants' => $survivants,
		  "filtreform"=>$form->createView(),
            
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\SurvivantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
	$filter=$request->get("filter","all");
	if($filter == 'all'){
		$survivants = $repository->findAll();
	}elseif($filter =="DESC"){
		$survivants = $repository->ordreDescendant();
     }elseif($filter =="nain"){
		$survivants = $repository->nain(3);
	}elseif($filter =="elf>=25"){
		$survivants = $repository->elf(2);
	}elseif($filter =="archernothumain"){
		$survivants = $repository->archer(3);
		}

        return $this->render('home/index.html.twig', [
            'survivants' => $survivants,
        ]);
    }
}

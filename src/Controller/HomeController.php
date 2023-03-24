<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MissionRepository $missionRepository): Response
    {
        $missions = $missionRepository->findLatest();

        return $this->render('home/index.html.twig', [
            'missions' => $missions,
        ]);
    }
}

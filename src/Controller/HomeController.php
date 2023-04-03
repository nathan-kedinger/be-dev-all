<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionFormType;
use App\ViewModel\MissionViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, MissionViewModel $missionViewModel, EntityManagerInterface $em): Response
    {
        $mission = new Mission;
        $form = $this->createForm(MissionFormType::class, $mission);
        $form->handleRequest($request);
        $page = $request->query->getInt('page', 1);
        $itemsPerPage = 10;

        $searchTerm = $form->get('title')->getData() ?? '';
        $selectedLanguages = $form->get('languages')->getData() ? $form->get('languages')->getData()->toArray() : [];

        $filters = [
            'language' => $request->query->get('language', ''),
        ];
        $missions = $missionViewModel->searchMissions($request, $selectedLanguages, $page, $itemsPerPage, $em);
        //dump($missions);

        return $this->render('home/index.html.twig', [
            'missions' => $missions,
            'form' => $form,
            'filters' => $filters,
        ]);
    }
}

<?php

namespace App\Controller\Mission;

use App\Entity\Mission;
use App\Form\MissionFormType;
use App\Repository\MissionRepository;
use App\ViewModel\MissionViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    #[Route('/mission', name: 'app_mission')]
    public function index(Request $request, MissionViewModel $missionRepository, EntityManagerInterface $em): Response
    {
        $page = $request->query->getInt('page', 1);
        $itemsPerPage = 10;

        $missions = $missionRepository->findPaginatedMissions($page, $itemsPerPage, $em);

        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
        ]);
    }

    #[Route('/nouvelle-mission', name: 'app_new_mission')]
    public function new(Request $request, EntityManagerInterface $em, MissionViewModel $mission): Response
    {
        $form = $this->createForm(MissionFormType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->createMission($em, $this->getUser());

            return $this->redirectToRoute('mission_index');
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }
}
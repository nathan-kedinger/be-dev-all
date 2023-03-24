<?php

namespace App\Controller\Mission;

use App\Entity\Mission;
use App\Form\MissionFormType;
use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    #[Route('/mission', name: 'app_mission')]
    public function index(MissionRepository $missionRepository): Response
    {
        return $this->render('mission/index.html.twig', [
            'missions' => $missionRepository->findAll(),
        ]);
    }

    #[Route('/nouvelle-mission', name: 'app_new_mission')]
    public function new(Request $request): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionFormType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setProfile($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('mission_index');
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mission/{id}', name: 'app_mission_show', methods: "GET")]
    public function show(Mission $mission): Response
    {
        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);
    }
}
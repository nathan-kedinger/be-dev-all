<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, MissionRepository $missionRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $missions = $missionRepository->searchMissions($searchTerm);

        return $this->render('search/missions.html.twig', [
            'missions' => $missions,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/profiles', name: 'search_profiles', methods: "GET")]

    public function searchProfiles(Request $request, UserRepository $userRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $user = $userRepository->searchUsers($searchTerm);

        return $this->render('search/profiles.html.twig', [
            'profiles' => $user,
            'searchTerm' => $searchTerm,
        ]);
    }
}

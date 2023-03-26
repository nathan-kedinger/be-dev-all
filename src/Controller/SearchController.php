<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use App\ViewModel\UserViewModel;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/chercher-un-profil', name: 'search_profiles', methods: "GET")]
    public function searchProfiles(Request $request, UserViewModel $userViewModel, EntityManagerInterface $em): Response
    {
        $searchTerm = $request->query->get('search', '');
        $page = $request->query->getInt('page', 1);
        $itemsPerPage = 10;

        // Get filters from the request
        $filters = [
            'skills' => $request->query->get('skills', ''),
            'experience' => $request->query->getInt('experience', 0),
        ];

        $users = $userViewModel->searchUsers($searchTerm, $page, $itemsPerPage, $filters, $em);

        return $this->render('search/profiles.html.twig', [
            'users' => $users,
            'searchTerm' => $searchTerm,
            'filters' => $filters,
        ]);
    }
}

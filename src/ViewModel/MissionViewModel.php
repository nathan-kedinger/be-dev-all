<?php

namespace App\ViewModel;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;

class MissionViewModel
{
    /**
     * @param EntityManagerInterface $em
     * @param $user
     * @return void
     */
    public function createMission(EntityManagerInterface $em, $user): void
    {
        $mission = new Mission();
        $mission->setUsers($user);

        $em->persist($mission);
        $em->flush();
    }

    public function findPaginatedMissions(int $page, int $itemsPerPage, EntityManagerInterface $em)
    {
        return $em->getRepository(Mission::class)->findPaginatedMissions($page, $itemsPerPage);
    }

    public function searchMissions(string $searchTerm, array$selectedLanguages, int $page, int $itemsPerPage, EntityManagerInterface $em)
    {
        return $em->getRepository(Mission::class)->searchMissions($searchTerm, $selectedLanguages, $page, $itemsPerPage);
    }
}
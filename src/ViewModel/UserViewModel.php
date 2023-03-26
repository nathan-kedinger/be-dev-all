<?php

namespace App\ViewModel;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserViewModel
{
    /**
     *
     * @param EntityManagerInterface $em
     * @return array
     */
    public function findUsers(EntityManagerInterface $em): array
    {
        return $em->getRepository(UserRepository::class)->findAll();
    }

    public function searchUsers(string $searchTerm, int $page, int $itemsPerPage, array $filters,EntityManagerInterface $em)
    {
        return $em->getRepository(User::class)->searchUsers($searchTerm, $page = 1, $itemsPerPage = 10, $filters = []);
    }
}
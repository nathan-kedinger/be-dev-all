<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalProfileController extends AbstractController
{
    #[Route('/personal/profile', name: 'app_personal_profile')]
    public function index(): Response
    {
        return $this->render('personal_profile/index.html.twig', [
            'controller_name' => 'PersonalProfileController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\UserDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserDetailsController extends AbstractController
{
    #[Route('/user/details', name: 'app_user_details_index')]
    public function index(UserDetailsRepository $userDetailsRepository): Response
    {
        $details = $userDetailsRepository->findAll();

        return $this->render('user_details/index.html.twig', [
            'details' => $details,
        ]);
    }
}

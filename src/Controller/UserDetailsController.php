<?php

namespace App\Controller;

use App\Repository\PurchaseRepository;
use App\Repository\UserDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserDetailsController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/users/details', name: 'app_user_details_index')]
    public function index(UserDetailsRepository $userDetailsRepository): Response
    {
        $details = $userDetailsRepository->findAll();

        return $this->render('user_details/index.html.twig', [
            'details' => $details,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/details/{id}', name: 'app_user_details_show')]
    public function show(int $id, UserDetailsRepository $userDetailsRepository, PurchaseRepository $purchaseRepository): Response
    {
        $user = $this->getUser();

        if ($user->getId() !== $id) {
            return $this->redirectToRoute('app_user_details_show', ['id' => $user->getId()]);
        }

        $details = $userDetailsRepository->findOneBy(['user' => $user]);

        if (!$details) {
            throw $this->createNotFoundException('User details not found.');
        }

        $purchases = $purchaseRepository->findBy(['user' => $user]);

        return $this->render('user_details/user.html.twig', [
            'details' => $details,
            'purchases' => $purchases,
        ]);
    }
}

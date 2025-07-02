<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/delete/{id}', name: 'user_delete', methods: ['POST'])]
    public function deleteUsers(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Festival not found.');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('users_index');
    }
}

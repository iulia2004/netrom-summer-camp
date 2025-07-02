<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class FestivalController extends AbstractController
{
    #[Route('/festivals', name: 'festival_index')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        $festivals = $festivalRepository->findAll();

        return $this->render('festival/index.html.twig', [
            'festivals' => $festivals,
        ]);
    }

    #[Route('/festivals/delete/{id}', name: 'festival_delete', methods: ['POST'])]
    public function deleteFestivals(int $id, FestivalRepository $festivalRepository, EntityManagerInterface $entityManager): Response
    {
        $festival = $festivalRepository->find($id);

        if (!$festival) {
            throw $this->createNotFoundException('Festival not found.');
        }

        $entityManager->remove($festival);
        $entityManager->flush();

        return $this->redirectToRoute('festival_index');
    }
}

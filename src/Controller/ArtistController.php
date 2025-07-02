<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    #[Route('/artists', name: 'artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {

        $artists = $artistRepository->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/artists/{id}', name: 'artist_show', methods: ['GET'])]
    public function getArtist(ArtistRepository $artistRepository, int $id): Response
    {
        $artist = $artistRepository->find($id);
        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/artists/delete/{id}', name: 'artist_delete', methods: ['POST'])]
    public function deleteArtist(int $id, ArtistRepository $artistRepository, EntityManagerInterface $entityManager): Response
    {
        $artist = $artistRepository->find($id);

        if (!$artist) {
            throw $this->createNotFoundException('Artist not found.');
        }

        $entityManager->remove($artist);
        $entityManager->flush();

        return $this->redirectToRoute('artist_index');
    }
}

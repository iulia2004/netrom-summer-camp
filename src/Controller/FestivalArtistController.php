<?php

namespace App\Controller;

use App\Repository\FestivalArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FestivalArtistController extends AbstractController
{
    #[Route('/festival/artist', name: 'app_festival_artist')]
    public function index(FestivalArtistRepository $festivalArtistRepository): Response
    {
        $festivalArtists = $festivalArtistRepository->findAll();

        return $this->render('festival_artist/index.html.twig', [
            'controller_name' => 'FestivalArtistController',
            'festivalArtists' => $festivalArtists,
        ]);
    }
}

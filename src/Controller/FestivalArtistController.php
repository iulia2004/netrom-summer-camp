<?php

namespace App\Controller;

use App\Entity\FestivalArtist;
use App\Form\FestivalArtistForm;
use App\Repository\FestivalArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('festival/artist/add', name: 'lineup_add')]
    public function addLineup(Request $request, EntityManagerInterface $entityManager): Response {
        $festivalArtist = new FestivalArtist();
        $form = $this->createForm(FestivalArtistForm::class, $festivalArtist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existing = $entityManager->getRepository(FestivalArtist::class)->findOneBy([
                'festival' => $festivalArtist->getFestival(),
                'artist' => $festivalArtist->getArtist()
            ]);
            if ($existing) {
                $this->addFlash('warning', 'This artist is already part of the selected festival.');
            } else {
                $entityManager->persist($festivalArtist);
                $entityManager->flush();
                $this->addFlash('success', 'Artist added to festival.');
                return $this->redirectToRoute('app_festival_artist');
            }
        }
        return $this->render('festival_artist/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

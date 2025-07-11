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
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class FestivalArtistController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/festival/artist', name: 'app_festival_artist')]
    public function index(FestivalArtistRepository $festivalArtistRepository): Response
    {
        $festivalArtists = $festivalArtistRepository->findAll();

        return $this->render('festival_artist/index.html.twig', [
            'controller_name' => 'FestivalArtistController',
            'festivalArtists' => $festivalArtists,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('festival/artist/add', name: 'lineup_add')]
    public function addLineup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $festivalArtist = new FestivalArtist();
        $form = $this->createForm(FestivalArtistForm::class, $festivalArtist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $festival = $form->get('festival')->getData();
            $artists = $form->get('artists')->getData();
            $repo = $entityManager->getRepository(FestivalArtist::class);

            foreach ($artists as $artist) {
                $exists = $repo->findOneBy(['festival' => $festival, 'artist' => $artist]);
                if (!$exists) {
                    $fa = new FestivalArtist();
                    $fa->setFestival($festival);
                    $fa->setArtist($artist);
                    $entityManager->persist($fa);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Artists added to the festival.');

            return $this->redirectToRoute('festival_index', ['id' => $festival->getId()]);
        }

        return $this->render('festival_artist/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

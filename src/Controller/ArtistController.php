<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistForm;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

//    #[Route('/artists/{id}', name: 'artist_show', methods: ['GET'])]
//    public function getArtist(ArtistRepository $artistRepository, int $id): Response
//    {
//        $artist = $artistRepository->find($id);
//        return $this->render('artist/show.html.twig', [
//            'artist' => $artist,
//        ]);
//    }

    #[IsGranted('ROLE_ADMIN')]
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/artists/add', name: 'artist_add')]
    public function addFestival(Request $request, EntityManagerInterface $entityManager): Response {
        $artist = new Artist();

        $artist->setName('Name');
        $artist->setMusicalGenre('Musical Genre');

        $form = $this->createForm(ArtistForm::class, $artist);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/artists/update/{id}', name: 'artist_update')]
    public function updateArtist(int $id, ArtistRepository $artistRepository, Request $request, EntityManagerInterface $entityManager): Response {
        $artist = $artistRepository->find($id);

        if (!$artist) {
            throw $this->createNotFoundException('Artist not found.');
        }

        $artist->setName($artist->getName());
        $artist->setMusicalGenre($artist->getMusicalGenre());

        $form = $this->createForm(ArtistForm::class, $artist);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            $entityManager->flush();
            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/artist/{id}/festivals', name: 'artist_festivals')]
    public function showFestivals(int $id, EntityManagerInterface $entityManager): Response
    {
        $artist = $entityManager->getRepository(Artist::class)->find($id);

        if (!$artist) {
            throw $this->createNotFoundException('Artist not found');
        }

        $festivalArtists = $artist->getFestivalArtists();

        $festivals = [];
        foreach ($festivalArtists as $fa) {
            $festivals[] = $fa->getFestival();
        }

        return $this->render('artist/festivals.html.twig', [
            'artist' => $artist,
            'festivals' => $festivals,
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Form\FestivalForm;
use App\Repository\ArtistRepository;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


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

    #[IsGranted('ROLE_ADMIN')]
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/festivals/add', name: 'festival_add')]
    public function addFestival(Request $request, EntityManagerInterface $entityManager): Response {
        $festival = new Festival();
        $festival->setName('Name');
        $festival->setLocation('Location');
        $festival->setStartDate(new \DateTimeImmutable('2000-01-01'));
        $festival->setEndDate(new \DateTimeImmutable('2000-01-01'));
        $festival->setPrice('0');

        $form = $this->createForm(FestivalForm::class, $festival);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $festival = $form->getData();

            $entityManager->persist($festival);
            $entityManager->flush();
            return $this->redirectToRoute('festival_index');
        }

        return $this->render('festival/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/festivals/update/{id}', name: 'festival_update')]
    public function updateFestival(int $id, FestivalRepository $festivalRepository, Request $request, EntityManagerInterface $entityManager): Response {
        $festival = $festivalRepository->find($id);

        if (!$festival) {
            throw $this->createNotFoundException('Festival not found.');
        }

        $festival->setName($festival->getName());
        $festival->setLocation($festival->getLocation());
        $festival->setStartDate($festival->getStartDate());
        $festival->setEndDate($festival->getEndDate());
        $festival->setPrice($festival->getPrice());

        $form = $this->createForm(FestivalForm::class, $festival);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $festival = $form->getData();

            $entityManager->flush();
            return $this->redirectToRoute('festival_index');
        }

        return $this->render('festival/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/festival/{id}/artists', name: 'festival_lineup')]
    public function showArtists(int $id, EntityManagerInterface $entityManager): Response
    {
        $festival = $entityManager->getRepository(Festival::class)->find($id);

        if (!$festival) {
            throw $this->createNotFoundException('Festival not found');
        }

        $festivalArtists = $festival->getFestivalArtists();

        $artists = [];
        foreach ($festivalArtists as $fa) {
            $artists[] = $fa->getArtist();
        }

        return $this->render('festival/lineup.html.twig', [
            'festival' => $festival,
            'artists' => $artists,
        ]);
    }

}

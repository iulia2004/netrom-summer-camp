<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\User;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PurchaseController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/purchases', name: 'app_purchase_index')]
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        $purchases = $purchaseRepository->findAll();

        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }
}

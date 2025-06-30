<?php

namespace App\Controller;

use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchases', name: 'app_purchase_index')]
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        $purchases = $purchaseRepository->findAll();

        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }
}

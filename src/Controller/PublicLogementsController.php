<?php

namespace App\Controller;

use App\Entity\Logements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/logements')]
class PublicLogementsController extends AbstractController
{
    #[Route('/', name: 'app_public_logements_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $logements = $entityManager->getRepository(Logements::class)->findAll();

        return $this->render('logements/index.html.twig', [
            'logements' => $logements,
            'is_admin' => $this->isGranted('ROLE_ADMIN'),
        ]);
    }

    #[Route('/{id}', name: 'app_public_logements_show', methods: ['GET'])]
    public function show(Logements $logement): Response
    {
        $isOwner = $this->getUser() && $logement->getOwner() === $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        return $this->render('logements/show.html.twig', [
            'logement' => $logement,
            'can_edit' => $isAdmin || $isOwner,
        ]);
    }
} 
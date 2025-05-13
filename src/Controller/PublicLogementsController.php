<?php

namespace App\Controller;

use App\Entity\Logements;
use App\Form\LogementsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/new', name: 'app_public_logements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_OWNER')) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les droits nécessaires pour ajouter un logement.');
        }

        $logement = new Logements();
        $form = $this->createForm(LogementsType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logement->setDateAjout(new \DateTime());
            $logement->setOwner($this->getUser());
            
            $entityManager->persist($logement);
            $entityManager->flush();

            $this->addFlash('success', 'Le logement a été créé avec succès.');
            return $this->redirectToRoute('app_public_logements_index');
        }

        return $this->render('logements/new.html.twig', [
            'logement' => $logement,
            'form' => $form,
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
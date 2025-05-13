<?php

namespace App\Controller;

use App\Entity\Logements;
use App\Form\LogementsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/logements')]
#[IsGranted('ROLE_ADMIN')]
class LogementsController extends AbstractController
{
    #[Route('/', name: 'app_logements_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $logements = $entityManager->getRepository(Logements::class)->findAll();

        return $this->render('logements/index.html.twig', [
            'logements' => $logements,
        ]);
    }

    #[Route('/new', name: 'app_logements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logement = new Logements();
        $form = $this->createForm(LogementsType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logement->setDateAjout(new \DateTime());
            $logement->setOwner($this->getUser());
            
            $entityManager->persist($logement);
            $entityManager->flush();

            $this->addFlash('success', 'Le logement a été créé avec succès.');
            return $this->redirectToRoute('app_logements_index');
        }

        return $this->render('logements/new.html.twig', [
            'logement' => $logement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logements_show', methods: ['GET'])]
    public function show(Logements $logement): Response
    {
        return $this->render('logements/show.html.twig', [
            'logement' => $logement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logements $logement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogementsType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le logement a été modifié avec succès.');
            return $this->redirectToRoute('app_logements_index');
        }

        return $this->render('logements/edit.html.twig', [
            'logement' => $logement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logements_delete', methods: ['POST'])]
    public function delete(Request $request, Logements $logement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
            $this->addFlash('success', 'Le logement a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_logements_index');
    }
} 
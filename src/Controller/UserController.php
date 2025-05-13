<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/users')]
class UserController extends AbstractController
{
    #[Route('/students', name: 'app_admin_users_students')]
    public function studentsList(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $students = $userRepository->findStudentAccounts();
        
        return $this->render('user/students.html.twig', [
            'students' => $students,
        ]);
    }
} 
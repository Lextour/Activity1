<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        $user = $this->getUser();

        // Check user roles and set appropriate message
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $message = "You are logged in as Admin. You have full access.";
            $messageClass = "admin-message";
        } else {
            $message = "You are logged in as Regular User. Limited access granted.";
            $messageClass = "user-message";
        }

        return $this->render('dashboard/index.html.twig', [
            'message' => $message,
            'messageClass' => $messageClass,
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }
}
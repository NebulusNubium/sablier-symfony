<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PolicyController extends AbstractController
{
    #[Route('/policy', name: 'policy')]
    public function index(): Response
    {
        return $this->render('policy/policy.html.twig', [
        ]);
    }
}

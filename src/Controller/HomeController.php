<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function findLatest(PicturesRepository $picturesRepo): Response
    {
        $latestFour = $picturesRepo->findBy(
            [],
            ['id' => 'DESC'],
            4                          
        );
        return $this->render('home/home.html.twig', [
            'latests' => $latestFour,
        ]);
    }
}

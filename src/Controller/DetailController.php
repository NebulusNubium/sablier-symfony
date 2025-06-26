<?php

namespace App\Controller;

use App\Entity\Pictures;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'detail')]
    public function index(Pictures $picture): Response
    {
        return $this->render('detail/detail.html.twig', [
        'picture'=>$picture,
        ]);
    }
}

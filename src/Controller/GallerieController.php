<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GallerieController extends AbstractController
{
    #[Route('/gallerie', name: 'gallerie')]
    public function index(PicturesRepository $repository): Response
    {
        
        $pictures = $repository->findAll();
        return $this->render('gallerie/gallerie.html.twig', [
        'pictures'=>$pictures,
        ]);
    }
}

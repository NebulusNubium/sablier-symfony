<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Comments;
use App\Form\CommentForm;
use Doctrine\ORM\EntityManager;
use App\Repository\NotesRepository;
use App\Repository\PicturesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GallerieController extends AbstractController
{
    #[Route('/gallerie', name: 'gallerie')]
    public function index(PicturesRepository $repository,NotesRepository $notesRepo, EntityManagerInterface $entityManager): Response
    {
        
        $pictures = $repository->findAll();
        $avg = [];

        foreach ($pictures as $pic) {
            $avg[$pic->getId()] = $notesRepo->findAverageForPicture($pic);
        }
        // dd($pictures);
        return $this->render('gallerie/gallerie.html.twig', [
        'pictures'=>$pictures,
        'avg'=>$avg,
        ]);
    }
}
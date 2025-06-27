<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Pictures;
use App\Form\CommentForm;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'detail')]
    public function addComment(CommentsRepository $repository, Pictures $picture, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comments();
        $comments = $repository->findBy(['picture' => $picture]);
        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
        // 1) on récupère l'utilisateur actuellement connecté
        $user = $this->getUser();
        // 2) on le lie à l'image avant le persist()
        $comment->setUser($user);
        $comment->setPicture($picture);
        // 3) on persiste et flush
        $entityManager->persist($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Commentaire enregistrée !');
        return $this->redirectToRoute('gallerie');
    }
        return $this->render('detail/detail.html.twig', [
        'picture'=>$picture,
        'CommentForm'=> $form->createView(),
        'comments'=> $comments,
        ]);
    }
}
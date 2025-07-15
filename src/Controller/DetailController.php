<?php
// src/Controller/DetailController.php
namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Notes;
use App\Entity\Pictures;
use App\Form\CommentForm;
use App\Repository\CommentsRepository;
use App\Repository\NotesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    #[Route('/detail/{picture}', name: 'detail', methods: ['GET','POST'])]
    public function detail(
        Pictures               $picture,
        Request                $request,
        CommentsRepository     $commentsRepository,
        NotesRepository        $notesRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // 1) Handle comments (unchanged) …
        $comment  = new Comments();
        $form     = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setUser($this->getUser())
                ->setPicture($picture)
            ;
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success','Commentaire enregistré !');
            return $this->redirectToRoute('detail',['picture'=>$picture->getId()]);
        }
        $comments = $commentsRepository->findBy(['picture'=>$picture]);

        // 2) Compute average note
        $avg = $notesRepository->findAverageForPicture($picture);

        // 3) Process vote if any
        $noteValue = $request->query->get('note');
        if ($noteValue !== null) {
            $existing = $notesRepository->findOneBy([
                'user'    => $this->getUser(),
                'picture' => $picture,
            ]);

            if ($existing) {
                $existing->setNote($noteValue);
                $this->addFlash('info','Votre note a été mise à jour.');
            } else {
                $newNote = new Notes();
                $newNote
                    ->addUser($this->getUser())
                    ->addPicture($picture)
                    ->setNote($noteValue);
                $entityManager->persist($newNote);
                $entityManager->flush();
                $this->addFlash('success','Merci pour votre vote !');
            }
            $entityManager->flush();

            return $this->redirectToRoute('detail',['picture'=>$picture->getId()]);
        }

        // 4) Render
        return $this->render('detail/detail.html.twig', [
            'picture'     => $picture,
            'comments'    => $comments,
            'commentForm' => $form->createView(),
            'avg'         => $avg,
        ]);
    }
}

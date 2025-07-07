<?php
// src/Controller/DetailController.php
namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Comments;
use App\Entity\Pictures;
use App\Form\CommentForm;
use App\Repository\CommentsRepository;
use App\Repository\NotesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'detail', methods: ['GET', 'POST'])]
    public function detail(NotesRepository $notesRepository, Pictures $picture,Request $request, CommentsRepository $commentsRepository, EntityManagerInterface $entityManager): Response {
        // edit mode
        $editMode = $request->query->get('edit') === '1';

        // les commentaires
        $comment   = new Comments();
        $comments  = $commentsRepository->findBy(['picture' => $picture]);
        $form      = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setUser($this->getUser())
                ->setPicture($picture);
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire enregistré !');
            return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
        }

        // Les notes:

    $avg = $entityManager
    ->getRepository(Notes::class)
    ->findAverageForPicture($picture);
    $note = new Notes();
    $noteValue = $request->query->get('note');
        if ($noteValue == null ) {
            $note
                ->addUser($this->getUser())
                ->addPicture($picture)
                ->setNote($noteValue);                
            $entityManager->persist($note);
            $entityManager->flush();
        }


        return $this->render('detail/detail.html.twig', [
            'picture'     => $picture,
            'comments'    => $comments,
            'commentForm' => $form->createView(),
            'editMode'    => $editMode,
            'note'=> $note,
            'avg'=>$avg,
        ]);
    }

    #[Route('/detail/{id}/edit', name: 'picture_edit', methods: ['POST'])]
    public function edit(Pictures $picture, Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response 
    {
        // CSRF check
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('edit'.$picture->getId(), $submittedToken)) {
            return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
        }

        // champs Update
        $picture
            ->setNom($request->request->get('nom'))
            ->setDescription($request->request->get('description'))
            ->setSpecificite($request->request->get('specificite'))
            ->setValeur($request->request->get('valeur'))
        ;

        // image
        if ($imageFile = $request->files->get('imageFile')) {
            $orig  = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safe  = $slugger->slug($orig);
            $name  = $safe.'-'.uniqid().'.'.$imageFile->guessExtension();
            try {
                $imageFile->move(
                    $this->getParameter('pictures_directory'),
                    $name
                );
                $picture->setImageName($name);
            } catch (FileException) {
                $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
            }
        }

        $entityManager->flush();
        $this->addFlash('success', 'Modifications enregistrées.');

        return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
    }
}

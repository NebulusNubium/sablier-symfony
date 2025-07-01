<?php
// src/Controller/DetailController.php
namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Pictures;
use App\Form\CommentForm;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'detail', methods: ['GET', 'POST'])]
    public function detail(
        Pictures               $picture,
        Request                $request,
        CommentsRepository     $commentsRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // 1) Determine if we're in edit mode
        $editMode = $request->query->get('edit') === '1';

        // 2) Handle comment submission
        $comment   = new Comments();
        $comments  = $commentsRepository->findBy(['picture' => $picture]);
        $form      = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setUser($this->getUser())
                ->setPicture($picture)
            ;
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire enregistré !');
            return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
        }

        // 3) Render everything
        return $this->render('detail/detail.html.twig', [
            'picture'     => $picture,
            'comments'    => $comments,
            'commentForm' => $form->createView(),  // lowercase!
            'editMode'    => $editMode,
        ]);
    }

    #[Route('/detail/{id}/edit', name: 'picture_edit', methods: ['POST'])]
    public function edit(
        Pictures               $picture,
        Request                $request,
        EntityManagerInterface $entityManager,
        SluggerInterface       $slugger
    ): Response {
        // CSRF check
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('edit'.$picture->getId(), $submittedToken)) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
        }

        // Update fields
        $picture
            ->setNom($request->request->get('nom'))
            ->setDescription($request->request->get('description'))
            ->setSpecificite($request->request->get('specificite'))
            ->setValeur($request->request->get('valeur'))
        ;

        // Optional image upload
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
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
            }
        }

        $entityManager->flush();
        $this->addFlash('success', 'Modifications enregistrées.');

        // Back to view mode
        return $this->redirectToRoute('detail', ['id' => $picture->getId()]);
    }
}

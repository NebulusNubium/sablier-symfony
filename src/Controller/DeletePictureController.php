<?php

namespace App\Controller;

use App\Entity\Pictures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DeletePictureController extends AbstractController
{
    #[Route('/detail/{id}/delete', name: 'deletePicture', methods: ['POST'])]
    public function delete(Pictures $picture, Request $request, EntityManagerInterface $entityManager): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('SUP'.$picture->getId(), $submittedToken)) {
            $entityManager->remove($picture);
            $entityManager->flush();

            $this->addFlash('success', 'La suppression a été effectuée.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide. Suppression annulée.');
        }

        // Always redirect back, whether success or failure
        return $this->redirectToRoute('gallerie');
    }
}

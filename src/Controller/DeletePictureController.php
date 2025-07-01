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
    #[Route('/detail/{id}', name: 'deletePicture')]
    public function delete(Pictures $picture, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("SUP".$picture->getId(), $request->get('_token'))){
            $entityManager->remove($picture);
            $entityManager->flush();
            $this->addFlash("success", "La suppression a été effectuée");
            return $this->redirectToRoute('gallerie');
        }
    }
}
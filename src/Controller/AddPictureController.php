<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Pictures;
use App\Form\AddPictureForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AddPictureController extends AbstractController
{
    #[Route('/addPicture/addPicture.html.twig', name: 'addPicture')]
    public function addDessert(Request $request, EntityManagerInterface $entityManager): Response
    {
        $picture = new Pictures();

        $form = $this->createForm(AddPictureForm::class, $picture);
        $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
        // 1) on récupère l'utilisateur actuellement connecté
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // 2) on le lie à l'image avant le persist()
        $picture->setUser($user);
        // 3) on persiste et flush
        $entityManager->persist($picture);
        $entityManager->flush();

        $this->addFlash('success', 'Image enregistrée !');
        return $this->redirectToRoute('gallerie');
    }
        return $this->render('addPicture/addPicture.html.twig', [
            'addPictureForm'=> $form->createView(),
        ]);
    }
}

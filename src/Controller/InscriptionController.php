<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        dump($user);
        $form = $this->createForm(InscriptionForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
        $passwordEncoder->hashPassword($user,$form->get('password')->getData())
        );
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
        return $this->render('inscription/inscription.html.twig', [
            'user'=>$form->createView(),
        ]);
    }
}

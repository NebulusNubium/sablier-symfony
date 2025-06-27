<?php
// src/Controller/ContactController.php
namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response 
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // on envoie un email
            $email = (new Email())
                ->from($data['email'])
                ->to('toto@gmail.com')
                ->subject('Nouveau message de contact')
                ->text(
                    "Nom: {$data['name']}\n".
                    "Email: {$data['email']}\n\n".
                    "Message:\n{$data['message']}"
                );
            $mailer->send($email);

            // flash & redirection
            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}

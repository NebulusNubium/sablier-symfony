<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use App\services\DateAnniv;
use App\services\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function findLatest(PicturesRepository $picturesRepo, Messages $myMessage, DateAnniv $anniv): Response
    {   
        $HomeMessage = $myMessage->gotMessage();
        $lilou = $anniv->dateAnniv('Lilou', '11-07-2025');
        $latestFour = $picturesRepo->findBy(
            [],
            ['id' => 'DESC'],
            4                          
        );
        return $this->render('home/home.html.twig', [
            'latests' => $latestFour,
            'HomeMessage'=> $HomeMessage,
            'dateAnniv'=>$lilou,
        ]);
    }
}

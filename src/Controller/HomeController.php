<?php

namespace App\Controller;

use App\DTO\PourcentageInputDto;
use App\Repository\PicturesRepository;
use App\services\DateAnniv;
use App\services\Messages;
use App\services\Pourcentage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function findLatest(PicturesRepository $picturesRepo, Messages $myMessage, DateAnniv $anniv, Pourcentage $calculette): Response
    {   
        $HomeMessage = $myMessage->gotMessage();
        $lilou = $anniv->dateAnniv('Lilou', '11-07-2025');
        $number = floatval(45.9);
        $percentage = floatval(5.2);
        $inputDto = new PourcentageInputDto($number, $percentage);
        $outputDto = $calculette->pourcentage($inputDto);
        $latestFour = $picturesRepo->findBy(
            [],
            ['id' => 'DESC'],
            4                          
        );
        return $this->render('home/home.html.twig', [
            'latests' => $latestFour,
            'HomeMessage'=> $HomeMessage,
            'dateAnniv'=>$lilou,
            'result' =>$outputDto,
            'input'=> $number,
            'pourcentage'=>$percentage,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $links = [
            'DIENSTEN',
            'TARIEVEN',
            'CONTACT'
        ];

        $cards = [
          ['title' => 'Cupping - Hacamat', 'image' => 'https://primary.jwwb.nl/pexels/10/10938259.jpeg?enable-io=true&crop=1.4286%3A1&width=347', 'body' => 'Vermindert stress en spanning, bevordert de bloedsomloop en zorgt voor een diepe ontspanning van lichaam en geest.'],
          ['title' => 'Hijama', 'image' => 'https://primary.jwwb.nl/pexels/57/5700928.jpeg?enable-io=true&crop=1.4286%3A1&width=347', 'body' => 'Verbetert de spierfunctie, vermindert pijn en bevordert herstel na inspanning. Ideaal voor sporters en actieve personen.'],
          ['title' => 'Oorkaars therapie', 'image' => 'https://primary.jwwb.nl/pexels/10/10850705.jpeg?enable-io=true&crop=1.4286%3A1&width=347', 'body' => 'Verbetert de huidelasticiteit, vermindert fijne lijntjes en rimpels en zorgt voor een stralende en gezonde huid.'],
          ['title' => 'Laser ontharing', 'image' => 'https://primary.jwwb.nl/pexels/11/11581415.jpeg?enable-io=true&crop=1.4286%3A1&width=347', 'body' => 'Verlicht pijn, vermindert ontstekingen en bevordert de bloedsomloop zonder incisies. Een effectieve en veilige behandelmethode.'],
        ];

        $reviews = [
            ['body' => '"Ik voelde me direct ontspannen en herboren na mijn cupping sessie bij Lotuss-Cupping. Een echte aanrader!"', 'author' => 'Annelies de Vries'],
            ['body' => '"De sportcupping heeft me enorm geholpen bij mijn spierherstel na intensieve trainingen. Ik kan weer voluit gaan!"', 'author' => 'Pieter Janssens'],
            ['body' => '"Mijn huid straalt weer dankzij de gezichtscupping bij Lotuss-Cupping. Ik ben heel blij met het resultaat!"', 'author' => 'Sofie Mertens'],
        ];

        return $this->render('page/index.html.twig', [
            'links' => $links,
            'cards' => $cards,
            'reviews' => $reviews,
        ]);
    }
}

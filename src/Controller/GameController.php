<?php

namespace App\Controller;

use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    function __construct(
        private TrackRepository $repository
    ) {
    }

    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        $tracks = $this->repository->findWithLimit();

        shuffle($tracks);

        return $this->render('game/index.html.twig', [
            'tracks' => $tracks
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/game', name: 'app_game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'new')]
    public function index(): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        return $this->render('game/index.html.twig', [
            'form' => $form
        ]);
    }
}

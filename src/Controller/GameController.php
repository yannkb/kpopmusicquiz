<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Song;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/game', name: 'app_game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'new')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $game->setUuid(Uuid::v4());
        $game->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush($game);

            return $this->redirectToRoute('app_game_start', ['uuid' => $game->getUuid()]);
        }

        return $this->render('game/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{uuid}', name: 'start')]
    public function startGame(EntityManagerInterface $entityManager, string $uuid): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(['uuid' => $uuid]);
        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for uuid ' . $uuid
            );
        }
        $songs = $entityManager->getRepository(Song::class)->findRandom($game->getNumberOfTracks());

        return $this->render('game/play.html.twig', [
            'songs' => $songs
        ]);
    }
}

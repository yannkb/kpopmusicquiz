<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Song;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class GameController extends AbstractController
{
    #[Route('/game/new', name: 'app_game_new')]
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

    #[Route('/{uuid}', name: 'app_game_start')]
    public function startGame(EntityManagerInterface $entityManager, string $uuid): Response
    {
        $game = $entityManager->getRepository(Game::class)->findOneBy(['uuid' => $uuid]);
        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for uuid ' . $uuid
            );
        }

        return $this->render('game/play.html.twig');
    }

    #[Route('/game/song', name: 'app_game_get_song')]
    public function getSong(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $session = $request->getSession();

        $excludedSongsIds = $session->get('excludedSongsIds');

        $song = $entityManager->getRepository(Song::class)->findOneRandom($excludedSongsIds);
        if (!$song) {
            throw $this->createNotFoundException(
                'No song found'
            );
        }

        $excludedSongsIds[] = $song->getId();

        $session->set('excludedSongsIds', $excludedSongsIds);

        return $this->json($song);
    }
}

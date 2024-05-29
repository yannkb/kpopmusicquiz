<?php

namespace App\Controller;

use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GameController extends AbstractController
{
    private TrackRepository $repository;
    private SerializerInterface $serializer;

    function __construct(TrackRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route('/songs/get', name: 'app_game_get_songs')]
    public function getSongs(): JsonResponse
    {
        $tracks = $this->repository->findWithLimit();

        shuffle($tracks);

        $response = $this->serializer->serialize($tracks, 'json');

        return new JsonResponse(base64_encode($response));
    }
}

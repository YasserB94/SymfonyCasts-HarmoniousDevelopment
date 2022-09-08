<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/song', name: 'app_song')]
    public function index(): Response
    {
        return $this->render('song/index.html.twig', [
            'controller_name' => 'SongController',
        ]);
    }
    #[Route('/api/getsong/{id<\d+>}', name: 'api_getsong', methods: 'GET')]
    public function getSong(int $id): Response
    {
        //TODO:: Query to database
        $song = [
            'id' => $id,
            'name' => 'Wonderwall',
            'url' => "http://hcmaslov.d-real.sci-nnov.ru/public/mp3/Oasis/Oasis%20'Wonderwall'.mp3",
        ];
        //return $this->json($song) => same 
        return new JsonResponse($song);
    }
}

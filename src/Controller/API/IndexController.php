<?php

namespace App\Controller\API;

use App\Controller\AbstractApiController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IndexController extends AbstractApiController
{
    /**
     * @var HttpClientInterface
     */
    private $http;

    public function __construct(HttpClientInterface $http) {
        $this->http = $http;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): JsonResponse
    {
        $url = 'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/Shindog?api_key=RGAPI-316ce72d-6b3a-4728-9031-b7d4f3873ce1';

        $resp = $this->http->request(
            'GET',
            $url
        );

        $data = json_decode($resp->getContent(), true);

        return $this->json([
            'data' => $data['puuid']
        ]);
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\LolMatch;
use App\Entity\LolMatchTimeline;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppFixtures extends Fixture
{
    /**
     * @var HttpClientInterface
     */
    private $http;

    /**
     * @var string
     */
    private string $apiKey = 'RGAPI-8d029daf-b7dc-499b-8d48-d23417bb9475';

    public function __construct(HttpClientInterface $http) {
        $this->http = $http;
    }

    public function load(ObjectManager $manager): void
    {
        $urlSumV4ByName = 'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/Shindog?api_key=' . $this->apiKey;

        $resp1 = $this->http->request(
            'GET',
            $urlSumV4ByName
        );

        $data = json_decode($resp1->getContent(), true);

        $puuid = $data['puuid'];

        usleep(2000);

        $urlMatchV5ByPuuid = 'https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/' . $puuid . '/ids?start=0&count=20&api_key=' . $this->apiKey;
        
        $resp2 = $this->http->request(
            'GET',
            $urlMatchV5ByPuuid
        );

        $lastMatch = json_decode($resp2->getContent(), true);

        usleep(2000);

        for ($k = 0; $k < sizeof($lastMatch); $k++) { 

            $urlMatchV5ById = 'https://europe.api.riotgames.com/lol/match/v5/matches/' . $lastMatch[$k] . '?api_key=' . $this->apiKey;
            $matchId = $lastMatch[0];
            $resp3 = $this->http->request(
                'GET',
                $urlMatchV5ById
            );

            $match = (new LolMatch())
                ->setContent(json_decode($resp3->getContent(), true));

            $manager->persist($match);

            usleep(500);

            $urlMatchV5TimelineById = 'https://europe.api.riotgames.com/lol/match/v5/matches/' . $lastMatch[$k] . '/timeline?api_key=' . $this->apiKey;
            
            $resp4 = $this->http->request(
                'GET',
                $urlMatchV5TimelineById
            );

            $matchTimeline = (new LolMatchTimeline())
                ->setContent(json_decode($resp4->getContent(), true));
            
            $manager->persist($matchTimeline);

            $manager->flush(); 
        }
    }
}

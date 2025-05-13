<?php

namespace App\Http\Services;

use App\Interfaces\AiInterface;
use GuzzleHttp\Client;

class ChatgptService implements AiInterface
{
    protected $apiKey;
    protected $client;
    protected $chatGptUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct() 
    {
        $this->client = new Client();
        $this->apiKey = config('services.openai.key');
    }

    public function productPromotionSuggestions($prompt)
    {

        $response = $this->client->post($this->chatGptUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt . "Given this sales data, which products should we promote for higher revenue?",
                    ],
                ]
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

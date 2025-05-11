<?php

namespace App\Http\Repositories;

use GuzzleHttp\Client;

class ChatgptRepository
{
    public function __construct(
        protected $apiKey,
        protected $client,
        protected $chatGptUrl,
    ) {
        $this->client = new Client();
        $this->apiKey = config('services.openai.key');
        $this->chatGptUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function generateArticle($subject)
    {
        $response = $this->client->post($this->chatGptUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Write an article about: " . $subject,
                    ],
                ],
                'max_tokens' => 300,
                'temperature' => 0.7,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

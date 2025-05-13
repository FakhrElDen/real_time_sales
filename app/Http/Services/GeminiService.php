<?php

namespace App\Http\Services;

use App\Interfaces\AiInterface;
use GuzzleHttp\Client;

class GeminiService implements AiInterface
{
    protected $client;
    protected $apiKey;
    protected $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct() 
    {
        $this->client = new Client();
        $this->apiKey = config('services.gemini.key');
    }

    public function productPromotionSuggestions(string $prompt)
    {
        $response = $this->client->post($this->geminiUrl . '?key=' . $this->apiKey, [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt . "Given this sales data, which products should we promote for higher revenue?"]
                        ]
                    ]
                ],
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';
    }
}

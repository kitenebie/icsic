<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class smsai
{
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
    }

    public function ask(string $comment): ?string
    {
        $prompt = <<<EOT
                Generate a professional SMS (120 CHARACTERS ONLY THIS IS FOR SMS SO IT MUST NOT MORE THAN ON 120 CHARACTERS) for this content:
                "$comment"
                Only return the SMS.
            EOT;


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => 'deepseek/deepseek-chat:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

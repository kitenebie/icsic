<?php

namespace App\Services;

use App\Models\AiModel;
use Illuminate\Support\Facades\Http;

class smsai
{
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected string $apiKey, $model;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
        $this->model = AiModel::first()->model;
    }

    public function ask(string $comment): ?string
    {
        $prompt = <<<EOT
                Generate a summary this content:
                "$comment"
                Only return the summary.
            EOT;


        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

    // dd($response->json());
        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

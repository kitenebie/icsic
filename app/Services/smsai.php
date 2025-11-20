<?php

namespace App\Services;

use App\Models\AiModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class smsai
{
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected string $apiKey, $model;

    public function __construct()
    {
        $this->apiKey = "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";
        $this->model = AiModel::first()->model;
    }

    public function ask(string $comment): ?string
    {
        $prompt = <<<EOT
                Summarize the following SMS content into a concise, professional summary suitable for an SMS response. Focus on capturing key details while ensuring brevity (aim for under 160 characters). Preserve abbreviations where they enhance conciseness, handle emojis appropriately (e.g., retain or describe if necessary), and maintain the original language for multilingual inputs.

                Content: "$comment"

                Return only the summarized SMS text.
            EOT;

        Log::info('SMS AI Input: ' . $comment);

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $content = trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
        Log::info('SMS AI Output: ' . $content);

        return $content;
    }
}

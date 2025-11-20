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
Summarize the following SMS content into a concise, professional SMS under 160 characters. Preserve abbreviations. Return only the summary.

Content: "$comment"
EOT;

    Log::info('SMS AI Input: ' . $comment);

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $this->apiKey,
        'Content-Type' => 'application/json',
        'HTTP-Referer' => url('/'),
        'X-Title' => 'SMS Summarizer',
    ])->post($this->apiUrl, [
        'model' => $this->model,
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
    ]);

    if ($response->failed()) {
        Log::error('SMS AI Error: ' . $response->body());
        return 'AI processing error.';
    }
    dd($response->json());

    $content = trim($response->json('choices.0.message.content') ?? 'No response.');

    Log::info('SMS AI Output: ' . $content);

    return $content;
}

}

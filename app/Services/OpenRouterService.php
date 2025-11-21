<?php

namespace App\Services;

use App\Models\AiModel;
use Illuminate\Support\Facades\Http;

class OpenRouterService
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
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => <<<EOT
You are an offensive language detector. Check the comment for rude, offensive, or toxic words in any language. If found, reply 'yes' followed by the words in order. If not, reply 'no'. Consider slurs, insults, altered spellings, obfuscations, repeated characters, and insulting emojis/symbols.
If offensive words exist, reply exactly: yes *word1* *word2* ...
USER COMMENT: "$comment"
EOT
                ],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

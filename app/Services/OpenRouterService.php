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
SYSTEM:
You are a strict offensive-language detector. Check the comment for any rude, offensive, or toxic words in any language.

RULES:
1. If offensive words exist, reply exactly: yes *word1* *word2* ...
2. If no offensive words, reply exactly: no
3. Consider offensive:
   - Slurs, insults, derogatory terms
   - Altered spellings, abbreviations, phonetic versions
   - Obfuscated forms (e.g., f*ck, sh1t)
   - Repeated characters or spacing (e.g., b o b o)
   - Emojis or symbols used as insults
4. List words in the order they appear. Normalize case. No extra words, punctuation, or formatting.

USER COMMENT: "$comment"
EOT
                ],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenRouterService
{
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
    }

    public function ask(string $comment): ?string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => 'deepseek/deepseek-r1-0528:free',
            'messages' => [
                ['role' => 'user', 'content' => <<<EOT
                    SYSTEM:
                    You are a strict offensive-language detector. Your only job is to check comments for any rude, offensive, or toxic words in any language (e.g., English, Tagalog, etc.).

                    RULES:
                    1. If the comment contains offensive words:
                    - Reply exactly: yes *offensive_word1* *offensive_word2* ...
                    - Surround each offensive word with asterisks.
                    2. If there are no offensive words:
                    - Reply exactly: no
                    3. Treat as offensive:
                    - Words intentionally altered (e.g., "bvbv" for "bubu", "obob" for "bobo")
                    - Abbreviations or phonetic spellings (e.g., "tnga" for "tanga")
                    - Words with toxic meaning even if harmless in isolation
                    4. Never include explanations, extra words, punctuation, or formatting beyond the specified output.
                    5. Forbidden words list (non-exhaustive):
                    - *[Insert your bad words list here]*

                    OUTPUT FORMAT (strict):
                    - If offensive words exist: yes *word1* *word2* ...
                    - If no offensive words: no

                    USER COMMENT: "$comment"
                    EOT
                ],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

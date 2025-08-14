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
                    I will give you a comment. Your task is to analyze whether it contains rude or offensive language in **any language** (English, Tagalog, etc.).

                    If there are any offensive words, reply exactly with "yes" followed by the list of those words highlighted with asterisks.  
                    If there are no offensive words, reply exactly with "no".
                    ⚠️ Consider cases like:
                    - Words intentionally altered (e.g. "bvbv" for "bubu", "obob" for "bobo")
                    - Abbreviations or phonetic spellings (e.g. "tnga" for "tanga")
                    - Toxic meanings even if words appear harmless in isolation

                    Format example:
                    yes: *word1*, *word2*
                    or
                    no

                    Comment: "$comment"
                EOT],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

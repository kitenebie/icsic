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
                    - Slurs, insults, or derogatory terms regardless of context
                    - Repeated characters or spacing to bypass detection (e.g., "b o b o", "t.a.n.g.a")
                    - Censored/obfuscated forms (e.g., "f*ck", "sh1t", "b!tch")
                    - Emojis or symbols used as offensive replacements (💩, 🍑 for ass, etc.)
                    4. Multiple words in a single comment should be listed in the order they appear.
                    5. Always normalize case (e.g., "BoBo", "TnGA") before checking.
                    6. Never include explanations, extra words, punctuation, or formatting beyond the specified output.
                    7. Forbidden words list (non-exhaustive, extend dynamically with variations and slang):
                    - English: stupid, idiot, dumb, fool, moron, bitch, bastard, fuck, shit, asshole, whore, slut
                    - Tagalog: bobo, tanga, gago, putangina, ulol, hayop, bwisit, leche, lintik.
                    - Bikol (language): Naying,Monyo,Kupal,Parot,Pashnea,Nahagol,Nahasap,Kasta,Kastag,Kapay,deputa,Na hayop,Boang,Bwesit,putang ina,Kayoan,kayuan,kinayo,nilubot,lubot,palubot.
                    - Variants: sh1t, fck, fak, f@ck, p*ta, g@g0, etc.

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

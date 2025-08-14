<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XSSai
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
            Analyze the following code or input for vulnerabilities such as XSS, SQL injection, CSRF, or command injection.
            Return your answer strictly in JSON format.

            If the content is safe, return:
            {
              "safe": true
            }

            If the content is unsafe, return:
            {
              "safe": false,
              "explanation": "Explain what is vulnerable and why.",
              "context": "Show the original code or input here."
            }

            Here is the code/input: "$comment"
        EOT;

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl, [
            'model' => 'deepseek/deepseek-r1-0528:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return trim($response->json('choices.0.message.content')) ?? 'No response from AI.';
    }
}

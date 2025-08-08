<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenRouterService;

class OpenRouteController extends Controller
{
    public function ask(Request $request, OpenRouterService $openRouterService)
    {
        $reply = $openRouterService->ask($request->input('message'));

        preg_match_all('/\*(.*?)\*/', $reply, $matches);
        $offensiveWords = $matches[1];
        return response()->json(['reply' => $offensiveWords]);
    }
}

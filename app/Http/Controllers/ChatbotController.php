<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChatbotController extends Controller
{
    private string $knowledgeBasePath;
    private string $geminiApiKey;
    private string $geminiModel;

    public function __construct()
    {
        $this->knowledgeBasePath = base_path('knowledge-base');
        $this->geminiApiKey = config('services.gemini.api_key') ?? '';
        $this->geminiModel = config('services.gemini.model', 'gemini-2.0-flash-lite');
    }

    /**
     * Load and combine all markdown knowledge base files
     */
    private function loadKnowledgeBase(): string
    {
        return Cache::remember('gymsathi_knowledge_base', 3600, function () {
            $content = '';
            $files = glob($this->knowledgeBasePath . '/*.md');

            if (empty($files)) {
                return 'GymSathi is a gym management SaaS for Nepal.';
            }

            sort($files);

            foreach ($files as $file) {
                $content .= file_get_contents($file) . "\n\n---\n\n";
            }

            return $content;
        });
    }

    /**
     * Handle incoming chat message using Gemini
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array|max:10',
        ]);

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-2.0-flash-lite');

        if (empty($apiKey)) {
            \Illuminate\Support\Facades\Log::error('Gemini API Error: API Key is missing in config.');
            return response()->json(['reply' => 'Configuration error: API key missing.']);
        }

        $userMessage = trim($request->input('message'));
        $history = $request->input('history', []);
        $knowledgeBase = $this->loadKnowledgeBase();

        // Persona & Instructions
        $systemInstructions = "You are GymSathi's friendly customer support assistant. Your job is to help gym owners and managers understand GymSathi's features, pricing, and how to get started. Respond ONLY based on the knowledge base provided below. Always mention the 30-day free trial. Keep responses short (2-4 sentences). Use the language of the user (Nepali or English).\n\nKNOWLEDGE BASE:\n" . $knowledgeBase;

        // Construct contents for Gemini API (Gemini 1.5 format)
        $contents = [];
        
        // Add Chat History
        foreach (array_slice($history, -6) as $msg) {
            $role = ($msg['role'] === 'user') ? 'user' : 'model';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $msg['content']]]
            ];
        }

        // Add Current Message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        // Call Gemini API v1beta (required for gemini-1.5-flash and newer models)
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl, [
            'system_instruction' => [
                'parts' => [['text' => $systemInstructions]]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 600,
            ]
        ]);

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
            return response()->json([
                'reply' => 'I am having trouble connecting to my brain right now. Please contact support at mind59024@gmail.com.',
            ]);
        }

        $result = $response->json();
        $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'I could not process that at the moment.';

        return response()->json(['reply' => trim($reply)]);
    }
}

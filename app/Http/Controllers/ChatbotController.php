<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private string $knowledgeBasePath;

    private string $groqApiKey;

    private string $groqModel;

    public function __construct()
    {
        $this->knowledgeBasePath = base_path('knowledge-base');
        $this->groqApiKey = config('services.groq.api_key') ?? '';
        $this->groqModel = config('services.groq.model', 'llama3-70b-8192');
    }

    /**
     * Load and combine all markdown knowledge base files
     */
    private function loadKnowledgeBase(): string
    {
        return Cache::remember('gymsathi_knowledge_base', 3600, function () {
            $content = '';
            $files = glob($this->knowledgeBasePath.'/*.md');

            if (empty($files)) {
                return 'GymSathi is a gym management SaaS for Nepal.';
            }

            sort($files);

            foreach ($files as $file) {
                $content .= file_get_contents($file)."\n\n---\n\n";
            }

            return $content;
        });
    }

    /**
     * Handle incoming chat message using Groq Llama
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array|max:10',
        ]);

        $apiKey = config('services.groq.api_key');
        $model = config('services.groq.model', 'llama-3.3-70b-versatile');

        if (empty($apiKey)) {
            Log::error('Groq API Error: API Key is missing in config.');

            return response()->json(['reply' => 'Configuration error: API key missing.']);
        }

        $userMessage = trim($request->input('message'));
        $history = $request->input('history', []);
        $knowledgeBase = $this->loadKnowledgeBase();

        // Persona & Instructions
        $systemPrompt = "You are GymSathi's friendly customer support assistant. Your job is to help gym owners and managers understand GymSathi's features, pricing, and how to get started. Respond ONLY based on the knowledge base provided below. Always mention the 30-day free trial. Keep responses short (2-4 sentences). Use the language of the user (Nepali or English).\n\nKNOWLEDGE BASE:\n".$knowledgeBase;

        // Build messages array for Groq
        $messages = [];

        // Add system prompt
        $messages[] = ['role' => 'system', 'content' => $systemPrompt];

        // Add chat history (last 6 messages)
        foreach (array_slice($history, -6) as $msg) {
            $role = ($msg['role'] === 'user') ? 'user' : 'assistant';
            $messages[] = ['role' => $role, 'content' => $msg['content']];
        }

        // Add current message
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // Call Groq API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => $model,
            'messages' => $messages,
            'temperature' => 0.4,
            'max_tokens' => 600,
        ]);

        if ($response->failed()) {
            Log::error('Groq API Error: '.$response->status().' - '.$response->body());

            return response()->json([
                'reply' => 'I am having trouble connecting to my brain right now. Please contact support at mind59024@gmail.com.',
            ]);
        }

        $result = $response->json();
        $reply = $result['choices'][0]['message']['content'] ?? 'I could not process that at the moment.';

        return response()->json(['reply' => trim($reply)]);
    }
}

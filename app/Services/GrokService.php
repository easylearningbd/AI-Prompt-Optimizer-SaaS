<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GrokService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;
     

    public function __construct()
    {
        $this->apiKey = config('services.grok.api_key');
        $this->baseUrl = config('services.grok.base_url' ,'https://api.x.ai/v1');
        $this->model = config('services.grok.model','grok-3');

        // Log for debuggin purposes
        if (empty($this->apiKey)) {
            Log::warning('Grok API key is not set in configuration');
        } 
    }


    // Optimize a prompt using Grok API 
    public function optimizePrompt(string $rawPrompt, string $category, string $language = 'english', string $outputFormat = 'text'): array 
    {
        // Check if API KEY IS SET 
        if (empty($this->apiKey)) {
           Log::error('Grok API key is missing');
           return [
                'success' => false,
                'error' => 'Grok api key is not configured'
           ];
        }

    try {

        $systemPrompt = $this->buildSystemPrompt($category, $language,$outputFormat);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])
        ->timeout(120)
        ->post($this->baseUrl . '/chat/completions', [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $rawPrompt
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 2000,
            'stream' => false,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $optimizedPrompt = $data['choices'][0]['message']['content'] ?? '';

            return [
                'success' => true,
                'optimized_prompt' => $optimizedPrompt,
                'tokens_used' => $data['usage']['total_tokens'] ?? 0,
                'model_used' => $this->model
            ];
        }

        /// Better error messages base on status code
        $errorMessage = match ($response->status()) {
            401 => 'Invalid API Key, please check your grok api key in the .env file',
            404 => 'Model not found',
            429 => 'Rate limit exceeded',
            500,502,503 => 'Grok api is currently unavailable.',
            default => 'Filed to optimize prompst. Status:' . $response->status(),
        };

        return [
            'success' => false,
            'error' => $errorMessage
        ];
         
    } catch (\Exception $e) {
       return [
            'success' => false,
            'error' => 'An Error occurred while connecting to Grok API ' .$e->getMessage(),
       ];
     } 
    }
    // End optimizePrompt Method 


 /// Build system prompt based on category and language and outputformat

  protected function buildSystemPrompt(string $category, string $language, string $outputFormat): string {
    

  }
  /// End buildSystemPrompt Method 


}

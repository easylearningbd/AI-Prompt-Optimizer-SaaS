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

    $languageInstruction = $language !== 'english'
    ? "You must responsd in " . ucfirst($language) . " language."
    : "";

    $formatInstruction = $outputFormat === 'json'
    ? "You must structure your response as valid JSON format."
    : "Provide the optimized prompt in clear, well-formatted text";

    $categoryGuidance = $this->getCategoryGuidance($category);
   
    return "You are an expert prompt engineer specializing in optimizing AI prompts. 
Your task is to take a basic prompt and transform it into a highly effective, detailed, and professional prompt.

Category: {$category}
{$categoryGuidance}

Guidelines:
1. Make the prompt clear, specific, and actionable
2. Add relevant context and constraints
3. Include examples if helpful
4. Structure the prompt for maximum clarity
5. Preserve the original intent while enhancing effectiveness
6. {$formatInstruction}
7. {$languageInstruction}

Optimize the following prompt to make it more effective:";
 
  }
  /// End buildSystemPrompt Method 

  // get category specific guidance 
  protected function getCategoryGuidance(string $category): string {

    $guidance = [
            'Web Development' => 'Focus on technical accuracy, best practices, and code quality. Include framework/library versions if relevant.',
            'Frontend Prompt Generate' => 'Emphasize UI/UX principles, accessibility, responsive design, and modern frontend technologies.',
            'Backend Dashboard Prompt Generate' => 'Focus on API design, database optimization, security, scalability, and server-side best practices.',
            'Blog' => 'Optimize for engaging content, SEO, readability, and audience targeting.',
            'SEO Friendly Prompt Generate' => 'Focus on keywords, meta descriptions, content structure, and search engine optimization techniques.',
            'Content for Social Media' => 'Optimize for engagement, brevity, platform-specific best practices, and audience interaction.',
            'Facebook viral post' => 'Focus on emotional appeal, shareability, hooks, and Facebook algorithm optimization.',
            'Instagram viral post' => 'Emphasize visual appeal, hashtags, captions, and Instagram-specific engagement tactics.',
            'YouTube script' => 'Structure for video format with intro, body, conclusion, engagement hooks, and call-to-action.',
            'Image prompts' => 'Focus on detailed visual descriptions, style, composition, lighting, and artistic elements.',
            'Video prompts' => 'Include scene descriptions, transitions, pacing, audio elements, and narrative flow.',
        ];

        return $guidance[$category] ?? 'Optimize the prompt for maximum effectiveness and clarity.';

  }
  // End getCategoryGuidance Method 




}

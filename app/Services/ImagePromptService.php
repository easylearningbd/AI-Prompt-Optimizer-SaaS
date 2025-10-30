<?php

namespace App\Services;
use App\Services\GrokService;
use Illuminate\Support\Facades\Log;

class ImagePromptService
{
    protected $grokService;

    public function __construct(GrokService $grokService)
    {
        $this->grokService = $grokService;
    } 

    // Optimize image description in to details prompt 

    public function optimizeImagePrompt(array $data): array {

        try {
            $systemPrompt = $this->buildSystemPrompt($data);
            $userPrompt = $this->buildUserPrompt($data);

            // Use Grok API to optimize 
            $result = $this->grokService->optimizePrompt(
                $userPrompt,
                'Image Generation',
                'english',
                'text'
            );

            if (!$result['success']) {
               return [
                'success' => false,
                'error' => $result['error'],
               ];
            }

            return [
                'success' => true,
                'optimized_prompt' => $result['optimized_prompt'],
                'tokens_used' => $result['tokens_used'] ?? 0,
            ];           


        } catch (\Exception $e) {
           Log::error('Image prompt optimization error', [
            'message' => $e->getMessage(),
           ]);

           return [
            'success' => false,
            'error' => 'An error occurred while optimizing your image prompt'
           ];
        }

    }
    /// End optimizeImagePrompt Method 

    protected function buildSystemPrompt(array $data): string {

        return "You are an expert AI image generation prompt engineer. Your task is to transform basic image descriptions into highly detailed, professional prompts optimized for AI image generation tools like DALL-E, Midjourney, and Stable Diffusion.

Create prompts that are:
1. Highly detailed and specific
2. Include technical photography/art terms
3. Specify composition, lighting, and style
4. Optimized for high-quality outputs
5. Professional and comprehensive

Focus on visual details, artistic style, technical specifications, and mood.";

    }
     /// End buildSystemPrompt Method 


     protected function buildUserPrompt(array $data): string {

        $prompt = "Transfrom this basic image description into a detailed, professional AI image generation prompt:\n\n";
        $prompt .= "Description: {$data['original_description']}\n\n";
        $prompt .= "Parameters:\n";
        $prompt .= "- Style: {$data['style']}\n";
        $prompt .= "- Aspect Ratio: {$data['aspect_ratio']}\n";
        
        if (!empty($data['mood'])) {
            $prompt .= "- Mood: {$data['mood']}\n";
        }
        
        if (!empty($data['lighting'])) {
            $prompt .= "- Lighting: {$data['lighting']}\n";
        }
        
        if (!empty($data['color_palette'])) {
            $prompt .= "- Color Palette: {$data['color_palette']}\n";
        }
        
        $prompt .= "- Quality: {$data['quality_level']}\n\n";
        
        $prompt .= "Create a single, comprehensive prompt that incorporates all these elements. Include technical details, artistic direction, and quality modifiers. Make it ready to use directly in an AI image generator.";

         return $prompt;
    }
     /// End buildUserPrompt Method 

     public function getStyleSuggestions(string $style): array {

        $suggestions = [
            'realistic' => [
                'lighting' => ['natural light', 'golden hour', 'studio lighting', 'soft lighting'],
                'quality' => ['photorealistic', 'high detail', '8K resolution', 'professional photography'],
                'mood' => ['natural', 'authentic', 'candid', 'documentary'],
            ],
            'artistic' => [
                'lighting' => ['dramatic', 'moody', 'ethereal', 'atmospheric'],
                'quality' => ['masterpiece', 'trending on artstation', 'award winning', 'highly detailed'],
                'mood' => ['expressive', 'emotive', 'creative', 'imaginative'],
            ],
            'anime' => [
                'lighting' => ['vibrant', 'cel-shaded', 'dramatic shadows', 'anime lighting'],
                'quality' => ['high quality anime art', 'studio ghibli style', 'detailed anime', '2D animation'],
                'mood' => ['dynamic', 'expressive', 'colorful', 'stylized'],
            ],
            'digital_art' => [
                'lighting' => ['cinematic', 'volumetric', 'rim lighting', 'neon'],
                'quality' => ['digital painting', 'concept art', 'artstation', 'octane render'],
                'mood' => ['futuristic', 'fantasy', 'sci-fi', 'imaginative'],
            ],
            '3d_render' => [
                'lighting' => ['studio lighting', 'hdri', 'global illumination', 'ray tracing'],
                'quality' => ['3D rendering', 'octane render', 'unreal engine', 'high poly'],
                'mood' => ['clean', 'professional', 'polished', 'detailed'],
            ],

        ];

        return $suggestions[$style] ?? $suggestions['realistic'];

     }
     /// End getStyleSuggestions Method 




}

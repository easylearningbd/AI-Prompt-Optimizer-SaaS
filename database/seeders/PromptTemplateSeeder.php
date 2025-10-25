<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\PromptTemplate;

class PromptTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Blog Post Generator',
                'category' => 'Blog',
                'description' => 'Create engaging blog posts on any topic with customizable tone and style.',
                'template_content' => 'Write a comprehensive {word_count} word blog post about {topic} for {target_audience}. The tone should be {tone} and include {key_points}. Make it SEO-friendly and engaging.',
                'placeholders' => [
                    ['key' => 'word_count', 'label' => 'Word Count', 'type' => 'text', 'placeholder' => 'e.g., 1500', 'required' => true],
                    ['key' => 'topic', 'label' => 'Topic', 'type' => 'text', 'placeholder' => 'Main topic of your blog post', 'required' => true],
                    ['key' => 'target_audience', 'label' => 'Target Audience', 'type' => 'text', 'placeholder' => 'e.g., small business owners', 'required' => true],
                    ['key' => 'tone', 'label' => 'Tone', 'type' => 'text', 'placeholder' => 'e.g., professional, casual, friendly', 'required' => true],
                    ['key' => 'key_points', 'label' => 'Key Points', 'type' => 'textarea', 'placeholder' => 'List main points to cover', 'required' => true],
                ],
                'example_output' => 'Write a comprehensive 1500 word blog post about Email Marketing for small business owners. The tone should be friendly and practical and include tips on list building, email design, automation, and measuring success. Make it SEO-friendly and engaging.',
                'difficulty_level' => 'beginner',
                'icon' => 'ri-article-line',
                'is_featured' => true,
            ],
            [
                'name' => 'Social Media Caption Creator',
                'category' => 'Content for Social Media',
                'description' => 'Generate catchy social media captions with hashtags and call-to-actions.',
                'template_content' => 'Create {number} engaging {platform} captions about {topic} for {brand_voice} brand. Include {hashtag_count} relevant hashtags and a clear call-to-action.',
                'placeholders' => [
                    ['key' => 'number', 'label' => 'Number of Captions', 'type' => 'text', 'placeholder' => 'e.g., 5', 'required' => true],
                    ['key' => 'platform', 'label' => 'Platform', 'type' => 'text', 'placeholder' => 'Instagram, Facebook, LinkedIn', 'required' => true],
                    ['key' => 'topic', 'label' => 'Topic', 'type' => 'text', 'placeholder' => 'What is the post about?', 'required' => true],
                    ['key' => 'brand_voice', 'label' => 'Brand Voice', 'type' => 'text', 'placeholder' => 'e.g., professional, fun, inspiring', 'required' => true],
                    ['key' => 'hashtag_count', 'label' => 'Number of Hashtags', 'type' => 'text', 'placeholder' => 'e.g., 5-10', 'required' => true],
                ],
                'example_output' => 'Create 5 engaging Instagram captions about sustainable fashion for eco-conscious brand. Include 8 relevant hashtags and a clear call-to-action.',
                'difficulty_level' => 'beginner',
                'icon' => 'ri-chat-3-line',
                'is_featured' => true,
            ],
            [
                'name' => 'Product Description Writer',
                'category' => 'SEO Friendly Prompt Generate',
                'description' => 'Write compelling product descriptions that sell and rank well in search engines.',
                'template_content' => 'Write a compelling {word_count} word product description for {product_name} - {product_type}. Target audience is {target_customer}. Highlight {key_features} and include {seo_keywords} for SEO. Focus on benefits over features.',
                'placeholders' => [
                    ['key' => 'word_count', 'label' => 'Word Count', 'type' => 'text', 'placeholder' => 'e.g., 200', 'required' => true],
                    ['key' => 'product_name', 'label' => 'Product Name', 'type' => 'text', 'placeholder' => 'Name of the product', 'required' => true],
                    ['key' => 'product_type', 'label' => 'Product Type', 'type' => 'text', 'placeholder' => 'e.g., wireless headphones', 'required' => true],
                    ['key' => 'target_customer', 'label' => 'Target Customer', 'type' => 'text', 'placeholder' => 'Who is buying this?', 'required' => true],
                    ['key' => 'key_features', 'label' => 'Key Features', 'type' => 'textarea', 'placeholder' => 'List main features', 'required' => true],
                    ['key' => 'seo_keywords', 'label' => 'SEO Keywords', 'type' => 'text', 'placeholder' => 'Keywords to include', 'required' => true],
                ],
                'example_output' => 'Write a compelling 200 word product description for AirPods Pro - wireless earbuds. Target audience is tech-savvy millennials. Highlight noise cancellation, battery life, seamless Apple integration and include wireless earbuds, noise cancelling, Apple AirPods for SEO. Focus on benefits over features.',
                'difficulty_level' => 'intermediate',
                'icon' => 'ri-shopping-bag-line',
                'is_featured' => false,
            ],
            [
                'name' => 'YouTube Script Outline',
                'category' => 'YouTube script',
                'description' => 'Create structured YouTube video scripts with intro, body, and outro.',
                'template_content' => 'Create a {duration} minute YouTube video script about {topic} for {audience}. Include an attention-grabbing intro, {main_points} main points in the body, and a strong call-to-action outro. Tone should be {tone}.',
                'placeholders' => [ 
                    ['key' => 'duration', 'label' => 'Video Duration', 'type' => 'text', 'placeholder' => 'e.g., 10', 'required' => true],
                    ['key' => 'topic', 'label' => 'Video Topic', 'type' => 'text', 'placeholder' => 'Main topic', 'required' => true],
                    ['key' => 'audience', 'label' => 'Target Audience', 'type' => 'text', 'placeholder' => 'Who is watching?', 'required' => true],
                    ['key' => 'main_points', 'label' => 'Number of Main Points', 'type' => 'text', 'placeholder' => 'e.g., 5', 'required' => true],
                    ['key' => 'tone', 'label' => 'Tone/Style', 'type' => 'text', 'placeholder' => 'e.g., educational, entertaining', 'required' => true],
                ],
                'example_output' => 'Create a 10 minute YouTube video script about starting a podcast for aspiring content creators. Include an attention-grabbing intro, 5 main points in the body, and a strong call-to-action outro. Tone should be encouraging and practical.',
                'difficulty_level' => 'intermediate',
                'icon' => 'ri-youtube-line',
                'is_featured' => true,
            ],
            [
                'name' => 'Email Marketing Campaign',
                'category' => 'Content for Social Media',
                'description' => 'Design complete email marketing campaigns with subject lines and body copy.',
                'template_content' => 'Create a {campaign_type} email campaign for {product_service} targeting {audience}. Include a compelling subject line (under {subject_length} characters), preview text, body copy with {tone} tone, and clear CTA. Goal: {campaign_goal}.',
                'placeholders' => [
                    ['key' => 'campaign_type', 'label' => 'Campaign Type', 'type' => 'text', 'placeholder' => 'e.g., promotional, newsletter, welcome', 'required' => true],
                    ['key' => 'product_service', 'label' => 'Product/Service', 'type' => 'text', 'placeholder' => 'What are you promoting?', 'required' => true],
                    ['key' => 'audience', 'label' => 'Target Audience', 'type' => 'text', 'placeholder' => 'Who receives this?', 'required' => true],
                    ['key' => 'subject_length', 'label' => 'Subject Line Length', 'type' => 'text', 'placeholder' => 'e.g., 50', 'required' => true],
                    ['key' => 'tone', 'label' => 'Tone', 'type' => 'text', 'placeholder' => 'e.g., professional, friendly', 'required' => true],
                    ['key' => 'campaign_goal', 'label' => 'Campaign Goal', 'type' => 'text', 'placeholder' => 'What action do you want?', 'required' => true],
                ],
                'example_output' => 'Create a promotional email campaign for new software product targeting small business owners. Include a compelling subject line (under 50 characters), preview text, body copy with professional yet friendly tone, and clear CTA. Goal: drive free trial signups.',
                'difficulty_level' => 'advanced',
                'icon' => 'ri-mail-line',
                'is_featured' => false,
            ],
        ];

    foreach($templates as $templateData){
        $category = Category::where('name', $templateData['category'])->first();

        if ($category) {
            PromptTemplate::create([
                'category_id' => $category->id,
                'name' => $templateData['name'],
                'description' => $templateData['description'],
                'template_content' => $templateData['template_content'],
                'placeholders' => $templateData['placeholders'],
                'example_output' => $templateData['example_output'],
                'difficulty_level' => $templateData['difficulty_level'],
                'icon' => $templateData['icon'],
                'is_active' => true,
                'is_featured' => $templateData['is_featured'],
                'order' => 0, 
            ]);
        }

    }
 






    }
}

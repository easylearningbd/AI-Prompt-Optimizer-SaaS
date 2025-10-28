<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PromptTemplate;
use App\Models\Category;
use App\Services\GrokService;
use App\Models\UserTemplateVariation;

class TemplateController extends Controller
{
    protected $grokService;

    public function __construct(GrokService $grokService){
        $this->grokService = $grokService; 
    }


    public function TemplatePromptsIndex(Request $request){

        $query = PromptTemplate::active()->with('category');

        // Filter by category 
        if ($request->filled('category')) {
            $query->where('category_id',$request->category);
        }

        // Filter by Difficulty  
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level',$request->difficulty);
        }

        /// Search function 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('name','like','%{$search}%')
                    ->orWhere('description','like','%{$search}%');
            });
        }

     // Sort 
     $sort = $request->get('sort','popular');
     switch ($sort) {
        case 'popular':
            $query->orderBy('usage_count','desc');
            break;
        case 'newest':
        $query->latest();
        break; 
        default:
             $query->orderBY('order')->orderBy('created_at','desc');
     }

     $templates = $query->paginate(12);
     $categories = Category::active()->get();
     $featuredTemplates = PromptTemplate::featured()->with('category')->take(3)->get();

     return view('client.backend.templates.index_page',compact('templates','categories','sort','featuredTemplates')); 

    }
    // End Method


    public function TemplatePromptsShow(PromptTemplate $template){

        $template->load('category');

        $relatedTemplates = PromptTemplate::active()
                ->where('category_id', $template->category_id)
                ->where('id', '!=', $template->id)
                ->orderBy('usage_count','desc')
                ->take(4)
                ->get(); 
        return view('client.backend.templates.show_page',compact('template','relatedTemplates'));

    }
     // End Method

    public function TemplatePromptsUse(PromptTemplate $template){

        // Check subscription limits 
        if (!auth()->user()->canOptimizePrompt() && !auth()->user()->isAdmin()) {
            return redirect()->route('template.prompts.show',$template)->with('error','You have reached your montly prompt limit. Please upgrade your plan');
        }

        $template->load('category');
        return view('client.backend.templates.use_page',compact('template'));
    }
     // End Method

     public function TemplatePromptsGenerate(Request $request, PromptTemplate $template){

        /// Check subscription limits 
        if (!auth()->user()->canOptimizePrompt() && !auth()->user()->isAdmin()) {
            return back()->with('error','You have reached your montly prompt limit. Please upgrade your plan');
        }

        // Build Vaildation on field and placeholders 

        $rules = [
            'variation_name' => 'nullable|string',
            'language' => 'required|in:english,spanish,french,german,chinese,japanese,hindi,bengali',
            'output_format' => 'required|in:text,json'
        ];

        foreach($template->placeholders as $placeholder ){
            $fieldRules = [];

            if ($placeholder['required'] ?? false) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

             $fieldRules[] = 'string';

             if ($placeholder['type'] === 'text') {
                $fieldRules[] = 'max:500';
             }

             $rules['placeholders.' . $placeholder['key']] = implode('|',$fieldRules);
            
        }

        $validated = $request->validate($rules);

        $filledPrompt = $template->fillTemplate($validated['placeholders']);

        // Optimize with Grok Api 
        $result = $this->grokService->optimizePrompt(
            $filledPrompt,
            $template->category->name,
            $validated['language'],
            $validated['output_format'], 
        );

        if (!$result['success']) {
            return back()
            ->withInput()
            ->with('error',$result['error']);
        }

        //// Generate variation name if not provided 
        $variationName = $validated['variation_name'] ?? ( $template->name . ' - ' . now()->format('M d, Y h:i A'));

        /// Save data in Variation Table 
        $variation = UserTemplateVariation::create([
            'user_id' => auth()->id(),
            'template_id' => $template->id,
            'variation_name' => $variationName,
            'filled_placeholders' => $validated['placeholders'],
            'generated_prompt' => $filledPrompt,
            'optimized_prompt' => $result['optimized_prompt']
        ]);

        /// Increment tamplate usage count
        $template->incrementUsage();

        /// Increment user usage count 
        if (!auth()->user()->isAdmin()) {
            auth()->user()->increment('prompts_used_this_month');
        }


        return redirect()->route('template.prompts.index')->with('success','Template Optimized successfully!');

     }
       // End Method



} 

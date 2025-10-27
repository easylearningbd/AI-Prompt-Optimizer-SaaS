<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PromptTemplate;
use App\Models\Category;
use App\Services\GrokService;

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



} 

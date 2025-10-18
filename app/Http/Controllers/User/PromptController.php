<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Prompt;
use App\Models\Category;
use App\Services\GrokService;

class PromptController extends Controller
{

    protected $grokService;

    public function __construct(GrokService $grokService){
        $this->grokService = $grokService; 
    }



    public function PromptIndexPage(Request $request){

        $query = Prompt::with(['user','category']);

        // Filter by category 
        if ($request->filled('category')) {
            $query->where('category_id',$request->category);
        }

        /// Search function 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('title','like','%{$search}%')
                    ->orWhere('raw_prompt','like','%{$search}%')
                    ->orWhere('optimized_prompt','like','%{$search}%');
            });
        }

     // Sort 
     $sort = $request->get('sort','latest');
     switch ($sort) {
        case 'trending':
            $query->orderByRaw('(views_count + copies_count * 3) DESC');
            break;
        case 'most_viewed':
        $query->orderBy('views_count', 'desc');
        break; 
        default:
             $query->latest();
     }

     $prompts = $query->paginate(12);
     $categories = Category::active()->get();

     return view('client.backend.prompts.index_page',compact('prompts','categories','sort')); 

    }
    // End Method 


    public function PromptsCreate(){

        $categories = Category::active()->get();
        $languages = [
            'english' => 'English',
            'spanish' => 'Spanish',
            'french' => 'French',
            'german' => 'German',
            'chinese' => 'Chinese',
            'japanese' => 'Japanese',
            'hindi' => 'Hindi',
            'bengali' => 'Bengali',
        ];

    return view('client.backend.prompts.create_page',compact('categories','languages'));
    }
      // End Method 


    public function PromptsStore(Request $request){

        $validated = $request->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'raw_prompt' => 'required|string|min:10',
            'language' => 'required|string',
            'output_format' => 'required|in:text,json',
            'is_public' => 'boolean', 
        ]);

    $category = Category::findOrFail($validated['category_id']);

    /// Optimize prompt using Grok API
    


    }
    // End Method 




}

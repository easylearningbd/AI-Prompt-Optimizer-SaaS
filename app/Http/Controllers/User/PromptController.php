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
    $result = $this->grokService->optimizePrompt(
        $validated['raw_prompt'],
        $category->name,
        $validated['language'],
        $validated['output_format'],

    );

    if (!$result['success']) {
        return back()->withInput()->with('error', $result['error']);
    }

    /// Create or store to Prompt table 
    $prompt = auth()->user()->prompts()->create([
        'title' => $validated['title'],
        'raw_prompt' => $validated['raw_prompt'],
        'optimized_prompt' => $result['optimized_prompt'],
        'category_id' => $validated['category_id'],
        'language' => $validated['language'],
        'output_format' => $validated['output_format'],
        'is_public' => $request->boolean('is_public', true), 

    ]);

    /// Increment user usage count 
    if (!auth()->user()->isAdmin()) {
       auth()->user()->increment('prompts_used_this_month');
    }

    return redirect()->route('prompts.page')->with('success','Prompt Optimized successfully');

    }
    // End Method 

    public function PromptsShow(Prompt $prompt){

        if (!$prompt->is_public || !$prompt->is_approved) {
            if (!auth()->check() || (auth()->id() !== $prompt->user_id && !auth()->user()->isAdmin() ) ) {
               abort(404);
            }
        }

    $prompt->load(['user','category']);
    $relatedPrompts = Prompt::public()
        ->where('category_id', $prompt->category_id)
        ->where('id', '!=', $prompt->id)
        ->latest()
        ->take(5)
        ->get();

        return view('client.backend.prompts.show_page',compact('prompt','relatedPrompts'));
    }
    // End Method 




}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ImagePrompt;
use App\Models\Category;
use App\Services\ImagePromptService;
 
class ImagePromptController extends Controller
{

    protected $imagePromptService;

    public function __construct(ImagePromptService $imagePromptService){
        $this->imagePromptService = $imagePromptService; 
    }

    
    public function ImagePromptsIndex(Request $request){

     $query = ImagePrompt::public()->with(['user','category']);

     // Filter by category 
        if ($request->filled('category')) {
            $query->where('category_id',$request->category);
        }

        // Filter by Style 
        if ($request->filled('style')) {
            $query->where('style',$request->style);
        }

        /// Search function 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('title','like','%{$search}%')
                    ->orWhere('original_description','like','%{$search}%');
            });
        }

     // Sort 
     $sort = $request->get('sort','latest');
     switch ($sort) {
        case 'popular':
            $query->orderByRaw('(views_count + copies_count * 3) DESC');
            break;
        case 'most_viewed':
        $query->orderBy('views_count', 'desc');
        break; 
        default:
             $query->latest();
     }

     $imagePrompts = $query->paginate(12);
     $categories = Category::active()->get();

     return view('client.backend.image-prompts.index_page',compact('imagePrompts','categories','sort')); 
 
    }
    //End Method 

    public function ImagePromptsCreate(){

        $categories = Category::active()->get();
        $styles = [
            'realistic' => 'Realistic/Photography',
            'artistic' => 'Artistic/Painting',
            'anime' => 'Anime/Manga',
            'digital_art' => 'Digital Art',
            '3d_render' => '3D Render',
            'oil_painting' => 'Oil Painting',
            'watercolor' => 'Watercolor',
            'sketch' => 'Sketch/Drawing',
        ];
        $aspectRatios = [ 
            '1:1' => 'Square (1:1)',
            '16:9' => 'Landscape (16:9)',
            '9:16' => 'Portrait (9:16)',
            '4:3' => 'Standard (4:3)',
            '3:2' => 'Classic (3:2)',
        ];

        return view('client.backend.image-prompts.create_page',compact('categories','styles','aspectRatios'));
    }
     //End Method 

     public function ImagePromptsStore(Request $request){

         /// Check subscription limits 
        if (!auth()->user()->canOptimizePrompt() && !auth()->user()->isAdmin()) {
            return back()->with('error','You have reached your montly prompt limit. Please upgrade your plan');
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'original_description' => 'required|string',
            'style' => 'required|string',
            'aspect_ratio' => 'required|string',
            'mood' => 'nullable|string',
            'lighting' => 'nullable|string',
            'color_palette' => 'nullable|string',
            'quality_level' => 'required|in:standard,hd,4k,8k',
            'title' => 'required|string',
            'is_public' => 'boolean',
        ]);

        // Optimize the prompt using Grok API 
        $result = $this->imagePromptService->optimizeImagePrompt($validated);

        if (!$result['success']) {
            return back()->withInput()->with('error', $result['error']);
        }

        /// Store data in your image_prompts table 
        $imagePrompt = ImagePrompt::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'original_description' => $validated['original_description'],
            'optimized_prompt' => $result['optimized_prompt'],
            'style' => $validated['style'],
            'aspect_ratio' => $validated['aspect_ratio'],
            'mood' => $validated['mood'],
            'lighting' => $validated['lighting'],
            'color_paletter' => $validated['color_palette'],
            'quality_level' => $validated['quality_level'],
            'is_public' => $request->boolean('is_public',true),
        ]);


        if (!auth()->user()->isAdmin()) {
            auth()->user()->increment('prompts_used_this_month');
        }

       $notification = array(
            'message' => 'Image Prompt optimized Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('image.prompts.index')->with($notification); 
     }
      //End Method 

    public function ImagePromptsShow(ImagePrompt $imagePrompt ){

        $imagePrompt->incrementViews();
        $imagePrompt->load(['user','category']);

        return view('client.backend.image-prompts.show_page',compact('imagePrompt'));
    }
     //End Method 


}

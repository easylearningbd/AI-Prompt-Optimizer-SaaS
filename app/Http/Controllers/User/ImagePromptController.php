<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ImagePrompt;
use App\Models\Category;

class ImagePromptController extends Controller
{
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


}

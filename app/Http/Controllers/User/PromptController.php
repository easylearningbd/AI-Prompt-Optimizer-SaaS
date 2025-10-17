<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Prompt;
use App\Models\Category;

class PromptController extends Controller
{
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




}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\PromptTemplate;

class AdminTemplateController extends Controller
{
    public function AdminTemplatesIndex(){

        $templates = PromptTemplate::with('category')
            ->latest()
            ->paginate(10);
        return view('admin.backend.templates.template_index',compact('templates'));
    }
    // End Method 

    public function AdminTemplatesShow(PromptTemplate $template){
        
        $template->load(['category','variations']);
        return view('admin.backend.templates.template_show',compact('template'));
    }
    // End Method 

    public function AdminTemplatesEdit(PromptTemplate $template){

        $categories = Category::active()->get();
         return view('admin.backend.templates.template_edit',compact('categories','template'));

    }
    // End Method 

    public function AdminTemplatesUpdate(Request $request , PromptTemplate $template){

        $validated = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'template_content' => 'required|string',
            'placeholders' => 'required|array|min:1',
            'placeholders.*.key' => 'required|string',
            'placeholders.*.label' => 'required|string',
            'placeholders.*.type' => 'required|in:text,textarea,select',
            'placeholders.*.placeholder' => 'nullable|string',
            'placeholders.*.required' => 'nullable|boolean',

            'example_output' => 'nullable|string',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean', 
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);

        //// 


    }
     // End Method 



}

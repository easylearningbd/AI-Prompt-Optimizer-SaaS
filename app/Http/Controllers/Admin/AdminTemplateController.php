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



}

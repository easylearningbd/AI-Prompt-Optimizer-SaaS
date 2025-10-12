<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function AllCategory(){
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));

    }
    //End Method 

    public function AddCategory(){
        return view('admin.backend.category.add_category');
    }
    //End Method 

    public function StoreCategory(Request $request){

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'order' => $request->order,
        ]);

         $notification = array(
            'message' => 'Category Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    }
    //End Method 

    public function EditCategory($id){
        $category = Category::find($id);
        return view('admin.backend.category.edit_category',compact('category'));

    }
    //End Method 

     public function UpdateCategory(Request $request , $id){

        Category::find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'order' => $request->order,
        ]);

         $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    }
    //End Method 

    public function DeleteCategory($id){
        Category::find($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
     //End Method 


}
 
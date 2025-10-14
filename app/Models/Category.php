<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
  
    protected $casts = [
        'is_active' => 'boolean' 
    ];
    
    /// Auto-generate slug from category name
    protected static function boot(){
        parent::boot();

        static::creating(function($category){
            if (empty($category->slug)) {
               $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function($category){
            if ($category->isDirty('name') && empty($category->slug)) {
                 $category->slug = Str::slug($category->name);
            }
        });
    }


    /// Ge active Category 
    public function scopeActive($query){
        return $query->where('is_active',true)->orderBy('order');
    }

}

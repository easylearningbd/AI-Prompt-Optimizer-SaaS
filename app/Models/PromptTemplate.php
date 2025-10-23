<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PromptTemplate extends Model
{
      use HasFactory;
 
    protected $guarded = [];
  
    protected $casts = [
        'placeholders' => 'array', 
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($template) {
            if (empty($template->slug)) {
               $template->slug = Str::slug($template->name);
            }
        });
    }


   public function category(){
        return $this->belongsTo(Category::class);
    }



}
 
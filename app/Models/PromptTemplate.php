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

     public function variations(){
        return $this->hasMany(UserTemplateVariation::class, 'template_id');
    }
  
    /// Scopes 
    public function scopeActive($query){
        return $query->where('is_active',true);
    }

     public function scopeFeatured($query){
        return $query->where('is_featured',true)->where('is_active',true);
    }

     public function scopeDifficulty($query, $level){
        return $query->where('difficulty_level',$level);
    }

    // Helper Method 
    public function incrementUsage(){
        $this->increment('usage_count');
    }

    public function fillTemplate(array $values): string {
        $content = $this->template_content;

        foreach($values as $key => $value){
            $content = str_replace('{' . $key . '}',$value,$content);
        }
        return $content;
    }





}
 
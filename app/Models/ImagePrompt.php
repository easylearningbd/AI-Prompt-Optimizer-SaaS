<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImagePrompt extends Model
{
    use HasFactory;
 
    protected $guarded = [];
  
    protected $casts = [ 
        'is_public' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

     public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopePublic($query){
        return $query->where('is_public',true);
    }

     /// Increment Copies 
    public function incrementCopies(){
        $this->increment('copies_count');
    }

    /// Increment Views 
    public function incrementViews(){
        $this->increment('views_count');
    }



}
 
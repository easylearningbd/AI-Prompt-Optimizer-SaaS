<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prompt extends Model
{
    use HasFactory;
 
    protected $guarded = [];
  
    protected $casts = [
        'is_featured' => 'boolean', 
        'is_approved' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

     public function category(){
        return $this->belongsTo(Category::class);
    }


    public function scopePublic($query){
        return $query->where('is_public',true)->where('is_approved', true);
    }

    public function scopeFeatured($query){
        return $query->where('is_featured',true)->where('is_approved', true);
    }

    public function scopeTrending($query){
        return $query->where('is_approved',true)
            ->orderByRaw('(views_count + copies_count * 3) DESC')
            ->orderBy('created_at' ,'desc') ;
    }

    public function scopePopular($query){
        return $query->where('is_approved',true)
            ->orderBy('views_count','desc');
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

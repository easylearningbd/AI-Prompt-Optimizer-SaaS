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




}

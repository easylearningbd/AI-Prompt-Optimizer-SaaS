<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTemplateVariation extends Model
{
    use HasFactory;
 
    protected $guarded = [];
  
    protected $casts = [
        'filled_placeholders' => 'array', 
        'is_favorite' => 'boolean', 
    ];


     public function user(){
        return $this->belongsTo(User::class);
    }
 
     public function template(){
        return $this->belongsTo(PromptTemplate::class, 'template_id');
    }

    /// Helper method 
    public function toggleFavorite(){
        $this->is_favorite = !$this->is_favorite;
        $this->save();
    }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // Check if subscription is active
    public function isActive(): bool {
        return $this->status === 'approved'
        && $this->starts_at <= now()
        && $this->ends_at >= now();
    }

    //
    public function scopePending($query) {
        return $query->where('status','pending');
    }

    public function scopeApproved($query) {
        return $query->where('status','approved');
    }

    public function scopeAtive($query){
        return $query->where('status', 'approved')
        ->where('starts_at', '<=', now())
        ->where('ends_at', '>=', now());
    }
 

}

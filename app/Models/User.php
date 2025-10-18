<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // Check if user is admin 
    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function canOptimizePrompt(): bool {
        if ($this->isAdmin()) {
           return true;
        }

        $limits = [
            'free' => 5,
            'pro' => 10,
            'essential' => 20,
        ];

        return $this->prompts_used_this_month < ($limits[$this->subscription_plan] ?? 0);
    }

    /// Get remaining prompts limit
    public function getRemainingPromptsAttribute(): int {
        if ($this->isAdmin()) {
            return 999;
        }

        $limits = [
                'free' => 5,
                'pro' => 10,
                'essential' => 20,
            ];

    $limit = $limits[$this->subscription_plan] ?? 0; 
    return max(0, $limit - $this->prompts_used_this_month); 

    }

 
     public function prompts(){
        return $this->hasMany(Prompt::class);
    }

    public function user(){
        return $this->hasMany(Subscription::class);
    }
 

    


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

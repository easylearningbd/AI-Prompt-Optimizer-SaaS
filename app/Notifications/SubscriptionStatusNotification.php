<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class SubscriptionStatusNotification extends Notification
{
    use Queueable;

    protected $subscription;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, string $status)
    {
        $this->subscription = $subscription;
        $this->status = $status;
    }

   
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) 
    {
    if ($this->status === 'approved') {
        return (new MailMessage)
        ->subject('Subscription Approved - Prompt Library')
        ->greeting('Hello ' . $notifiable->name . '!') 
        ->line('Your ' . strtoupper($this->subscription->plan) . ' plan subscription has beed approved!') 
        ->line('Amount: $ ' . number_format($this->subscription->amount)) 
        ->line('Valid From: ' . $this->subscription->starts_at->format('M d, Y'))
        ->line('Valid Until: ' . $this->subscription->ends_at->format('M d, Y'))   
        ->action('View Dashboard', url('/dashboard'))
        ->line('Thank you for Upgrading!');
    } else {
         return (new MailMessage)
        ->subject('Subscription Updated - Prompt Library')
        ->greeting('Hello ' . $notifiable->name . '!') 
        ->line('Your subscription request has been' . $this->status . '.') 
        ->line('Reason ' . ($this->subscription->admin_notes ?? 'No reason provided'))  
        ->action('View Subscriptions', route('pending.subscription'))
        ->line('If you have any questions please contact with support team'); 
    }
        
    }
 
    public function toArray($notifiable)
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan' => $this->subscription->plan,
            'status' => $this->status,
            'plan' => $this->subscription->amount,
        ];
    }
}

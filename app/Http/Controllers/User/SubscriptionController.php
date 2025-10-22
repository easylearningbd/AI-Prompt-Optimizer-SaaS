<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function SubscriptionsIndex(){

        $subscriptions = auth()->user()
            ->subscriptions()
            ->latest()
            ->paginate(10);

        return view('client.backend.subscriptions.index_page',compact('subscriptions'));

    }
    // End Method 

    public function SubscriptionsCreate(){

        $plans = [
            'pro' => [
                'name' => 'Pro Plan',
                'price' => 9.99,
                'duration' => '30 days',
                'limit' => 10
            ],
            'essential' => [
                'name' => 'Essential Plan',
                'price' => 19.99,
                'duration' => '30 days',
                'limit' => 20
            ],
        ];

        return view('client.backend.subscriptions.create_page',compact('plans'));

    }
    // End Method 


    public function SubscriptionsStore(Request $request){

        $validated = $request->validate([
            'plan' => 'required|in:pro,essential',
            'transaction_id' => 'required',
            'payment_proof' => 'required|image|mimes:png,jpg,jpeg,pdf|max:5120'
        ]);

        $amounts = [
            'pro' => 9.99,
            'essential' => 19.99,
        ];

        // Store payment proof 
        $path = $request->file('payment_proof')->store('payment_proofs','public');

        // store data in subscription table 
        Subscription::create([
            'user_id' => auth()->id(), 
            'plan' => $validated['plan'],
            'amount' => $amounts[$validated['plan']],
            'transaction_id' => $validated['transaction_id'],
            'payment_proof' => $path,
            'status' => 'pending',  
        ]);

         $notification = array(
            'message' => 'Subscription request submitted! Wait for admin Approval',
            'alert-type' => 'success'
            );

        return redirect()->route('subscriptions.index')->with($notification);

    }
     // End Method 

    public function PendingSubscription(){
        $pendingsub = Subscription::where('status','pending')->latest()->get();
        return view('admin.backend.subscription.pending_subscription',compact('pendingsub'));
    }
    // End Method 





}

@extends('client.dashboard')
@section('client')
<div class="page-container">
    <div class="bg-light py-4 border-bottom">
        <div class="container">
            <h1 class="h3 fw-bold mb-0">My Subscriptions</h1>
            <p class="text-muted mb-0">Manage your subscription plans and payment history</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Current Plan Card -->
<div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-star-fill"></i> Current Plan
            </h5>
        </div>
        <div class="card-body text-center">
            <div class="mb-3">
                <span class="badge bg-primary fs-5 px-4 py-2">
                    {{ strtoupper(auth()->user()->subscription_plan ) }}
                </span>
            </div>

    @php
        $limits = [
            'free' => 5,
            'pro' => 10,
            'essential' => 20,
        ];

        $limit = $limits[auth()->user()->subscription_plan] ?? 0; 
    @endphp
            

            <h2 class="display-4 fw-bold text-primary">
               {{ auth()->user()->prompts_used_this_month }}/{{ $limit }}
            </h2>
            <p class="text-muted">Prompts used this month</p>

            <!-- Progress Bar -->
            @php
                $percentage = $limit > 0 ? (auth()->user()->prompts_used_this_month / $limit) * 100 : 0;
            @endphp
            <div class="progress mb-3" style="height: 25px;">
        <div 
            class="progress-bar {{ $percentage > 80 ? 'bg-danger' : ($percentage > 50 ? 'bg-warning' : 'bg-success') }} " 
            role="progressbar" 
            style="width: {{ min($percentage, 100) }}%"
        >
            {{ round($percentage) }}%
        </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Remaining:</span>
                    <strong class="text-success">{{ auth()->user()->remaining_prompts }}</strong>
                </div>
                 @if (auth()->user()->subscription_renewed_at) 
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Renews on:</span>
                        <strong>{{ auth()->user()->subscription_renewed_at->addMonth()->format('M d, Y') }}</strong>
                    </div>
                 @endif
                
            </div>

    @if (auth()->user()->subscription_plan !== 'essential' ) 
    <a href="{{ route('subscriptions.create') }}" class="btn btn-primary w-100">
        <i class="bi bi-arrow-up-circle"></i> Upgrade Plan
    </a>
    @else 
    <button class="btn btn-success w-100" disabled>
        <i class="bi bi-check-circle-fill"></i> Best Plan Active
    </button>
     @endif    
            
        </div>
    </div>
</div>

<!-- Subscription History -->
<div class="col-lg-8">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-clock-history"></i> Subscription History
            </h5>
        </div>
<div class="card-body">

@if ($subscriptions->count() > 0)  
<div class="table-responsive">
<table class="table table-hover">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($subscriptions as $subscription) 
        <tr>
            <td>
                <span class="badge bg-primary">
                  {{ strtoupper($subscription->plan ) }}
                </span>
            </td>
            <td>
                <strong>${{ $subscription->amount }}</strong>
            </td>
            <td>
                  @if ($subscription->status === 'approved')
                        
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle-fill"></i> Approved
                    </span>
                  @elseif ($subscription->status === 'pending')
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-clock-fill"></i> Pending
                    </span>
                  @else 
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle-fill"></i> Rejected
                    </span>
                  @endif
            </td>
            <td>
                <small>{{ $subscription->created_at->format('M d, Y') }}</small>
            </td>
            <td>
                <button 
                    class="btn btn-sm btn-outline-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#detailModal{{ $subscription->id }}"
                >
                    <i class="bi bi-eye"></i> View
                </button>
            </td>
        </tr>
        @endforeach 
        
    </tbody>
   </table>
   </div>


        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $subscriptions->links() }}
        </div>

    @else     
    
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h5 class="mt-3">No Subscription History</h5>
            <p class="text-muted">You haven't made any subscription payments yet.</p>
            <a href="{{ route('subscriptions.create') }}" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Upgrade Your Plan
            </a>
        </div>
    @endif
</div>
    </div>
</div>
</div>
    </div>
</div>

<!-- Detail Modals --> 
@foreach ($subscriptions as $item) 
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt"></i> Subscription Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Plan</label>
                            <div class="fw-bold">{{ strtoupper($item->plan) }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Amount</label>
                            <div class="fw-bold">${{$item->amount}}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Status</label>
                            <div>
        @if ($item->status === 'approved')                
        <span class="badge bg-success">Approved</span>
        @elseif ($item->status === 'pending')
        <span class="badge bg-warning text-dark">Pending</span>
        @else                        
        <span class="badge bg-danger">Rejected</span>
        @endif                     
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Transaction ID</label>
                            <div class="fw-bold">{{ $item->transaction_id }} </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Submitted</label>
                            <div>{{ $item->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                      @if ($item->starts_at)  
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Valid Period</label>
                                <div>
                                   {{ $item->starts_at->format('M d, Y') }} - 
                                   {{ $item->ends_at->format('M d, Y') }}
                                </div>
                            </div>
                       @endif
                       
                    </div>

                    @if ($item->payment_proof)  
                        <div class="mb-3">
                            <label class="text-muted small">Payment Proof</label>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' .$item->payment_proof) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-file-earmark-image"></i> View Payment Proof
                                </a>
                            </div>
                        </div>
                     @endif
                   

              @if ($item->admin_notes) 
                <div class="alert alert-info">
                    <strong>Admin Notes:</strong>
                    <p class="mb-0">{{ $item->admin_notes }}</p>
                </div>
             @endif
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
 @endforeach
 
 
@endsection
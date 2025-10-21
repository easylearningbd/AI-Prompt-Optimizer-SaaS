@extends('client.dashboard')

@section('client')
<div class="page-container">
    <div class="bg-gradient-primary py-5 text-white">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-3">Upgrade Your Plan</h1>
            <p class="lead mb-0">Choose the perfect plan for your needs</p>
        </div>
    </div>

    <div class="container py-5">
        <!-- Current Plan Alert -->
        <div class="alert alert-info d-flex align-items-center mb-5">
            <i class="bi bi-info-circle-fill fs-3 me-3"></i>
            <div>
                <strong>Current Plan: {{ strtoupper(auth()->user()->subscription_plan) }} </strong>
                <br>
                <small>You have <strong>{{ auth()->user()->remaining_prompts }}</strong> prompt optimizations remaining this month.</small>
            </div>
        </div>

        <!-- Pricing Plans -->
        <div class="row justify-content-center mb-5">
        @php
            $plans = [
                'free' => [
                    'name' => 'Free',
                    'price' => 0,
                    'limit' => 5,
                    'features' => [
                        '5 prompt optimizations per month',
                        'Access to all category',
                        'Community features',
                        'Basic Support',
                  ],
                'current' => auth()->user()->subscription_plan === 'free'
              ],
            'pro' => [
                    'name' => 'Pro',
                    'price' => 9.99,
                    'limit' => 10,
                    'features' => [
                        '10 prompt optimizations per month',
                        'Access to all category',
                        'Priority Community features',
                        'JSON Export Support',
                        'Email Support',
                  ],
                'current' => auth()->user()->subscription_plan === 'pro'
              ], 
              'essential' => [
                    'name' => 'Essential',
                    'price' => 19.99,
                    'limit' => 20,
                    'features' => [
                        '20 prompt optimizations per month',
                        'Access to all category',
                        'Priority Community features',
                        'JSON Export Support',
                        'Priority Email Support',
                  ],
                'current' => auth()->user()->subscription_plan === 'essential'
              ], 
        ];
        @endphp
            

    @foreach ($plans as $key => $plan ) 
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow {{ $key === 'pro' ? 'border-primary' : '' }} {{ $plan['current'] ? 'border-success border-3' : '' }}  ">
                
            @if ($key === 'pro' && !$plan['current']) 
                <div class="card-header bg-primary text-white text-center">
                    <small class="fw-bold">MOST POPULAR</small>
                </div>
                 @endif
            
                @if ($plan['current'])  
                <div class="card-header bg-success text-white text-center">
                    <small class="fw-bold">CURRENT PLAN</small>
                </div>
                @endif
            
            <div class="card-body text-center d-flex flex-column">
                <h3 class="card-title fw-bold">{{ $plan['name'] }} </h3>
                <div class="my-4">
                    <span class="h1 fw-bold">${{ $plan['price'] }}</span>
                    @if ($plan['price'] > 0) 
                        <span class="text-muted">/month</span>
                   @endif
                    
                </div>
                <p class="text-muted mb-4">
                    <strong>{{ $plan['limit'] }} prompts</strong> per month
                </p>
                <ul class="list-unstyled text-start mb-4 flex-grow-1">
                    @foreach ($plan['features'] as $feature) 
                        <li class="mb-2">
                            <i class="ri-arrow-right-s-fill"></i>
                             {{$feature}}   
                        </li>
                    @endforeach 
                </ul>
                
   @if ($plan['current'])     
    <button class="btn btn-success w-100" disabled>
        <i class="bi bi-check-circle-fill"></i> Current Plan
    </button>
    @elseif($key === 'free')
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100">
        View Dashboard
    </a>
     @else 
    <button 
        class="btn btn-primary w-100" 
        data-bs-toggle="modal" 
        data-bs-target="#upgradeModal{{ ucfirst($key) }}"
    >
        Upgrade to {{ $plan['name'] }} 
    </button>
    @endif   
                
            </div>
        </div>
    </div>
  @endforeach    
           
        </div>

        <!-- How It Works -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle-fill"></i> How to Upgrade
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold fs-4">1</span>
                        </div>
                        <h6 class="fw-bold">Select Plan</h6>
                        <p class="small text-muted">Choose the plan that fits your needs</p>
                    </div>
                    <div class="col-md-3 mb-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold fs-4">2</span>
                        </div>
                        <h6 class="fw-bold">Make Payment</h6>
                        <p class="small text-muted">Transfer to our bank account</p>
                    </div>
                    <div class="col-md-3 mb-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold fs-4">3</span>
                        </div>
                        <h6 class="fw-bold">Submit Proof</h6>
                        <p class="small text-muted">Upload payment screenshot</p>
                    </div>
                    <div class="col-md-3 mb-3 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold fs-4">4</span>
                        </div>
                        <h6 class="fw-bold">Get Activated</h6>
                        <p class="small text-muted">We'll activate within 24 hours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upgrade Modals -->
  @foreach (['pro' => 9.99, 'essential' => 19.99] as $planKey => $price )
    <div class="modal fade" id="upgradeModal{{ ucfirst($planKey) }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-credit-card"></i> Upgrade to   Plan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action=" " method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="plan" value=" ">
                    
                    <div class="modal-body">
                        <!-- Bank Details -->
                        <div class="alert alert-info">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-bank"></i> Bank Transfer Details
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Bank Name:</strong> Example Bank
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Account Name:</strong> Prompt Library Inc.
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Account Number:</strong> 1234567890
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Routing Number:</strong> 987654321
                                </div>
                                <div class="col-md-12 mt-2">
                                    <strong>Amount to Transfer:</strong> 
                                    <span class="badge bg-success fs-6">$3</span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction ID -->
                        <div class="mb-3">
                            <label for="transaction_id_ " class="form-label fw-bold">
                                Transaction ID / Reference Number <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('transaction_id') is-invalid @enderror" 
                                id="transaction_id_ " 
                                name="transaction_id" 
                                placeholder="Enter your transaction ID"
                                required
                            >
                            @error('transaction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Enter the transaction ID from your bank transfer receipt
                            </small>
                        </div>

                        <!-- Payment Proof -->
                        <div class="mb-3">
                            <label for="payment_proof_ " class="form-label fw-bold">
                                Payment Proof (Screenshot/Receipt) <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="file" 
                                class="form-control @error('payment_proof') is-invalid @enderror" 
                                id="payment_proof_ " 
                                name="payment_proof" 
                                accept="image/*,.pdf"
                                required
                            >
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Upload a clear screenshot of your payment confirmation (JPG, PNG, or PDF, max 5MB)
                            </small>
                        </div>

                        <!-- Preview Area -->
                        <div id="preview_ " class="mb-3 d-none">
                            <label class="form-label fw-bold">Preview:</label>
                            <img id="preview_img_ " src="" class="img-fluid border rounded" style="max-height: 300px;">
                        </div>

                        <!-- Terms -->
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Important:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Your subscription will be activated within 24 hours after verification</li>
                                <li>Make sure the transaction ID and payment proof are accurate</li>
                                <li>Invalid or fake submissions will be rejected</li>
                                <li>Subscription is valid for 30 days from activation date</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Submit for Verification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
  @endforeach
 

<script>
// Image preview for both modals
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const planKey = this.id.replace('payment_proof_', '');
        const preview = document.getElementById('preview_' + planKey);
        const previewImg = document.getElementById('preview_img_' + planKey);
        const file = e.target.files[0];
        
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('d-none');
            }
        } else {
            preview.classList.add('d-none');
        }
    });
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>

@endsection
@extends('client.dashboard')
@section('client') 
 <div class="page-container">
 
<div class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-0">
                    <i class="bi bi-plus-circle"></i> Create New Prompt
                </h1>
                <p class="text-muted mb-0">Transform your basic prompt into an optimized masterpiece</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if (!auth()->user()->isAdmin()) 
                    <div class="alert alert-info mb-0 p-2 small">
                        <i class="bi bi-info-circle"></i>
                        <strong>{{ auth()->user()->remaining_prompts }} </strong> optimizations remaining
                    </div>
                @else 
                    <div class="alert alert-success mb-0 p-2 small">
                        <i class="bi bi-infinity"></i>
                        <strong>Unlimited</strong> (Admin)
                    </div>
                @endif
               
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
        <form method="POST" action="{{ route('prompts.store') }}" id="promptForm">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="form-label fw-bold">
                    Prompt Title <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control form-control-lg @error('title') is-invalid @enderror" 
                    id="title" 
                    name="title" 
                    placeholder="E.g., Blog Post About AI Technology"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Give your prompt a descriptive title</small>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="form-label fw-bold">
                    Category <span class="text-danger">*</span>
                </label>
                <select 
                    class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                    id="category_id" 
                    name="category_id"
                    required
                >
                    <option value="">Select a category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select> 
                <small class="text-muted">Choose the category that best fits your prompt</small>
            </div>

            <!-- Raw Prompt -->
            <div class="mb-4">
                <label for="raw_prompt" class="form-label fw-bold">
                    Your Basic Prompt <span class="text-danger">*</span>
                </label>
                <textarea 
                    class="form-control @error('raw_prompt') is-invalid @enderror" 
                    id="raw_prompt" 
                    name="raw_prompt" 
                    rows="6"
                    placeholder="Enter your basic prompt here. Example: Write a blog post about artificial intelligence and its impact on healthcare."
                    required
                >{{ old('raw_prompt') }}</textarea>
                @error('raw_prompt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">
                        <i class="bi bi-lightbulb"></i> Enter your basic idea - we'll optimize it for you!
                    </small>
                    <small class="text-muted" id="charCount">0 characters</small>
                </div>
            </div>

            <div class="row">
                <!-- Language -->
                <div class="col-md-6 mb-4">
                    <label for="language" class="form-label fw-bold">
                        Language <span class="text-danger">*</span>
                    </label>
                    <select 
                        class="form-select @error('language') is-invalid @enderror" 
                        id="language" 
                        name="language"
                        required
                    >
                        @foreach($languages as $key => $lang)
                            <option value="{{ $key }}" {{ old('language', 'english') == $key ? 'selected' : '' }}>
                                {{ $lang }}
                            </option>
                        @endforeach
                    </select> 
                    <small class="text-muted">
                        <i class="bi bi-translate"></i> Output language for optimization
                    </small>
                </div>

                <!-- Output Format -->
                <div class="col-md-6 mb-4">
                    <label for="output_format" class="form-label fw-bold">
                        Output Format <span class="text-danger">*</span>
                    </label>
                    <select 
                        class="form-select @error('output_format') is-invalid @enderror" 
                        id="output_format" 
                        name="output_format"
                        required
                    >
                        <option value="text" {{ old('output_format', 'text') == 'text' ? 'selected' : '' }}>
                            <i class="bi bi-file-text"></i> Text Format
                        </option>
                        <option value="json" {{ old('output_format') == 'json' ? 'selected' : '' }}>
                            <i class="bi bi-file-earmark-code"></i> JSON Format
                        </option>
                    </select>
                    @error('output_format')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="bi bi-file-earmark-code"></i> Choose your preferred format
                    </small>
                </div>
            </div>

            <!-- Visibility -->
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_public" 
                        name="is_public" 
                        value="1"
                        {{ old('is_public', true) ? 'checked' : '' }}
                    >
                    <label class="form-check-label fw-bold" for="is_public">
                        Make this prompt public
                    </label>
                    <div>
                        <small class="text-muted">
                            <i class="bi bi-globe"></i> Allow other users to view and learn from this prompt
                        </small>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-2 justify-content-between align-items-center pt-3 border-top">
                <a href=" " class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span id="btnText">Optimize Prompt</span>
                    <span id="btnLoader" class="d-none">
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Optimizing...
                    </span>
                </button>
            </div>
        </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightbulb-fill"></i> Tips for Better Prompts
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Be Specific:</strong> Include details about what you want
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Add Context:</strong> Explain the purpose or goal
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Mention Audience:</strong> Who is this for?
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Set Tone:</strong> Formal, casual, technical?
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Include Examples:</strong> If helpful
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Example Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-file-text-fill"></i> Example
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted fw-bold">BASIC PROMPT:</small>
                        <p class="small mb-0 mt-1">
                            "Write a blog post about AI"
                        </p>
                    </div>
                    <div class="text-center my-2">
                        <i class="bi bi-arrow-down text-primary"></i>
                    </div>
                    <div>
                        <small class="text-success fw-bold">OPTIMIZED:</small>
                        <p class="small mb-0 mt-1">
                            "Create a 1500-word blog post about Artificial Intelligence for tech enthusiasts. Include: introduction to AI, real-world applications in healthcare, ethical considerations, and future trends. Use an engaging, informative tone..."
                        </p>
                    </div>
                </div>
            </div>

            <!-- Subscription Info (for non-admin) -->
@if (!auth()->user()->isAdmin()) 
  
<div class="card shadow-sm border-warning">
    <div class="card-body">
        <h6 class="fw-bold mb-3">
            <i class="bi bi-star-fill text-warning"></i> Your Plan
        </h6>
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Current Plan:</span>
                <span class="badge bg-primary"> {{ strtoupper(auth()->user()->subscription_plan ) }} </span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Used This Month:</span>
                <strong> {{ auth()->user()->prompts_used_this_month }} </strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Remaining:</span>
                <strong class="text-success">{{ auth()->user()->remaining_prompts }} </strong>
            </div>
        </div>
        
           @if (auth()->user()->remaining_prompts <= 2 ) 
            <div class="alert alert-warning p-2 mb-2 small">
                <i class="bi bi-exclamation-triangle"></i> Running low on prompts!
            </div>
           @endif
        
        
        <a href=" " class="btn btn-outline-warning btn-sm w-100">
            <i class="bi bi-arrow-up-circle"></i> Upgrade Plan
        </a>
    </div>
</div>
@endif

          
        </div>
    </div>
</div>
 
<script>
// Character counter
const rawPromptTextarea = document.getElementById('raw_prompt');
const charCount = document.getElementById('charCount');

rawPromptTextarea.addEventListener('input', function() {
    const count = this.value.length;
    charCount.textContent = `${count} characters`;
    
    if (count < 10) {
        charCount.classList.add('text-danger');
        charCount.classList.remove('text-muted');
    } else {
        charCount.classList.remove('text-danger');
        charCount.classList.add('text-muted');
    }
});

// Form submission with loading state
const promptForm = document.getElementById('promptForm');
const submitBtn = document.getElementById('submitBtn');
const btnText = document.getElementById('btnText');
const btnLoader = document.getElementById('btnLoader');

promptForm.addEventListener('submit', function(e) {
    // Disable button and show loader
    submitBtn.disabled = true;
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
});

// Trigger character count on page load
if (rawPromptTextarea.value) {
    rawPromptTextarea.dispatchEvent(new Event('input'));
}
</script>
 
 
<style>
.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.card {
    border: 1px solid #e9ecef;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

textarea.form-control {
    resize: vertical;
    min-height: 150px;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

#submitBtn:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}

.alert-info {
    background-color: #cfe2ff;
    border-color: #b6d4fe;
    color: #084298;
}

.alert-success {
    background-color: #d1e7dd;
    border-color: #badbcc;
    color: #0f5132;
}
</style>
 


 </div>

 @endsection
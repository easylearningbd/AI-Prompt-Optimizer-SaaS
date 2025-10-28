@extends('client.dashboard')
@section('client')
<div class="page-container">
    <!-- Breadcrumb -->
    <div class="bg-light py-3 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('template.prompts.index') }}">Templates</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('template.prompts.show',$template) }}">{{ $template->name }}</a></li>
                    <li class="breadcrumb-item active">Use Template</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Main Form -->
<div class="col-lg-8">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex align-items-center">
                <i class="{{ $template->icon ?? 'ri-file-text-line'}} fs-3 me-3"></i>
                <div>
                    <h4 class="mb-0">{{ $template->name }}</h4>
                    <small>Fill in the fields below to generate your optimized prompt</small>
                </div>
            </div>
        </div>
<div class="card-body p-4">
    <form action="{{ route('template.prompts.generate',$template) }}" method="POST" id="templateUseForm">
        @csrf

        <!-- Variation Name -->
        <div class="mb-4">
            <label for="variation_name" class="form-label fw-bold">
                Save As (Optional)
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="variation_name" 
                name="variation_name" 
                placeholder="Give this variation a name for easy reference"
                value="{{ old('variation_name') }}"
            >
            <small class="text-muted">Leave blank to use default name</small>
        </div>

        <hr>

        <h5 class="fw-bold mb-4">Template Fields</h5>

        <!-- Dynamic Placeholders -->
    @foreach ($template->placeholders as $index => $placeholder ) 
    <div class="mb-4">
        <label for="placeholder_{{ $placeholder['key'] }}" class="form-label fw-bold">
            {{ $placeholder['label'] }} 
            @if ($placeholder['required'] ?? false) 
                <span class="text-danger">*</span> 
            @endif
        </label> 
        @if ($placeholder['type'] === 'textarea') 
            <textarea 
                class="form-control  " 
                id="placeholder_{{ $placeholder['key'] }}" 
                name="placeholders[{{ $placeholder['key'] }}]" 
                rows="4"
                placeholder="{{ $placeholder['placeholder'] ?? '' }}"
               {{ ($placeholder['required'] ?? false) ? 'required' : '' }}
            >{{ old('placeholders.'.$placeholder['key'])  }}</textarea>

           @elseif ($placeholder['type'] === 'select')
            <select 
                class="form-select  " 
                id="placeholder_{{ $placeholder['key'] }}" 
                name="placeholders[{{ $placeholder['key'] }}]"
                {{ ($placeholder['required'] ?? false) ? 'required' : '' }} >
                
                <option value="">Select an option</option> 
                @if (isset($placeholder['options'])) 
                @foreach ($placeholder['options'] as $option) 
                    <option value="{{$option}}" {{ $placeholder['key'] === $option ? 'selected' : '' }} >
                       {{$option}}
                    </option>
                     @endforeach 
                @endif 
            </select>
            @else 
            <input 
                type="text" 
                class="form-control " 
                id="placeholder_{{ $placeholder['key'] }}" 
                name="placeholders[{{ $placeholder['key'] }}]" 
                placeholder="{{ $placeholder['placeholder'] ?? '' }}"
                value="{{ old('placeholders.'.$placeholder['key']) }}"
                {{ ($placeholder['required'] ?? false) ? 'required' : '' }}
                 >        
            @endif
            @error('placeholders.'.$placeholder['key']) 
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        

           @if (isset($placeholder['help'])) 
            <small class="text-muted d-block mt-1">
                <i class="ri-information-line"></i> {{ $placeholder['help'] }}
            </small>
            @endif
        
    </div>
    @endforeach   
       

        <hr>

        <!-- Language & Format -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="language" class="form-label fw-bold">Language</label>
                <select class="form-select" id="language" name="language">
                    <option value="english" selected>English</option>
                    <option value="spanish">Spanish</option>
                    <option value="french">French</option>
                    <option value="german">German</option>
                    <option value="chinese">Chinese</option>
                    <option value="japanese">Japanese</option>
                    <option value="hindi">Hindi</option>
                    <option value="bengali">Bengali</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="output_format" class="form-label fw-bold">Output Format</label>
                <select class="form-select" id="output_format" name="output_format">
                    <option value="text" selected>Text</option>
                    <option value="json">JSON</option>
                </select>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="d-flex gap-2 justify-content-between align-items-center pt-3 border-top">
            <a href="{{ route('template.prompts.show',$template) }}" class="btn btn-outline-secondary">
                <i class="ri-arrow-left-line"></i> Back
            </a>
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="ri-lightning-charge-fill"></i>
                <span id="btnText">Generate Optimized Prompt</span>
                <span id="btnLoader" class="d-none">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Generating...
                </span>
            </button>
        </div>
    </form>
</div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Template Preview -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="ri-eye-line"></i> Template Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">Template Structure:</small>
                        <div class="alert alert-light small">
                            <code style="white-space: pre-wrap; word-wrap: break-word; font-size: 0.85rem;">{{ $template->template_content }}</code>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="ri-lightbulb-line"></i> Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 ps-3 small">
                            <li class="mb-2">Be specific and detailed in your inputs</li>
                            <li class="mb-2">Use concrete examples when possible</li>
                            <li class="mb-2">Consider your target audience</li>
                            <li class="mb-0">Review and refine the generated output</li>
                        </ul>
                    </div>
                </div>

                <!-- Usage Info -->
        @if (!auth()->user()->isAdmin()) 
        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="text-center">
                    <h6 class="text-muted mb-2">Remaining This Month</h6>
                    <h2 class="text-{{ auth()->user()->remaining_prompts > 2 ? 'success' : 'warning' }}">
                       {{ auth()->user()->remaining_prompts }}
                    </h2>
                </div>
            </div>
        </div>
        @endif   
                
            </div>
        </div>
    </div>
</div>

<script>
// Form submission with loading state
const form = document.getElementById('templateUseForm');
const submitBtn = document.getElementById('submitBtn');
const btnText = document.getElementById('btnText');
const btnLoader = document.getElementById('btnLoader');

form.addEventListener('submit', function(e) {
    submitBtn.disabled = true;
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
});
</script>

<style>
.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}
</style>
@endsection
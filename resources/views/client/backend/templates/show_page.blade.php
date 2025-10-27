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
                    <li class="breadcrumb-item active">{{ $template->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Header -->
<div class="d-flex align-items-start mb-4">
    <div class="template-icon bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
        <i class="{{ $template->icon ?? 'ri-file-text-line'}} fs-1"></i>
    </div>
    <div class="flex-grow-1">
        <h2 class="fw-bold mb-2">{{ $template->name }}</h2>
        <div class="d-flex gap-2 mb-2">
            <span class="badge bg-primary">{{ $template->category->name }}</span>
            
            <span class="badge bg-{{ $template->difficulty_level  === 'beginner' ? 'success' : ($template->difficulty_level  === 'intermediate' ? 'warning' : 'danger') }} ">
                        {{ ucfirst($template->difficulty_level) }}
                    </span>
            
                   @if ($template->is_featured) 
                    <span class="badge bg-warning">
                        <i class="ri-star-fill"></i> Featured
                    </span>
                    @endif
            
        </div>
        <p class="text-muted mb-0">
            <i class="ri-download-line"></i> Used {{ number_format($template->usage_count) }} times
        </p>
    </div>
</div>

<!-- Description -->
<div class="mb-4">
    <h5 class="fw-bold mb-3">About This Template</h5>
    <p class="text-muted">{{ $template->description }}</p>
</div>

<!-- Template Content Preview -->
<div class="mb-4">
    <h5 class="fw-bold mb-3">Template Structure</h5>
    <div class="alert alert-light border">
        <code style="white-space: pre-wrap; word-wrap: break-word;">{{ $template->template_content }}</code>
    </div>
</div>

<!-- Placeholders -->
<div class="mb-4">
    <h5 class="fw-bold mb-3">Fields You'll Need to Fill</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Required</th>
                </tr>
            </thead>
            <tbody>
  @foreach ($template->placeholders as $placeholder) 
    <tr>
        <td><strong>{{ $placeholder['label'] }}</strong></td>
        <td>
            <span class="badge bg-info">{{ ucfirst($placeholder['type'])  }}</span>
        </td>
        <td class="text-muted small">
            {{ $placeholder['placeholder'] ?? 'N/A' }}
        </td>
        <td>
            @if ($placeholder['required'] ?? false)  
                <i class="ri-check-line text-success"></i> Yes
            @else    
                <i class="ri-close-line text-danger"></i> No
           @endif
        </td>
    </tr>
      @endforeach    
                
            </tbody>
        </table>
    </div>
</div>

<!-- Example Output -->
    @if ($template->example_output) 
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Example Output</h5>
        <div class="alert alert-info">
            <p class="mb-0">{{ $template->example_output }}</p>
        </div>
    </div>
     @endif
 

                        <!-- CTA Button -->
    <div class="d-grid gap-2">
        @if (auth()->user()->canOptimizePrompt()) 
            <a href="{{ route('template.prompts.use',$template) }}" class="btn btn-primary btn-lg">
                <i class="ri-edit-box-line"></i> Use This Template
            </a>
        @else 
            <div class="alert alert-warning mb-0">
                <i class="ri-error-warning-line"></i>
                You've reached your monthly limit. 
                <a href="{{ route('subscriptions.create') }}" class="alert-link">Upgrade your plan</a> to use more templates.
            </div>
         @endif
        
    </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="ri-information-line"></i> Quick Info
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Category:</span>
                            <strong>{{ $template->category->name }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Difficulty:</span>
                            <strong>{{ ucfirst($template->difficulty_level)  }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Fields Required:</span>
                            <strong>{{ count($template->placeholders) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total Uses:</span>
                            <strong>{{ number_format($template->usage_count) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Your Plan -->
   @if (!auth()->user()->isAdmin()) 
    <div class="card shadow-sm mb-4 border-{{ auth()->user()->remaining_prompts > 0 ? 'success' : 'warning' }} ">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="ri-vip-crown-line"></i> Your Plan
            </h6>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <h3 class="text-success">
                    {{ auth()->user()->remaining_prompts }}
                </h3>
                <p class="text-muted small mb-0">Optimizations Remaining</p>
            </div>
               @if (auth()->user()->remaining_prompts <= 2) 
                <div class="alert alert-warning p-2 small mb-2">
                    <i class="ri-error-warning-line"></i> Running low!
                </div>
                @endif
            
            <a href="{{ route('subscriptions.create') }}" class="btn btn-outline-primary btn-sm w-100">
                <i class="ri-arrow-up-circle-line"></i> Upgrade Plan
            </a>
        </div>
    </div>
    @endif       
              

                <!-- Related Templates -->
 @if ($relatedTemplates->count() > 0)      
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0">
            <i class="ri-apps-line"></i> Related Templates
        </h6>
    </div>
    <div class="list-group list-group-flush">
        @foreach ($relatedTemplates as $related) 
            <a href="{{ route('template.prompts.show',$related) }}" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <i class="ri-file-text-line fs-4 text-primary me-2"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ Str::limit($related->name, 40) }}</h6>
                        <small class="text-muted">{{ $related->category->name }}</small>
                    </div>
                </div>
            </a>
        @endforeach
        
    </div>
    <div class="card-footer bg-white text-center">
        <a href=" " class="text-decoration-none">
            View All in category
        </a>
    </div>
</div>
 @endif 
               
            </div>
        </div>
    </div>
</div>

<style>
.template-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}
</style>
@endsection
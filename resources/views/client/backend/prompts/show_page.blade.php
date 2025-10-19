@extends('client.dashboard')
@section('client') 
 <div class="page-container">
 
<div class="container py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <!-- Prompt Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
    <!-- Header with Badges -->
    <div class="d-flex flex-wrap gap-2 mb-3">
        <span class="badge bg-primary">{{ $prompt->category->name }}</span>
        <span class="badge bg-light text-dark border">
            <i class="bi bi-translate"></i> {{ ucfirst($prompt->language)  }}
        </span>
        <span class="badge bg-light text-dark border">
            <i class="bi bi-file-earmark-code"></i> {{ strtoupper($prompt->output_format) }}
        </span>
            @if ($prompt->is_featured)
             <span class="badge bg-warning text-dark">
                <i class="bi bi-star-fill"></i> Featured
            </span> 
            @endif 
             @if ($prompt->is_public)
            <span class="badge bg-secondary">
                <i class="bi bi-lock-fill"></i> Private
            </span>
             @endif 
        
            @if ($prompt->is_approved)
            <span class="badge bg-danger">
                <i class="bi bi-exclamation-triangle-fill"></i> Pending Approval
            </span>
             @endif 
        
    </div>

                    <!-- Title -->
    <h1 class="h2 fw-bold mb-3">{{ $prompt->title }} </h1>

<!-- Author & Date Info -->
<div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
    <div class="d-flex align-items-center gap-3">
        <a href=" " class="text-decoration-none">
                
                <img 
                    src="{{ (!empty($prompt->user->photo)) ? url('upload/admin_images/'.$prompt->user->photo) : url('upload/no_image.jpg') }}" 
                    alt="{{$prompt->user->name}}" 
                    class="rounded-circle" 
                    width="48" 
                    height="48"
                > 
        </a>
        <div>
            <a href=" " class="text-decoration-none text-dark fw-bold d-block">
               {{$prompt->user->name}}
               
               @if ($prompt->user->isAdmin())
                    <span class="badge bg-danger ms-1">Admin</span>
                @endif 
            </a>
            <small class="text-muted">
               {{ $prompt->user->name }} • 
               {{ $prompt->created_at->diffForHumans() }}
            </small>
        </div>
    </div>

    <!-- Follow Button -->
        
            
</div>

<!-- Stats Bar -->
<div class="d-flex align-items-center gap-4 mb-4 text-muted">
    <span title="Views">
        <i class="bi bi-eye-fill"></i> 6 views
    </span> 
    <span title="Copies">
        <i class="bi bi-clipboard-fill"></i> 3 copies
    </span>
</div>

<!-- Raw Prompt Section -->
<div class="mb-4">
    <h5 class="fw-bold mb-3">
        <i class="bi bi-file-text text-primary"></i> Original Prompt
    </h5>
    <div class="alert alert-light border">
        <p class="mb-0">raw_prompt</p>
    </div>
</div>

<!-- Optimized Prompt Section -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-lightning-charge-fill text-warning"></i> AI-Optimized Prompt
        </h5>
        <div class="btn-group" role="group">
            <button 
                type="button" 
                class="btn btn-sm btn-outline-primary copy-btn" 
                data-prompt=""
                title="Copy to clipboard"
            >
                <i class="bi bi-clipboard"></i> Copy
            </button>
            <a 
                href=" " 
                class="btn btn-sm btn-outline-success"
                title="Download"
            >
                <i class="bi bi-download"></i> Export
            </a>
        </div>
    </div>
    <div class="card bg-light border-0">
        <div class="card-body">
            <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.9rem;">asdasdf asfasdfasdfasfasfas sda fsd fsa f</pre>
        </div>
    </div>
</div>

                    <!-- Action Buttons -->
                     
                </div>
            </div>

            <!-- Comments Section -->
             
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
<!-- Quick Actions Card -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">
            <i class="bi bi-lightning-fill"></i> Quick Actions
        </h6>
    </div>
    <div class="card-body">
        <div class="d-grid gap-2">
          <button class="btn btn-primary copy-btn-sidebar" data-prompt=" ">
                <i class="bi bi-clipboard"></i> Copy Optimized Prompt
            </button>
            <a href=" " class="btn btn-success">
                <i class="bi bi-download"></i> Download/Export
            </a>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#shareModal">
                <i class="bi bi-share"></i> Share This Prompt
            </button>
        </div>
    </div>
</div>
            

<!-- Author Info Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold">About the Author</h6>
    </div>
    <div class="card-body text-center">
        <a href=" ">
             
                <img 
                    src=" " 
                    alt=" " 
                    class="rounded-circle mb-3" 
                    width="80" 
                    height="80"
                >
            
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
           
        </a>
        <h5 class="fw-bold mb-1">
            <a href=" " class="text-decoration-none text-dark">
                 User Name
            </a>
        </h5>
        <p class="text-muted mb-2">@User Name</p>
        
        
            <p class="small text-muted mb-3"> </p>
        

        <div class="d-flex justify-content-center gap-4 mb-3">
            <div>
                <strong class="d-block">3</strong>
                <small class="text-muted">Prompts</small>
            </div> 
           
        </div>

        <a href=" " class="btn btn-outline-primary btn-sm w-100">
            View Profile
        </a>
    </div>
</div>

<!-- Category Info Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold">Category</h6>
    </div>
    <div class="card-body">
        <a href=" " class="text-decoration-none">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded p-3">
                    <i class="bi  fs-3"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold"> Category Name </h6>
                    <small class="text-muted">
                       3 prompts
                    </small>
                </div>
            </div>
        </a>
    </div>
</div>

 <!-- Related Prompts -->

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold">Related Prompts</h6>
    </div>
    <div class="list-group list-group-flush">
        
            <a href=" " class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">prompt code </h6>
                        <small class="text-muted">
                            By  Main User
                        </small>
                    </div>
                    <span class="badge bg-light text-dark">
                        <i class="bi bi-heart-fill text-danger"></i> 0
                    </span>
                </div>
            </a>
        
    </div>
    <div class="card-footer bg-white text-center">
        <a href=" " class="text-decoration-none">
            View all in Category <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
          
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-share-fill"></i> Share This Prompt
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Share URL</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareUrl" value="{{ route('prompts.show', $prompt) }}" readonly>
                        <button class="btn btn-primary copy-url-btn" type="button">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('prompts.show', $prompt)) }}&text={{ urlencode($prompt->title) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-twitter"></i> Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('prompts.show', $prompt)) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('prompts.show', $prompt)) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
 

  
 
<style>
.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

.card {
    border: 1px solid #e9ecef;
}

.comments-list .border-bottom:last-child {
    border-bottom: 0 !important;
}

pre {
    background-color: transparent;
    border: none;
    color: inherit;
}

.list-group-item {
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.like-btn,
.copy-btn,
.copy-btn-main,
.copy-btn-sidebar {
    transition: all 0.3s ease;
}

.badge {
    font-weight: 500;
}

.modal-header.bg-danger .btn-close-white {
    filter: brightness(0) invert(1);
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.875rem;
    }
    
    .h2 {
        font-size: 1.5rem;
    }
}
</style> 

@endsection
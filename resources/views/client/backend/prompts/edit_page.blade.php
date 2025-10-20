@extends('client.dashboard')
@section('client')
<div class="page-container">
    

    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Main Form -->
<div class="col-lg-8">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="bi bi-pencil-fill"></i> Edit Prompt
            </h4>
        </div>
        <div class="card-body p-4">
<form method="POST" action="{{ route('prompts.update',$prompt) }} " id="promptEditForm">
    @csrf
    @method('PUT')

    <!-- Alert Info -->
    <div class="alert alert-info d-flex align-items-center mb-4">
        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
        <div>
            <strong>Note:</strong> You can only edit the title, category, and visibility. 
            The prompt content cannot be changed after optimization.
        </div>
    </div>

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
            value="{{ old('title', $prompt->title) }}"
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
                <option 
                    value="{{ $category->id }}" 
                    {{ old('category_id', $prompt->category_id) == $category->id ? 'selected' : '' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Choose the category that best fits your prompt</small>
    </div>

    <!-- Read-only Fields (Information Only) -->
    <div class="mb-4">
        <label class="form-label fw-bold">Language (Cannot be changed)</label>
        <div class="form-control-plaintext bg-light p-3 rounded border">
            <i class="bi bi-translate text-primary"></i>
            <strong>{{ ucfirst($prompt->language) }}</strong>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label fw-bold">Output Format (Cannot be changed)</label>
        <div class="form-control-plaintext bg-light p-3 rounded border">
            <i class="bi bi-file-earmark-code text-primary"></i>
            <strong>{{ strtoupper($prompt->output_format) }}</strong>
        </div>
    </div>

    <!-- Raw Prompt (Read-only) -->
    <div class="mb-4">
        <label class="form-label fw-bold">Original Prompt (Cannot be changed)</label>
        <div class="alert alert-light border">
            <p class="mb-0">{{ $prompt->raw_prompt }}</p>
        </div>
    </div>

    <!-- Optimized Prompt (Read-only) -->
    <div class="mb-4">
        <label class="form-label fw-bold">AI-Optimized Prompt (Cannot be changed)</label>
        <div class="card bg-light border-0">
            <div class="card-body">
                <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.9rem; max-height: 300px; overflow-y: auto;">  {{ Str::limit($prompt->optimized_prompt, 500) }}... </pre>
            </div>
        </div>
    </div>

<!-- Visibility Toggle -->
<div class="mb-4">
    <div class="card border">
        <div class="card-body">
           <input type="hidden" name="is_public" value="0">  
            <div class="form-check form-switch">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="is_public" 
                    name="is_public" 
                    value="1" {{ old('is_public', $prompt->is_public) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="is_public">
                    <i class="bi bi-globe"></i> Make this prompt public
                </label>
                <div class="mt-2">
                    <small class="text-muted">
                        When enabled, other users can view and learn from this prompt. 
                        Private prompts are only visible to you.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Status Info -->
<div class="alert alert-secondary">
    <strong>Current Status:</strong>
    <div class="mt-2">
        <span class="badge {{ $prompt->is_public ? 'bg-success' : 'bg-secondary' }} "> 
           {{ $prompt->is_public ? 'Public' : 'Private'}} 
        </span>
        <span class="badge {{ $prompt->is_approved ? 'bg-success' : 'bg-warning' }}"> 
           {{ $prompt->is_approved ? 'Approved' : 'Pending Approval'}}  
        </span>
            @if ($prompt->is_featured) 
            <span class="badge bg-warning text-dark">
                <i class="bi bi-star-fill"></i> Featured
            </span>
             @endif
        
    </div>
</div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2 justify-content-between align-items-center pt-3 border-top">
                    
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-warning">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Changes
                        </button>
                        <button type="submit" class="btn btn-warning" id="submitBtn">
                            <i class="bi bi-check-circle-fill"></i>
                            <span id="btnText">Update Prompt</span>
                            <span id="btnLoader" class="d-none">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Updating...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sidebar -->
<div class="col-lg-4">
<!-- Quick Info Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0">
            <i class="bi bi-info-circle-fill"></i> Prompt Information
        </h6>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <small class="text-muted d-block">Created</small>
            <strong>{{ $prompt->created_at->format('M d, Y h:i A') }}</strong>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Last Updated</small>
            <strong>{{ $prompt->updated_at->format('M d, Y h:i A') }}</strong>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Total Views</small>
            <strong>{{ number_format($prompt->views_count) }}</strong>
        </div> 

         <div class="mb-3">
            <small class="text-muted d-block">Total Copies</small>
            <strong>{{ number_format($prompt->copies_count) }}</strong>
        </div>
    </div>
</div>

                <!-- What Can Be Edited Card -->
                <div class="card shadow-sm mb-4 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="bi bi-pencil-fill"></i> What Can Be Edited
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <strong>Title:</strong> Change the prompt title
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <strong>Category:</strong> Move to different category
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <strong>Visibility:</strong> Make public or private
                            </li>
                            <li class="mb-2 text-muted">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <strong>Content:</strong> Cannot be changed
                            </li>
                            <li class="mb-0 text-muted">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <strong>Language/Format:</strong> Cannot be changed
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-danger fw-bold">
                            <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-3">
                            Deleting a prompt is permanent and cannot be undone. All associated likes and comments will also be deleted.
                        </p>
                        <button 
                            type="button" 
                            class="btn btn-outline-danger w-100" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal"
                        >
                            <i class="bi bi-trash-fill"></i> Delete Prompt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
                <p class="mb-2">You are about to delete:</p>
                <div class="bg-light p-3 rounded mb-3">
                    <strong>{{ $prompt->title }} </strong>
                </div>
                <p class="mb-0">This will permanently delete:</p>
                <ul class="mb-0">
                    <li>The prompt and all its content</li>
                    <li>All {{ number_format($prompt->views_count) }} View Count</li>
                    <li>All {{ number_format($prompt->copies_count) }} Copies Count</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancel
                </button>
                <form action="{{ route('prompts.delete',$prompt) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Yes, Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

 

<style>
.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
}

.card {
    border: 1px solid #e9ecef;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

pre {
    background-color: transparent;
    border: none;
    color: inherit;
}

#submitBtn:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}

.modal-header.bg-danger .btn-close-white {
    filter: brightness(0) invert(1);
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.875rem;
    }
}
</style>

@endsection
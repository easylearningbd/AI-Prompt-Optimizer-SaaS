@extends('admin.admin_master')
@section('admin')

 <div class="page-container">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Edit Template: {{ $template->name }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to Templates
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.templates.update',$template) }} " method="POST" id="templateForm">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Form -->
<div class="col-lg-8">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="ri-edit-line"></i> Template Information</h5>
        </div>
        <div class="card-body">
            <!-- Template Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">
                    Template Name <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    value="{{ $template->name }}"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="form-label fw-bold">
                    Category <span class="text-danger">*</span>
                </label>
                <select 
                    class="form-select @error('category_id') is-invalid @enderror" 
                    id="category_id" 
                    name="category_id"
                    required
                >
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $template->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea 
                    class="form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description" 
                    rows="3"
                >{{ $template->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Template Content -->
            <div class="mb-3">
                <label for="template_content" class="form-label fw-bold">
                    Template Content <span class="text-danger">*</span>
                </label>
                <textarea 
                    class="form-control @error('template_content') is-invalid @enderror" 
                    id="template_content" 
                    name="template_content" 
                    rows="8"
                    required
                >{{ $template->template_content }}</textarea>
                @error('template_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    <i class="ri-information-line"></i> Use {placeholder_name} for dynamic fields
                </small>
            </div>

            <!-- Placeholders -->
<div class="mb-3">
    <label class="form-label fw-bold">
        Placeholders <span class="text-danger">*</span>
    </label>
    <div id="placeholders-container">
        @php
            $placeholders = $template->placeholders ?? [];
        @endphp
        
    @foreach ($placeholders as $index => $placeholder ) 
    <div class="placeholder-item border rounded p-3 mb-2">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[{{ $index }}][key]" placeholder="Key" value="{{ $placeholder['key'] ?? '' }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[{{ $index }}][label]" placeholder="Label" value="{{ $placeholder['label'] ?? '' }}" required>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="placeholders[{{ $index }}][type]">
                    <option value="text" {{ ($placeholder['type'] ?? 'text') === 'text' ? 'selected' : '' }} >Text</option>
                    <option value="textarea" {{ ($placeholder['type'] ?? 'textarea') === 'textarea' ? 'selected' : '' }} >Textarea</option>
                    <option value="select" {{ ($placeholder['type'] ?? '') === 'select' ? 'selected' : '' }} >Select</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[{{ $index }}][placeholder]" placeholder="Placeholder" value="{{ $placeholder['placeholder'] ?? '' }}">
            </div>
            <div class="col-md-1">
                @if ($index > 0) 
                    <button type="button" class="btn btn-sm btn-danger remove-placeholder">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                @else     
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="placeholders[{{ $index }}][required]" value="1" {{ ($placeholder['required'] ?? true) ? 'checked' : ''}}  >
                        <label class="form-check-label small">Req</label>
                    </div>
               @endif
                
            </div>
        </div>
    </div>
    @endforeach


        
    </div>
    <button type="button" class="btn btn-sm btn-outline-primary" id="add-placeholder">
        <i class="ri-add-line"></i> Add Placeholder
    </button>
</div>

    <!-- Example Output -->
    <div class="mb-3">
        <label for="example_output" class="form-label fw-bold">Example Output</label>
        <textarea 
            class="form-control @error('example_output') is-invalid @enderror" 
            id="example_output" 
            name="example_output" 
            rows="5"
        >{{ $template->example_output }}</textarea>
        @error('example_output')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
        </div>
    </div>
</div>

<!-- Sidebar Settings -->
<div class="col-lg-4">
    <!-- Stats Card -->
    <div class="card shadow-sm mb-3 border-info">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="ri-bar-chart-line"></i> Template Stats</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Total Usage:</span>
                <strong>{{ number_format($template->usage_count) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Created:</span>
                <strong>{{ $template->created_at->format('M d, Y') }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Last Updated:</span>
                <strong>{{ $template->updated_at->format('M d, Y') }}</strong>
            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="ri-settings-3-line"></i> Settings</h6>
        </div>
        <div class="card-body">
            <!-- Difficulty Level -->
            <div class="mb-3">
                <label for="difficulty_level" class="form-label fw-bold">Difficulty Level</label>
                <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                    <option value="beginner" {{ $template->difficulty_level === 'beginner' ? 'selected' : '' }} >Beginner</option>
                    <option value="intermediate" {{ $template->difficulty_level === 'intermediate' ? 'selected' : '' }} >Intermediate</option>
                    <option value="advanced" {{ $template->difficulty_level === 'advanced' ? 'selected' : '' }} >Advanced</option>
                </select>
            </div>

            <!-- Icon -->
            <div class="mb-3">
                <label for="icon" class="form-label fw-bold">Icon Class</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="icon" 
                    name="icon" 
                    value="{{ $template->icon }}"
                    placeholder="ri-file-text-line"
                >
                <small class="text-muted">
                    <a href="https://remixicon.com/" target="_blank">Browse Remix Icons</a>
                </small>
            </div>

            <!-- Order -->
            <div class="mb-3">
                <label for="order" class="form-label fw-bold">Display Order</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="order" 
                    name="order" 
                    value="{{ $template->order }}"
                    min="0"
                >
            </div>

            <!-- Status Toggles -->
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        {{ old('is_active', $template->is_active) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_active">
                        <strong>Active</strong>
                        <br>
                        <small class="text-muted">Make this template visible to users</small>
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check form-switch">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_featured" 
                        name="is_featured" 
                        value="1"
                        {{ old('is_featured', $template->is_featured) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_featured">
                        <strong>Featured</strong>
                        <br>
                        <small class="text-muted">Show in featured section</small>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="card shadow-sm">
        <div class="card-body">
            <button type="submit" class="btn btn-warning w-100 btn-lg mb-2">
                <i class="ri-save-line"></i> Update Template
            </button>
            <a href=" " class="btn btn-secondary w-100">
                <i class="ri-close-line"></i> Cancel
            </a>
        </div>
    </div>

               
            </div>
        </div>
    </form>
</div>
</div>

 <!-- Danger Zone -->
<div class="card shadow-sm border-danger mt-3">
    <div class="card-header bg-danger text-white">
        <h6 class="mb-0"><i class="ri-alert-line"></i> Danger Zone</h6>
    </div>
    <div class="card-body">
        <p class="small text-muted mb-3">
            Deleting this template will remove all user variations associated with it.
        </p>
        <form action=" " method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone!')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">
                <i class="ri-delete-bin-line"></i> Delete Template
            </button>
        </form>
    </div>
</div>

<script>
    let placeholderCount = {{ count($placeholders) }};

document.getElementById('add-placeholder').addEventListener('click', function() {
    const container = document.getElementById('placeholders-container');
    const newPlaceholder = `
    <div class="placeholder-item border rounded p-3 mb-2">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[${placeholderCount}][key]" placeholder="Key" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[${placeholderCount}][label]" placeholder="Label" required>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="placeholders[${placeholderCount}][type]">
                    <option value="text" >Text</option>
                    <option value="textarea" >Textarea</option>
                    <option value="select" >Select</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="placeholders[${placeholderCount}][placeholder]" placeholder="Placeholder">
            </div>
            <div class="col-md-1"> 
                    <button type="button" class="btn btn-sm btn-danger remove-placeholder">
                        <i class="ri-delete-bin-line"></i>
                    </button> 
            </div>
        </div>
    </div> 
    `;
    container.insertAdjacentHTML('beforeend',newPlaceholder);
    placeholderCount++;

});

/// Remove Placeholder 
document.getElementById('placeholders-container').addEventListener('click', function(e){
if (e.target.closest('.remove-placeholder')) {
    e.target.closest('.placeholder-item').remove();
}
}); 


</script>

 
@endsection
 
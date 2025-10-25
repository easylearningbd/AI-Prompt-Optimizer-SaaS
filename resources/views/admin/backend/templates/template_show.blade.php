@extends('admin.admin_master')
@section('admin')
 

 <div class="page-container">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Template Details: {{ $template->name }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.templates.edit',$template) }}" class="btn btn-warning me-2">
                        <i class="ri-edit-line"></i> Edit
                    </a>
                    <a href="{{ route('admin.templates.index') }} " class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Template Info -->
<div class="col-lg-8">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Template Information</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Name:</strong>
                </div>
                <div class="col-md-9">
                    {{ $template->name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Category:</strong>
                </div>
                <div class="col-md-9">
                    <span class="badge bg-primary">{{ $template->category->name }}</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Description:</strong>
                </div>
                <div class="col-md-9">
                   {{ $template->description }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Difficulty:</strong>
                </div>
                <div class="col-md-9">
                    <span class="badge bg-{{ $template->difficulty_level === 'beginner' ? 'success' : ($template->difficulty_level === 'intermediate' ? 'warning' : 'danger') }}">
                       {{ ucfirst($template->difficulty_level)  }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Template Content:</strong>
                </div>
                <div class="col-md-9">
                    <div class="alert alert-light">
                        {{ $template->template_content }}
                    </div>
                </div>
            </div>

<div class="row mb-3">
    <div class="col-md-3">
        <strong>Placeholders:</strong>
    </div>
    <div class="col-md-9">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Label</th>
                        <th>Type</th>
                        <th>Required</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($template->placeholders as $placeholder) 
    <tr>
        <td><code>{!! $placeholder['key'] !!}</code></td>
        <td>{{ $placeholder['label'] }}</td>
        <td>{{ ucfirst($placeholder['type'])  }}</td>
        <td>
            @if ($placeholder['required'] ?? false ) 
                <i class="ri-check-line text-success"></i>
            @else
                <i class="ri-close-line text-danger"></i>
            @endif
        </td>
    </tr>
     @endforeach     
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

    @if ($template->example_output) 
        <div class="row">
            <div class="col-md-3">
                <strong>Example Output:</strong>
            </div>
            <div class="col-md-9">
                <div class="alert alert-info">
                  {{ $template->example_output }}
                </div>
            </div>
        </div>
    @endif
   
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Usage Count</small>
                        <h4>{{ number_format($template->usage_count) }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">User Variations</small>
                        <h4>{{ number_format($template->variations->count()) }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div>
                            <span class="badge bg-{{ $template->is_active ? 'success' : 'secondary' }}">
                                {{ $template->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if ($template->is_featured)
                             <span class="badge bg-warning">Featured</span>
                            @endif
                                
                            
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Created</small>
                        <div>{{ $template->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div>{{ $template->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.templates.edit',$template) }}" class="btn btn-warning">
                            <i class="ri-edit-line"></i> Edit Template
                        </a>
                        
<form action=" " method="POST">
    @csrf
    <button type="submit" class="btn btn-{{$template->is_featured ? 'outline-warning' : 'warning'}}  w-100">
        
        <i class="ri-star-{{ $template->is_featured ? 'fill' : 'line'}}"></i>

        {{ $template->is_featured ? 'Remove from Featured' : 'Mark as Featured'}}    
    </button>
</form>

        <form action=" " method="POST">
            @csrf
            <button type="submit" class="btn btn-{{ $template->is_active ? 'outline-success' : 'success'}}  w-100">
                <i class="ri-{{ $template->is_active ? 'close' : 'check' }}-line"></i>
                {{ $template->is_active ? 'Deactive' : 'Active'}}    
            </button>
        </form>

                        <hr>

                        <form action=" " method="POST" onsubmit="return confirm('Are you sure you want to delete this template?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="ri-delete-bin-line"></i> Delete Template
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@extends('admin.admin_master')
@section('admin')
 

 <div class="page-container">

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Prompt Templates</h4>
                <div class="page-title-right">
                    <a href=" " class="btn btn-primary">
                        <i class="ri-add-line"></i> Create New Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Templates</p>
<h4 class="mb-0">{{ \App\Models\PromptTemplate::count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary bg-soft text-primary rounded">
                                <i class="ri-file-list-3-line fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Active Templates</p>
<h4 class="mb-0">{{ \App\Models\PromptTemplate::where('is_active', true)->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success bg-soft text-success rounded">
                                <i class="ri-check-line fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Featured Templates</p>
<h4 class="mb-0">{{ \App\Models\PromptTemplate::where('is_featured', true)->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning bg-soft text-warning rounded">
                                <i class="ri-star-line fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Usage</p>
<h4 class="mb-0">{{ \App\Models\PromptTemplate::sum('usage_count') }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info bg-soft text-info rounded">
                                <i class="ri-line-chart-line fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">All Templates</h5>
                </div>
                <div class="card-body">
  
@if ($templates->count() > 0) 
 <div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead class="table-light">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Difficulty</th>
    <th>Usage</th>
    <th>Status</th>
    <th>Featured</th>
    <th>Created</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach ($templates as $template)
    <tr>
        <td><strong>#{{ $template->id }}</strong></td>
        <td>
            <div class="d-flex align-items-center">
                @if ($template->icon) 
                    <i class="{{ $template->icon }} fs-20 text-primary me-2"></i>
               @endif
                <div>
                    <strong>{{ $template->name }}</strong>
                    <br>
                    <small class="text-muted">{{ Str::limit($template->description, 50)  }}</small>
                </div>
            </div>
        </td>
        <td>
            <span class="badge bg-primary">{{ $template->category->name }}</span>
        </td>
        <td>
            <span class="badge bg-{{ $template->difficulty_level === 'beginner' ? 'success' : ($template->difficulty_level === 'intermediate' ? 'warning' : 'danger') }} ">
             {{ ucfirst($template->difficulty_level) }}
            </span>
        </td>
        <td>
            <i class="ri-download-line text-muted"></i>
          {{ number_format($template->usage_count) }}
        </td>
        <td>
<form action="{{ route('admin.templates.status.update',$template) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm btn-{{ $template->is_active ? 'success' : 'secondary' }} ">
        <i class="ri-{{ $template->is_active ? 'check' : 'close' }}-line"></i>
      {{ $template->is_active ? 'Active' : 'Inactive' }}    
    </button>
    </form>
        </td>
        <td>
    <form action=" " method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-sm btn-{{ $template->is_featured ? 'warning' : 'outline-warning' }}" title="Toggle Featured">
            <i class="ri-star-{{$template->is_featured ? 'fill' : 'line'}}"></i>
        </button>
    </form>
                    </td>
                <td>
                    <small>{{ $template->created_at->format('M d, Y') }}</small>
                </td>
                <td>
    <div class="btn-group" role="group">
            <a href="{{ route('admin.templates.show',$template) }} " class="btn btn-sm btn-warning" title="Show">
            <i class="ri-eye-line"></i>
        </a>

        <a href="{{ route('admin.templates.edit',$template) }}" class="btn btn-sm btn-primary" title="Edit">
            <i class="ri-edit-line"></i>
        </a>
        <form action="{{ route('admin.templates.delete',$template) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this template?')" title="Delete">
                <i class="ri-delete-bin-line"></i>
            </button>
        </form>
    </div>
                </td>
            </tr>
             
@endforeach


        
    </tbody>
</table>
</div>

                        <!-- Pagination -->
                        <div class="mt-3">
                          {{ $templates->links() }}
                        </div>
@else 
    <div class="text-center py-5">
        <i class="ri-file-list-3-line display-1 text-muted"></i>
        <h5 class="mt-3">No Templates Found</h5>
        <p class="text-muted">Create your first template to get started.</p>
        <a href=" " class="btn btn-primary mt-3">
            <i class="ri-add-line"></i> Create Template
        </a>
    </div>
@endif   
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
.avatar-sm {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-soft {
    opacity: 0.15;
}
</style>
@endsection
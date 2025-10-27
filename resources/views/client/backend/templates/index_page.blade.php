@extends('client.dashboard')
@section('client')
<div class="page-container">
    <!-- Header Section -->
    <div class="bg-gradient-primary py-5 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Prompt Templates</h1>
                    <p class="lead mb-0">
                        Choose from professionally crafted templates and customize them for your needs
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        @if (auth()->user()->remaining_prompts > 0 || auth()->user()->isAdmin() )    
        <div class="card bg-white text-dark">
            <div class="card-body p-3">
                <small class="text-muted d-block">Templates Available</small>
                <h3 class="mb-0 text-primary">{{ $templates->total() }}</h3>
            </div>
        </div>
        @endif
                    
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- Featured Templates -->
        @if ($featuredTemplates->count() > 0 ) 
            <div class="mb-5">
                <h4 class="fw-bold mb-4">
                    <i class="ri-star-fill text-warning"></i> Featured Templates
                </h4>
                <div class="row">
    @foreach ($featuredTemplates as $featured) 
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-warning featured-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="template-icon bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="{{ $featured->icon ?? 'ri-file-text-line'}}   fs-2"></i>
                    </div>
                    <span class="badge bg-warning">Featured</span>
                </div>
                <h5 class="card-title fw-bold">{{ $featured->name }}</h5>
                <p class="card-text text-muted small mb-3">
                    {{ Str::limit($featured->description, 100)  }}
                </p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary">{{ $featured->category->name }}</span>
                    <span class="badge bg-{{ $featured->difficulty_level  === 'beginner' ? 'success' : ($featured->difficulty_level  === 'intermediate' ? 'warning' : 'danger') }} ">
                        {{ ucfirst($featured->difficulty_level) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="ri-download-line"></i> {{ number_format($featured->usage_count) }} uses
                    </small>
                    <a href=" " class="btn btn-sm btn-primary">
                        View Details <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach   
                    
                </div>
            </div>
   @endif
        

        <!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('template.prompts.index') }}" id="filterForm">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Search Templates</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="ri-search-line"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="search" 
                            placeholder="Search by name or description..."
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Category</label>
                    <select class="form-select" name="category" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Difficulty Filter -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Difficulty</label>
                    <select class="form-select" name="difficulty" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Levels</option>
                        <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }} >Beginner</option>
                        <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }} >Intermediate</option>
                        <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }} >Advanced</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Sort By</label>
                    <select class="form-select" name="sort" onchange="document.getElementById('filterForm').submit()">
                        <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}  >Most Popular</option>
                        <option value="newest"  {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="default" {{ $sort === 'default' ? 'selected' : '' }} >Default Order</option>
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-filter-line"></i> Apply Filters
                </button>
         @if (request()->hasAny(['search','category','difficulty','sort'])) 
        <a href="{{ route('template.prompts.index') }}" class="btn btn-outline-secondary">
            <i class="ri-close-circle-line"></i> Clear
        </a>
         @endif   
                
            </div>
        </form>
    </div>
</div>

        <!-- Results Info -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">
               {{ $templates->total() }} {{ Str::plural('Template',$templates->total() ) }} Found
            </h5>
            @if (request('search')) 
           <small class="text-muted">Results for: "{{ request('search') }}"</small>
            @endif
        </div>

        <!-- Templates Grid -->
 @if ($templates->count() > 0) 
 <div class="row">
@foreach ($templates as $template)        
<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm template-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="template-icon bg-primary bg-opacity-10 text-primary rounded p-3">
                    <i class="{{ $template->icon ?? 'ri-file-text-line' }} fs-2"></i>
                </div>
                    @if ($template->is_featured) 
                    <span class="badge bg-warning">
                        <i class="ri-star-fill"></i> Featured
                    </span>
                    @endif
                
            </div>

            <h5 class="card-title fw-bold mb-2">{{ $template->name }}</h5>
            <p class="card-text text-muted small mb-3">
                {{ Str::limit($template->name, 80)  }}
            </p>

            <div class="d-flex gap-2 mb-3">
                <span class="badge bg-light text-dark border">
                    <i class="ri-bookmark-line"></i> {{ $template->category->name }}
                </span>
                <span class="badge bg-{{ $template->difficulty_level  === 'beginner' ? 'success' : ($template->difficulty_level  === 'intermediate' ? 'warning' : 'danger') }} ">
                        {{ ucfirst($template->difficulty_level) }}
                    </span>
            </div>

            <div class="mb-3">
                <small class="text-muted">
                    <i class="ri-list-check"></i> {{ count($template->placeholders) }} fields to fill
                </small>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="ri-download-line"></i> {{ number_format($template->usage_count) }} uses
                </small>
                <a href=" " class="btn btn-sm btn-primary">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div> 
@endforeach       
               
 </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
              {{ $templates->links() }}
            </div>
    @else     
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="ri-inbox-line display-1 text-muted"></i>
                <h4 class="mt-3">No Templates Found</h4>
                <p class="text-muted">Try adjusting your filters or search terms.</p>
            </div>
    @endif     
        
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.template-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.featured-card {
    border: 2px solid #ffc107;
}

.template-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
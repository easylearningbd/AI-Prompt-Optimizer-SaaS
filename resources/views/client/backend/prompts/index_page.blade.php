@extends('client.dashboard')
@section('client') 

 <div class="page-container">
 
<div class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="fw-bold mb-0">Explore Prompts</h1>
                <p class="text-muted mb-0">Discover and learn from community-optimized prompts</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                @auth
                    <a href="{{ route('prompts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Prompt
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Sign Up to Create
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Filters Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
    <form method="GET" action=" " id="filterForm">
        <div class="row g-3">
            <!-- Search -->
            <div class="col-md-4">
                <label for="search" class="form-label small text-muted">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="search" 
                        name="search" 
                        placeholder="Search prompts..."
                        value="{{ request('search') }}"
                    >
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-md-4">
                <label for="category" class="form-label small text-muted">Category</label>
                <select class="form-select" id="category" name="category" onchange="document.getElementById('filterForm').submit()" >
                    <option value="">All Categories</option>
                     @foreach ($categories as $cat) 
                      <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'seleted' : '' }} >
                            {{ $cat->name }}
                        </option>
                     @endforeach
                    
                </select>
            </div>

            <!-- Sort By -->
            <div class="col-md-4">
                <label for="sort" class="form-label small text-muted">Sort By</label>
                <select class="form-select" id="sort" name="sort" onchange="document.getElementById('filterForm').submit()">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }} >Latest</option> 
                    <option value="trending" {{ $sort === 'trending' ? 'selected' : '' }} >Trending</option>
                    <option value="most_viewed" {{ $sort === 'most_viewed' ? 'selected' : '' }} >Most Viewed</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel"></i> Apply Filters
            </button>
            @if(request()->hasAny(['search', 'category', 'sort']))
                <a href=" " class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @endif
        </div>
    </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0">
                {{ $prompts->total() }} {{ Str::plural('Prompt',$prompts->total() ) }} Found
            </h5>
                @if (request('search'))  
                <small class="text-muted">Search results for: "{{ request('search') }} "</small>
             @endif
        </div>
        <div>
            <span class="text-muted small">
             Showing {{ $prompts->firstItem() ?? 0 }} - {{ $prompts->lastItem() ?? 0 }} of {{ $prompts->total() }}
            </span>
        </div>
    </div>

    <!-- Prompts Grid -->
 
  @if ($prompts->count() > 0) 
  <div class="row">
   @foreach ($prompts as $prompt) 
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm prompt-card">
            <div class="card-body">
                <!-- Category & Featured Badge -->
    <div class="d-flex justify-content-between align-items-start mb-3">
        <span class="badge bg-primary">{{ $prompt->category->name }}</span>
            @if ($prompt->is_featured) 
            <span class="badge bg-warning text-dark">
                <i class="bi bi-star-fill"></i> Featured
            </span>
            @endif 
        
    </div>

                <!-- Title -->
                <h5 class="card-title mb-2">
                    <a href=" " class="text-decoration-none text-dark">
                        {{ $prompt->title }}
                    </a>
                </h5>

                <!-- Raw Prompt Preview -->
                <p class="card-text text-muted small mb-3">
                   {{ Str::limit($prompt->raw_prompt, 100)  }}
                </p>

                <!-- Language & Format Badges -->
                <div class="mb-3">
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-translate"></i> 
                        {{ ucfirst($prompt->language) }}
                    </span>
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-file-earmark-code"></i> 
                        {{ strtoupper($prompt->output_format) }}
                    </span>
                </div>

                <!-- Stats -->
                <div class="d-flex align-items-center gap-3 text-muted small mb-3">  
                    <span title="Views">
                        <i class="bi bi-eye-fill"></i> {{ $prompt->views_count }}
                    </span> 
                    <span title="Copies">
                        <i class="bi bi-clipboard-fill"></i> 
                        {{ $prompt->copies_count }}
                    </span>
                </div>

                <!-- User Info & Action Button -->
    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
     <div class="d-flex align-items-center gap-2">
                        
           <img id="showImage" src="{{ (!empty($prompt->user->photo)) ? url('upload/admin_images/'.$prompt->user->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl" style="width:32px; height:32px;">
        
            
        
        <div>
            <a href=" " class="text-decoration-none text-dark small fw-bold">
                {{ $prompt->user->name }}
            </a>
            <div class="text-muted" style="font-size: 0.75rem;">
                {{ $prompt->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    <a href="{{ route('prompts.show',$prompt) }} " class="btn btn-sm btn-outline-primary">
        View <i class="bi bi-arrow-right"></i>
    </a>
    <a href=" " class="btn btn-sm btn-outline-warning">
        Edit <i class="bi bi-arrow-right"></i>
    </a>
    <a href=" " class="btn btn-sm btn-outline-danger">
        Delete <i class="bi bi-arrow-right"></i>
    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach    

        </div>
 

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $prompts->links() }}
        </div>

    @else 
    
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h3 class="mt-3">No Prompts Found</h3>
            <p class="text-muted">Try adjusting your filters or search terms.</p>
            @auth
                <a href="{{ route('prompts.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Create First Prompt
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Sign Up to Create
                </a>
            @endauth
        </div>
    @endif 
</div>
 

<style>
.prompt-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.prompt-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.6em;
}

.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #0d6efd;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
</style>
 



</div>
@endsection
@extends('client.dashboard')

@section('client')
<div class="page-container">
    <!-- Header Section -->
    <div class="bg-gradient-image py-5 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="ri-image-line"></i> AI Image Prompts
                    </h1>
                    <p class="lead mb-0">
                        Create professional AI image generation prompts optimized for DALL-E, Midjourney, Stable Diffusion
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href=" " class="btn btn-light btn-lg">
                        <i class="ri-add-line"></i> Create Image Prompt
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">  
        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
<form method="GET" action="{{ route('image.prompts.index') }}" id="filterForm">
    <div class="row g-3">
        <!-- Search -->
        <div class="col-md-4">
            <label class="form-label small text-muted">Search</label>
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="ri-search-line"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control" 
                    name="search" 
                    placeholder="Search prompts..."
                    value="{{ request('search') }}"
                >
            </div>
        </div>

        <!-- Style Filter -->
        <div class="col-md-3">
            <label class="form-label small text-muted">Style</label>
            <select class="form-select" name="style" onchange="document.getElementById('filterForm').submit()">
                <option value="">All Styles</option>
                <option value="realistic" {{ request('style') === 'realistic' ? 'selected' : '' }} >Realistic</option>
                <option value="artistic" {{ request('style') === 'artistic' ? 'selected' : '' }} >Artistic</option>
                <option value="anime" {{ request('style') === 'anime' ? 'selected' : '' }} >Anime</option>
                <option value="digital_art" {{ request('style') === 'digital_art' ? 'selected' : '' }} >Digital Art</option>
                <option value="3d_render" {{ request('style') === '3d_render' ? 'selected' : '' }} >3D Render</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div class="col-md-2">
            <label class="form-label small text-muted">Category</label>
            <select class="form-select" name="category" onchange="document.getElementById('filterForm').submit()">
                <option value="">All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sort -->
        <div class="col-md-3">
            <label class="form-label small text-muted">Sort By</label>
            <select class="form-select" name="sort" onchange="document.getElementById('filterForm').submit()">
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }} >Latest</option>
                <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }} >Most Popular</option>
                <option value="most_viewed" {{ $sort === 'most_viewed' ? 'selected' : '' }} >Most Viewed</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="ri-filter-line"></i> Apply
        </button>
        @if (request()->hasAny(['search','style','category','sort'])) 
            <a href="{{ route('image.prompts.index') }}" class="btn btn-outline-secondary">
                <i class="ri-close-line"></i> Clear
            </a>
        @endif
        
    </div>
</form>
            </div>
        </div>

        <!-- Results -->
        <div class="mb-4">
            <h5>{{ $imagePrompts->total() }} {{ Str::plural('Prompt',$imagePrompts->total()) }} Found</h5>
        </div>

  @if ($imagePrompts->count() > 0) 
  <div class="row">
   @foreach ($imagePrompts as $prompt)     
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm image-prompt-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-{{ $prompt->style === 'realistic' ? 'primary' : ($prompt->style === 'anime' ? 'danger' : 'info') }} ">
                       {{ ucfirst(str_replace('_', ' ',$prompt->style )) }}
                    </span> 
                </div>

                <h5 class="card-title fw-bold mb-2">{{ Str::list($prompt->title, 50) }}</h5>
                <p class="card-text text-muted small mb-3">
                   {{ Str::list($prompt->original_description, 100) }}
                </p>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark border">
                        <i class="ri-aspect-ratio-line"></i> {{ $prompt->aspect_ratio }}
                    </span>
                       @if ($prompt->mood)  
                        <span class="badge bg-light text-dark border">
                            <i class="ri-emotion-line"></i> {{ $prompt->mood }}
                        </span>
                       @endif
                    
                    <span class="badge bg-light text-dark border">
                        <i class="ri-hd-line"></i> {{ strtoupper($prompt->quality_level) }}
                    </span>
                </div>

                <div class="d-flex gap-3 text-muted small mb-3">
                    <span><i class="ri-eye-line"></i> {{ $prompt->views_count }}</span>
                    <span><i class="ri-download-line"></i> {{ $prompt->copies_count }}</span>
                        
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        
            <img id="showImage" src="{{ (!empty($prompt->user->photo)) ? url('upload/admin_images/'.$prompt->user->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl" style="width:32px; height:32px;">
                        
                            <i class="ri-user-line"></i>
                        
                        <small>{{ $prompt->user->name }}</small>
                    </div>
                    <a href=" " class="btn btn-sm btn-primary">
                        View
                    </a>
                </div>
            </div>
        </div>
    </div> 
   @endforeach      

   </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $imagePrompts->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="ri-image-line display-1 text-muted"></i>
        <h4 class="mt-3">No Image Prompts Found</h4>
        <p class="text-muted">Try adjusting your filters or create your first image prompt!</p>
        <a href=" " class="btn btn-primary mt-3">
            <i class="ri-add-line"></i> Create Image Prompt
        </a>
    </div>
    @endif  
       
    </div>
</div>

<style>
.bg-gradient-image {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.image-prompt-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.image-prompt-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.featured-card {
    border: 2px solid #ffc107;
}
</style>
@endsection
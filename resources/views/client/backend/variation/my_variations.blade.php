@extends('client.dashboard')
@section('client')
<div class="page-container">
    <!-- Header -->
    <div class="bg-light py-4 border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">My Saved Variations</h2>
                    <p class="text-muted mb-0">Manage your template variations and optimized prompts</p>
                </div>
                <a href="{{ route('template.prompts.index') }}" class="btn btn-primary">
                    <i class="ri-add-line"></i> Create New
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5">
 @if ($variations->count() > 0) 
 <div class="row">
    @foreach ($variations as $variation) 
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="template-icon bg-primary bg-opacity-10 text-primary rounded p-2">
                        <i class="{{ $variation->template->icon  ?? 'ri-file-text-line'}}  fs-4"></i>
                    </div>
                    @if ($variation->is_favorite) 
                        <span class="badge bg-warning">
                            <i class="ri-star-fill"></i> Favorite
                        </span>
                    @endif
                    
                </div>

                <h5 class="card-title fw-bold mb-2">{{ Str::limit($variation->variation_name, 50) }}</h5>
                <p class="card-text text-muted small mb-3">
                    Template: {{ $variation->template->name }}
                </p>

                <div class="mb-3">
                    <span class="badge bg-light text-dark border">
                        {{ $variation->template->category->name }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">
                        <i class="ri-time-line"></i> {{ $variation->created_at->diffForHumans() }}
                    </small>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('template.variation.details',$variation) }}" class="btn btn-sm btn-primary">
                        <i class="ri-eye-line"></i> View Details
                    </a>
                    <div class="btn-group" role="group">
                        
    <form action="{{ route('variation.favorite',$variation) }}" method="POST" class="flex-fill">
        @csrf
        <button type="submit" class="btn btn-sm btn-{{ $variation->is_favorite ? 'warning' : 'outline-warning' }} w-100">
            <i class="ri-star-line"></i>
        </button>
    </form>

                        <form action=" " method="POST" class="flex-fill" onsubmit="return confirm('Delete this variation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
                
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
              {{ $variations->links() }}
            </div>
    @else     
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="ri-inbox-line display-1 text-muted"></i>
                <h4 class="mt-3">No Variations Yet</h4>
                <p class="text-muted mb-4">You haven't created any template variations yet.</p>
                <a href="{{ route('template.prompts.index') }}" class="btn btn-primary">
                    <i class="ri-add-line"></i> Browse Templates
                </a>
            </div>
    @endif  
        
    </div>
</div>

<style>
.template-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
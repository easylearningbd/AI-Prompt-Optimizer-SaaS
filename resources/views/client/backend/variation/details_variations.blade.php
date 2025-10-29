@extends('client.dashboard')

@section('client')
<div class="page-container">
    <!-- Success Header -->
    <div class="bg-success py-4 text-white">
        <div class="container">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-fill fs-1 me-3"></i>
                <div>
                    <h3 class="mb-0">Prompt Optimized Successfully!</h3>
                    <p class="mb-0">Your template has been filled and optimized by AI</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
<div class="col-lg-8 mb-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ri-file-text-line"></i>
                   {{ $variation->variation_name }}
                </h5>
                <span class="badge bg-primary"> {{ $variation->template->category->name }}</span>
            </div>
        </div>
    <div class="card-body p-4">
        <!-- Generated Prompt -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="ri-file-text-line text-primary"></i> Generated Prompt
                </h6>
            </div>
            <div class="alert alert-light border">
                <p class="mb-0"> {{ $variation->generated_prompt }}</p>
            </div>
        </div>

    <!-- Optimized Prompt -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">
                <i class="ri-lightning-charge-fill text-warning"></i> AI-Optimized Prompt
            </h6>
            <div class="btn-group" role="group">
                <button 
                    type="button" 
                    class="btn btn-sm btn-outline-primary copy-btn" 
                    data-prompt="{{ $variation->optimized_prompt }}"
                >
                    <i class="ri-clipboard-line"></i> Copy
                </button>
                <button 
                    type="button" 
                    class="btn btn-sm btn-outline-success" 
                    onclick="downloadPrompt()"
                >
                    <i class="ri-download-line"></i> Download
                </button>
            </div>
        </div>
        <div class="card bg-light border-0">
            <div class="card-body">
                <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.9rem;">{{ $variation->optimized_prompt }}</pre>
            </div>
        </div>
    </div>

    <!-- Filled Values -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3">
            <i class="ri-list-check text-info"></i> Your Input Values
        </h6>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
        @foreach ($variation->filled_placeholders as $key => $value ) 
            <tr>
                <td class="fw-bold">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex gap-2 flex-wrap">
        <button 
            type="button" 
            class="btn btn-primary copy-btn-main" 
            data-prompt="{{ $variation->optimized_prompt }}"
        >
            <i class="ri-clipboard-line"></i> Copy Optimized Prompt
        </button>
        
        <form action=" " method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning">
                <i class="ri-star-fill"></i>
                Favorited
            </button>
        </form>

        <a href="{{ route('template.prompts.use',$variation->template) }}" class="btn btn-outline-primary">
            <i class="ri-refresh-line"></i> Create Another
        </a> 
        
    </div>
</div>
        </div>
    </div>

            <!-- Sidebar -->
<div class="col-lg-4">
    <!-- Template Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">
                <i class="ri-information-line"></i> Template Used
            </h6>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <i class="ri-file-text-line fs-3 text-primary me-3"></i>
                <div>
                    <strong>{{ $variation->template->name }}</strong>
                    <br>
                    <small class="text-muted">{{ $variation->template->category->name }}</small>
                </div>
            </div>
            <a href="{{ route('template.prompts.show',$variation->template) }}" class="btn btn-outline-primary btn-sm w-100">
                View Template Details
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="ri-bar-chart-line"></i> Details
            </h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted">Created:</span>
                <strong>{{ $variation->created_at->format('M d, Y') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted">Time:</span>
                <strong>{{ $variation->created_at->format('h:i A') }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Status:</span>
                @if ($variation->is_favorite) 
                    <span class="badge bg-warning">
                        <i class="ri-star-fill"></i> Favorite
                    </span>
                @else 
                    <span class="badge bg-secondary">Normal</span>
                 @endif
            </div>
        </div>
    </div>

    <!-- Next Steps -->
    <div class="card shadow-sm border-info">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0">
                <i class="ri-lightbulb-line"></i> What's Next?
            </h6>
        </div>
        <div class="card-body">
            <ul class="mb-0 ps-3 small">
                <li class="mb-2">Copy your optimized prompt</li>
                <li class="mb-2">Use it in your favorite AI tool</li>
                <li class="mb-2">Refine based on results</li>
                <li class="mb-0">Create more variations</li>
            </ul>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

 

<script>
// Copy to clipboard
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(() => {
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="ri-check-line"></i> Copied!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-primary', 'btn-primary');
        
        setTimeout(() => {
            button.innerHTML = originalHtml;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 2000);
    });
}

document.querySelectorAll('.copy-btn, .copy-btn-main').forEach(button => {
    button.addEventListener('click', function() {
        const promptText = this.getAttribute('data-prompt');
        copyToClipboard(promptText, this);
    });
});

// Download prompt
function downloadPrompt() {
    const text = `{{ $variation->optimized_prompt }}`;
    const blob = new Blob([text], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = '{{ Str::slug($variation->variation_name) }}.txt';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}
</script>
@endsection
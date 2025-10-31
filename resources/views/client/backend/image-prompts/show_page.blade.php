@extends('client.dashboard')
@section('client')
<div class="page-container">
    <!-- Success Header -->
    <div class="bg-success py-4 text-white">
        <div class="container">
            <div class="d-flex align-items-center">
                <i class="ri-checkbox-circle-fill fs-1 me-3"></i>
                <div>
                    <h3 class="mb-0">Image Prompt Optimized!</h3>
                    <p class="mb-0">Your prompt has been professionally optimized for AI image generation</p>
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
                <h4 class="mb-0">{{ $imagePrompt->title }}</h4>
                <span class="badge bg-primary">
                    {{ ucfirst(str_replace('_',' ',$imagePrompt->style)) }}
                </span>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Original Description -->
            <div class="mb-4">
                <h6 class="fw-bold mb-2">
                    <i class="ri-file-text-line text-primary"></i> Your Original Description
                </h6>
                <div class="alert alert-light border">
                    {{ $imagePrompt->original_description }}
                </div>
            </div>

            <!-- Optimized Prompt -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="ri-magic-line text-warning"></i> AI-Optimized Prompt
                    </h6>
                    <div class="btn-group">
                        <button 
                            type="button" 
                            class="btn btn-sm btn-outline-primary copy-btn" 
                            data-prompt="{{ $imagePrompt->optimized_prompt }}"
                        >
                            <i class="ri-clipboard-line"></i> Copy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadPrompt()">
                            <i class="ri-download-line"></i> Download
                        </button>
                    </div>
                </div>
                <div class="card bg-light border-primary">
                    <div class="card-body">
                        <pre class="mb-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; font-size: 0.95rem;">{{ $imagePrompt->optimized_prompt }}</pre>
                    </div>
                </div>
            </div>

            <!-- Parameters -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">
                    <i class="ri-settings-3-line text-info"></i> Generation Parameters
                </h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <small class="text-muted d-block">Aspect Ratio</small>
                            <strong>{{ strtoupper($imagePrompt->aspect_ratio)  }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <small class="text-muted d-block">Quality</small>
                            <strong>{{ $imagePrompt->quality_level }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <small class="text-muted d-block">Style</small>
                            <strong>{{ ucfirst(str_replace('_',' ',$imagePrompt->style)) }}</strong>
                        </div>
                    </div>
                    @if ($imagePrompt->mood) 
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <small class="text-muted d-block">Mood</small>
                                <strong>{{ ucfirst($imagePrompt->mood) }}</strong>
                            </div>
                        </div>
                    @endif
                    
                      @if ($imagePrompt->lighting) 
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <small class="text-muted d-block">Lighting</small>
                                <strong>{{ ucfirst($imagePrompt->lighting) }}</strong>
                            </div>
                        </div>
                     @endif
                     @if ($imagePrompt->color_paletter) 
                        <div class="col-md-4">
                            <div class="p-3 border rounded">
                                <small class="text-muted d-block">Color Palette</small>
                                <strong>{{ ucfirst($imagePrompt->color_paletter) }}</strong>
                            </div>
                        </div>
                      @endif
                    
                </div>
            </div>

            <!-- How to Use -->
            <div class="alert alert-info mb-4">
                <h6 class="fw-bold mb-2">
                    <i class="ri-information-line"></i> How to Use This Prompt
                </h6>
                <ol class="mb-0 ps-3">
                    <li>Copy the optimized prompt above</li>
                    <li>Open your favorite AI image generator (DALL-E, Midjourney, Stable Diffusion)</li>
                    <li>Paste the prompt and adjust any platform-specific settings</li>
                    <li>Generate your image!</li>
                </ol>
            </div> 

            <!-- Action Buttons -->
                
        </div>
    </div>
</div>

            <!-- Sidebar -->
<div class="col-lg-4">
    <!-- Author Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">
                <i class="ri-user-line"></i> Created By
            </h6>
        </div>
        <div class="card-body text-center">
                
            <img id="showImage" src="{{ (!empty($imagePrompt->user->photo)) ? url('upload/admin_images/'.$imagePrompt->user->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl" style="width:80px; height:80px;">
            <h6 class="fw-bold mb-1">{{ $imagePrompt->user->name }}</h6>
            <p class="text-muted small mb-0"> {{ $imagePrompt->user->email }} </p>
        </div>
    </div>

    <!-- Stats -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="ri-bar-chart-line"></i> Statistics
            </h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted">Views:</span>
                <strong>{{ number_format($imagePrompt->views_count) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted">Copies:</span>
                <strong>{{ number_format($imagePrompt->copies_count) }}</strong>
            </div> 
            <div class="d-flex justify-content-between">
                <span class="text-muted">Created:</span>
                <strong>{{ $imagePrompt->created_at->format('M d,Y') }}</strong>
            </div>
        </div>
    </div>

            </div>
        </div>
    </div>
</div>

 <script>
/// Copy to clipboard functionality 
function copyToClipboard(text,button) {
    navigator.clipboard.writeText(text).then(() => {
        const originalHtml = button.innerHTML;

        /// SHOW Success message
        button.innerHTML = 'Copied!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-primary','btn-primary');

        // Track copy count 
        fetch('{{ route("prompts.copy",$imagePrompt) }}',{
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });

        // Restore Original state after 2 sec
        setTimeout(() => {
            button.innerHTML = originalHtml;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary')
        },2000);
    }).catch(err => {
        alert('Faild to copy to clipboard');
    });
}


// All Copy buttons 
document.querySelectorAll('.copy-btn, .copy-btn-main, .copy-btn-sidebar').forEach(button => {
    button.addEventListener('click', function(){
        const promptText = this.getAttribute('data-prompt');
        copyToClipboard(promptText,this);
    });
});

</script>
 
@endsection
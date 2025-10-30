@extends('client.dashboard')
@section('client')
<div class="page-container">
    <!-- Header -->
    <div class="bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="mb-0">
                <i class="ri-image-add-line"></i> Create AI Image Prompt
            </h2>
            <p class="text-muted mb-0">Transform your idea into a professional AI image generation prompt</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Main Form -->
<div class="col-lg-8">
    <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="ri-magic-line"></i> Image Prompt Generator
        </h5>
    </div>
<div class="card-body p-4">
    <form action=" " method="POST" id="imagePromptForm">
        @csrf

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="form-label fw-bold">
                Title <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                placeholder="E.g., Sunset Mountain Landscape"
                value="{{ old('title') }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category_id" class="form-label fw-bold">Category (Optional)</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Original Description -->
        <div class="mb-4">
            <label for="original_description" class="form-label fw-bold">
                Describe Your Image <span class="text-danger">*</span>
            </label>
            <textarea 
                class="form-control @error('original_description') is-invalid @enderror" 
                id="original_description" 
                name="original_description" 
                rows="5"
                placeholder="Example: A beautiful sunset over mountains with orange and purple sky, peaceful and serene atmosphere"
                required
            >{{ old('original_description') }}</textarea>
            @error('original_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">
                <i class="ri-information-line"></i> Describe what you want to see in the image
            </small>
        </div>

        <hr>

        <h6 class="fw-bold mb-3">Image Parameters</h6>

        <!-- Style & Aspect Ratio -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="style" class="form-label fw-bold">
                    Style <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('style') is-invalid @enderror" id="style" name="style" required>
                   @foreach ($styles as $key => $item) 
                    <option value="{{ $key }}"{{ old('style') === $key ? 'selected' : '' }} >
                        {{ $item }}
                    </option>
                    @endforeach 
                    
                </select>
                @error('style')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="aspect_ratio" class="form-label fw-bold">
                    Aspect Ratio <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('aspect_ratio') is-invalid @enderror" id="aspect_ratio" name="aspect_ratio" required>
                    
                     @foreach ($aspectRatios as $key => $item) 
                    <option value="{{ $key }}" {{ old('aspect_ratio') === $key ? 'selected' : '' }} >
                        {{ $item }}
                    </option>
                    @endforeach 
                    
                </select>
                @error('aspect_ratio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Mood & Lighting -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="mood" class="form-label fw-bold">Mood (Optional)</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="mood" 
                    name="mood" 
                    placeholder="E.g., peaceful, dramatic, cheerful"
                    value="{{ old('mood') }}"
                >
                <small class="text-muted">The emotional feeling of the image</small>
            </div>

            <div class="col-md-6">
                <label for="lighting" class="form-label fw-bold">Lighting (Optional)</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="lighting" 
                    name="lighting" 
                    placeholder="E.g., golden hour, soft, dramatic"
                    value="{{ old('lighting') }}"
                >
                <small class="text-muted">Lighting conditions</small>
            </div>
        </div>

        <!-- Color Palette & Quality -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="color_palette" class="form-label fw-bold">Color Palette (Optional)</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="color_palette" 
                    name="color_palette" 
                    placeholder="E.g., vibrant, muted, warm tones"
                    value="{{ old('color_palette') }}"
                >
                <small class="text-muted">Color scheme</small>
            </div>

            <div class="col-md-6">
                <label for="quality_level" class="form-label fw-bold">
                    Quality Level <span class="text-danger">*</span>
                </label>
                <select class="form-select" id="quality_level" name="quality_level" required>
                    <option value="standard" {{ old('quality_level', 'standard') === 'standard' ? 'selected' : '' }} >Standard</option>
                    <option value="hd" {{ old('quality_level') === 'standard' ? 'hd' : '' }} >HD</option>
                    <option value="4k" {{ old('quality_level') === '4k' ? 'selected' : '' }} >4K</option>
                    <option value="8k" {{ old('quality_level') === '8k' ? 'selected' : '' }} >8K</option>
                </select>
            </div>
        </div>

        <!-- Public Toggle -->
        <div class="mb-4">
            <div class="form-check form-switch">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="is_public" 
                    name="is_public" 
                    value="1"
                    {{ old('is_public', true) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="is_public">
                    <strong>Make this prompt public</strong>
                    <br>
                    <small class="text-muted">Share with the community</small>
                </label>
            </div>
        </div>

        <!-- Submit -->
        <div class="d-flex gap-2 justify-content-between pt-3 border-top">
            <a href="{{ route('image.prompts.index') }}" class="btn btn-outline-secondary">
                <i class="ri-arrow-left-line"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="ri-magic-line"></i>
                <span id="btnText">Generate Optimized Prompt</span>
                <span id="btnLoader" class="d-none">
                    <span class="spinner-border spinner-border-sm"></span>
                    Optimizing...
                </span>
            </button>
        </div>
    </form>
</div>
    </div>
</div>

            <!-- Sidebar -->
<div class="col-lg-4">
    <!-- Examples Card -->
    <div class="card shadow-sm mb-4 border-info">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0">
                <i class="ri-lightbulb-line"></i> Examples
            </h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong class="small">Basic:</strong>
                <p class="small text-muted mb-0">"A cat sitting on a windowsill"</p>
            </div>
            <div class="mb-3">
                <strong class="small">Better:</strong>
                <p class="small text-muted mb-0">"A fluffy orange tabby cat sitting on a sunlit windowsill, looking outside at birds, soft natural lighting"</p>
            </div>
            <div>
                <strong class="small">Best:</strong>
                <p class="small text-muted mb-0">"A majestic fluffy orange tabby cat with green eyes, sitting gracefully on a wooden windowsill bathed in warm golden hour sunlight, gazing curiously at colorful birds outside, shallow depth of field, cozy home atmosphere"</p>
            </div>
        </div>
    </div>

    <!-- Tips Card -->
    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h6 class="mb-0">
                <i class="ri-information-line"></i> Tips
            </h6>
        </div>
        <div class="card-body">
            <ul class="mb-0 ps-3 small">
                <li class="mb-2">Be specific about subjects and details</li>
                <li class="mb-2">Describe colors, textures, and materials</li>
                <li class="mb-2">Mention camera angles or perspectives</li>
                <li class="mb-2">Include mood and atmosphere</li>
                <li class="mb-0">Add technical details (lighting, quality)</li>
            </ul>
        </div>
    </div>

    <!-- Usage Info -->
        @if (!auth()->user()->isAdmin()) 
        <div class="card shadow-sm mt-3">
            <div class="card-body text-center">
                <h6 class="text-muted">Remaining This Month</h6>
                <h2 class="text-{{ auth()->user()->remaining_prompts > 2 ? 'success' : 'warning' }}">
                    {{ auth()->user()->remaining_prompts }} Prompts
                </h2>
            </div>
        </div>
         @endif
    
</div>
        </div>
    </div>
</div>

<script>
const form = document.getElementById('imagePromptForm');
const submitBtn = document.getElementById('submitBtn');
const btnText = document.getElementById('btnText');
const btnLoader = document.getElementById('btnLoader');

form.addEventListener('submit', function(e) {
    submitBtn.disabled = true;
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
});
</script>
@endsection
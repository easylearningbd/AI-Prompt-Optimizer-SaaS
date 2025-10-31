<!-- Gallery/Examples Section -->
@php
    $prompts = App\Models\PromptTemplate::with(['category'])->orderBy('id','desc')->limit(6)->get();
@endphp
<section id="examples" class="bg-gray-50 py-20">
<div class="max-w-7xl mx-auto px-6">
<div class="text-center mb-16">
<h2 class="text-4xl font-bold text-gray-900 mb-4">Prompt Templates</h2>
<p class="text-xl text-gray-600 max-w-3xl mx-auto">
See how our optimization has transformed prompts across different industries and use cases.
</p>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

@foreach ($prompts as $item)
 <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<div class="flex items-center justify-between mb-4">
<span class="text-sm font-medium text-primary bg-blue-50 px-3 py-1 rounded-full">{{ $item->category->name  }}</span>
<span class="text-green-500 font-medium text-sm">+85% Quality</span>
</div>
<h3 class="font-semibold text-gray-900 mb-3">{{ $item->name  }}</h3>
<p class="text-gray-600 text-sm mb-4">
{{ $item->description  }}
</p>
<div class="text-xs text-gray-500">
Marketing Agency • 2,500+ words generated
</div>
</div> 
@endforeach
 
 
 
</div>
</div>
</section>
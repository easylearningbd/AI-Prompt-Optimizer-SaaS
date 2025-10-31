@php
    $plans = [
        'free' => [
            'name' => 'Free',
            'price' => 0.00,
            'limit' => 5,
            'features' => [
                '5 prompt optimizations per month',
                'Access to all categories',
                'Community features',
                'Basic support',
            ],
            'cta' => 'Get Started Free',
            'cta_class' => 'border-2 border-gray-300 text-gray-700 hover:bg-gray-50',
            'popular' => false,
            'order' => 1,
        ],
        'pro' => [
            'name' => 'Pro',
            'price' => 9.99,
            'limit' => 10,
            'features' => [
                '10 prompt optimizations per month',
                'Access to all categories',
                'Priority community features',
                'JSON export support',
                'Email support',
            ],
            'cta' => 'Upgrade to Pro',
            'cta_class' => 'gradient-bg text-white hover:opacity-90',
            'popular' => true,
            'order' => 2,
        ],
        'essential' => [
            'name' => 'Essential',
            'price' => 19.99,
            'limit' => 20,
            'features' => [
                '20 prompt optimizations per month',
                'Access to all categories',
                'Premium community features',
                'Advanced JSON export',
                'Priority support',
                'Featured prompt requests',
            ],
            'cta' => 'Choose Essential',
            'cta_class' => 'border-2 border-gray-300 text-gray-700 hover:bg-gray-50',
            'popular' => false,
            'order' => 3,
        ],
    ];

    // Sort plans by order
    uasort($plans, function($a, $b) {
        return $a['order'] <=> $b['order'];
    });
@endphp

<section id="pricing" class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Start free and scale as you grow. All plans include our core optimization features.
            </p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($plans as $planKey => $plan)
                <div class="bg-white rounded-2xl p-8 border-2 {{ $plan['popular'] ? 'border-primary shadow-2xl' : 'border-gray-200' }} relative hover:shadow-xl transition-all duration-300 {{ $plan['popular'] ? 'transform md:scale-110 md:-mt-4 md:mb-4 z-10' : '' }}">
                    
                    <!-- Most Popular Badge -->
                    @if($plan['popular'])
                        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                            <span class="gradient-bg text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg uppercase tracking-wide">
                                <i class="ri-star-fill"></i>  Popular
                            </span>
                        </div>
                    @endif

                    <!-- Plan Name -->
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $plan['name'] }}</h3>

                        <!-- Price -->
                        <div class="mb-2">
                            <span class="text-5xl font-extrabold text-gray-900">
                                ${{ number_format($plan['price'], 2) }}
                            </span>
                            @if($plan['price'] > 0)
                                <span class="text-lg text-gray-600 font-medium">/month</span>
                            @endif
                        </div>

                        <!-- Prompt Limit Highlight -->
                        <p class="text-lg font-bold text-primary">
                            {{ $plan['limit'] }} prompts per month
                        </p>
                    </div>

                    <!-- Divider -->
                    <div class="border-t-2 border-gray-100 my-6"></div>

                    <!-- Features List -->
                    <ul class="space-y-4 mb-8">
                        @foreach($plan['features'] as $feature)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <!-- CTA Button or Current Plan Badge -->
                    @auth
                        @if(auth()->user()->subscription_plan === $planKey)
                            <!-- Current Plan Badge -->
                            <div class="w-full bg-green-50 border-2 border-green-500 text-green-700 py-3 rounded-xl font-bold text-center">
                                <i class="ri-check-circle-fill"></i> CURRENT PLAN
                            </div>
                        @else
                            <!-- Upgrade/Choose Button -->
                            <form action="{{ route('subscriptions.index') }}"  >
                                @csrf
                                <input type="hidden" name="plan" value="{{ $planKey }}">
                                <button type="submit" class="w-full {{ $plan['cta_class'] }} py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                    {{ $plan['cta'] }}
                                </button>
                            </form>
                        @endif
                    @else
                        <!-- Guest User - Register Button -->
                        <a href="{{ route('register') }}" class="block w-full {{ $plan['cta_class'] }} py-4 rounded-xl font-bold text-lg transition-all duration-300 text-center shadow-md hover:shadow-lg">
                            {{ $plan['cta'] }}
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>

        <!-- Additional Info -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center justify-center px-6 py-3 bg-blue-50 rounded-lg mb-4">
                <i class="ri-information-line text-blue-600 text-xl mr-2"></i>
                <p class="text-gray-700 font-medium">
                    All plans reset monthly. Unused prompts don't roll over.
                </p>
            </div>
            <p class="text-gray-600 mt-4">
                Need a custom solution? 
                <a href=" " class="text-primary font-semibold hover:underline">Contact us</a> 
                for enterprise pricing.
            </p>
        </div>
    </div>
</section>

<style>
.gradient-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Enhanced shadow for popular card */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(102, 126, 234, 0.25);
}

/* Hover shadow effect */
.hover\:shadow-xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Popular card border animation */
@keyframes pulse-border {
    0%, 100% {
        border-color: #667eea;
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
    }
    50% {
        border-color: #764ba2;
        box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
    }
}

.border-primary {
    animation: pulse-border 3s ease-in-out infinite;
}

/* Smooth transitions */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .md\:scale-110 {
        transform: scale(1) !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
}
</style>
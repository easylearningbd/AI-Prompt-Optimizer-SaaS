<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GrokService
{
    protected = $apiKey;
    protected = $baseUrl;
    protected = $model;
     

    public function __construct()
    {
        $this->apiKey = config('services.grok.api_key');
        $this->baseUrl = config('services.grok.base_url' ,'https://api.x.ai/v1');
        $this->model = config('services.grok.model','grok-3');

        // Log for debuggin purposes
        if (empty($this->apiKey)) {
            Log::warning('Grok API key is not set in configuration');
        } 
    }


    // Optimize a prompt using Grok API 
    public function optimizePrompt(){
        
    }



}

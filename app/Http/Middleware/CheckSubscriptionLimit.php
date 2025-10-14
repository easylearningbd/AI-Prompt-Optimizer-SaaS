<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        /// Allow admin user to bypass subscription check 
        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->is_banned) {
           auth()->logout();
           return redirect()->route('login')->with('error','Your account has been banned. Please contact with support team');
        }

        if (!$user->canOptimizePrompt()) {
            return redirect()->route('dashboard')->with('error','You have reached your monthly prompt limit. Please upgrade youru plan');
        }

        return $next($request);
    }
}

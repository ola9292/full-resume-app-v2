<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user has active payment subscription
        if (!$user->hasActivePayment()) {
            return redirect()->route('stripe.index')
                ->with('error', 'Active subscription required to access resume features. Please make a payment to continue.');
        }
        return $next($request);
    }
}

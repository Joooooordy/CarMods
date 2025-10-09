<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartIsNotEmpty
{
    public function handle(Request $request, Closure $next): Response
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        return $next($request);
    }
}

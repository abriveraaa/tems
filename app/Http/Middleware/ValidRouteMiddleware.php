<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laratrust;

class ValidRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Laratrust::hasRole(['administrator', 'assistant']))
        {
            return $next($request);
        }
        else 
        {
            return redirect('dashboard');    
        }        
    }
}

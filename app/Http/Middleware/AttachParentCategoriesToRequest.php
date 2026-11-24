<?php

namespace App\Http\Middleware;

use Closure;
use App\Utilities\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AttachParentCategoriesToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        View::share('parentCategories', Helper::getParentCategories());
        return $next($request);
    }
}

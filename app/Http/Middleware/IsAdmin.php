<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(auth()->user()->isAdmin== User::ADMIN) {
          return $next($request);
      }
      return redirect(route('home'));
    }
}

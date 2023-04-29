<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoggedIn {
  public function handle(Request $request, Closure $next): Response {
    if ($request->session()->has('access_token'))
      return $next($request);

    return redirect('/login');
  }
}

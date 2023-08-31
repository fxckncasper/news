<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $role): Response
    {
        if($request->user()->role !== $role  )
        {
            $notification = array(
                'message' => 'you cant access link !',
                'alert-type' => 'danger'
            );
            return redirect()->route('admin.dashboard')->with($notification);
        }
        return $next($request);
    }
}

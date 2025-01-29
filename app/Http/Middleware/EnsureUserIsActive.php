<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->status != 'active') {
            if ($request->user()->status != 'banned' && !$request->user()->hasVerifiedEmail()) {
                return redirect('/verify-email');
            } else {
                $reason = $request->user()->status == 'inactive' ? 'deactivated' : 'banned';
                return redirect()->route('homepage')->with('status', 'Your account has been ' . $reason);
            }
        }
 
        return $next($request);
    }
 
}
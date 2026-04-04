<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests, skip AJAX & asset requests
        if ($request->isMethod('GET') && !$request->ajax()) {
            try {
                $ip    = $request->ip();
                $today = now()->toDateString();

                $exists = VisitorLog::where('ip_address', $ip)
                    ->where('visit_date', $today)
                    ->exists();

                if (!$exists) {
                    $city = null;
                    if (auth()->check()) {
                        $city = auth()->user()->kota ?: null;
                    }

                    VisitorLog::create([
                        'user_id'    => auth()->id(),
                        'ip_address' => $ip,
                        'city'       => $city,
                        'visit_date' => $today,
                    ]);
                }
            } catch (\Exception $e) {
                // Silently fail — never break the request
            }
        }

        return $next($request);
    }
}

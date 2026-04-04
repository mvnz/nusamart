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
                    // Detect device type from User-Agent
                    $ua = strtolower($request->userAgent() ?? '');
                    $device = preg_match('/(android|iphone|ipad|ipod|mobile|blackberry|windows phone|opera mini|opera mobi)/i', $ua)
                        ? 'mobile' : 'desktop';

                    $city = null;
                    // Skip geolocation for localhost/private IPs
                    $privateIp = in_array($ip, ['127.0.0.1', '::1'])
                        || preg_match('/^(10\.|172\.(1[6-9]|2\d|3[01])\.|192\.168\.)/', $ip);

                    if (!$privateIp) {
                        try {
                            $geo = json_decode(file_get_contents(
                                "http://ip-api.com/json/{$ip}?fields=status,city&lang=id"
                            ), true);
                            if (isset($geo['status']) && $geo['status'] === 'success') {
                                $city = $geo['city'] ?? null;
                            }
                        } catch (\Exception $e) {
                            // Geolocation failed, city stays null
                        }
                    }

                    VisitorLog::create([
                        'user_id'     => auth()->id(),
                        'ip_address'  => $ip,
                        'city'        => $city,
                        'device_type' => $device,
                        'visit_date'  => $today,
                    ]);
                }
            } catch (\Exception $e) {
                // Silently fail — never break the request
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DetectUserLocation
{
    public function handle(Request $request, Closure $next)
    {
        // Skip if location is already set in session
        if (Session::has('user_location')) {
            return $next($request);
        }

        // Get location data from view composer
        $locationData = app('view')->getShared()['locationData'] ?? null;

        if (!$locationData) {
            return $next($request);
        }

        // Get user's IP address
        $ip = $request->ip();
        
        // Get location from IP (you can use any IP geolocation service)
        try {
            $location = file_get_contents("http://ip-api.com/json/{$ip}");
            $location = json_decode($location, true);

            if ($location && $location['status'] === 'success') {
                $latitude = $location['lat'];
                $longitude = $location['lon'];

                // Find nearest neighborhood
                $nearestLocation = $this->findNearestLocation($latitude, $longitude, $locationData);
                
                if ($nearestLocation) {
                    Session::put('user_location', $nearestLocation);
                }
            }
        } catch (\Exception $e) {
            // Log error if needed
        }

        return $next($request);
    }

    private function findNearestLocation($latitude, $longitude, $locationData)
    {
        $nearestLocation = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($locationData as $emirate => $districts) {
            foreach ($districts as $district => $neighborhoods) {
                foreach ($neighborhoods as $neighborhood) {
                    if ($neighborhood['lat'] && $neighborhood['lng']) {
                        $distance = $this->calculateDistance(
                            $latitude,
                            $longitude,
                            $neighborhood['lat'],
                            $neighborhood['lng']
                        );

                        if ($distance < $shortestDistance) {
                            $shortestDistance = $distance;
                            $nearestLocation = [
                                'name' => $neighborhood['name'],
                                'emirate' => $emirate,
                                'district' => $district,
                                'distance' => $distance
                            ];
                        }
                    }
                }
            }
        }

        return $nearestLocation;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Earth's radius in kilometers
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = 
            sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }
} 
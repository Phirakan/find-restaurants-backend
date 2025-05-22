<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

//This controller handles the search for restaurants using the Google Maps API
class RestaurantController extends Controller
{
    public function search(Request $request)
    {
        //get the keyword from the request, default to 'Bang Sue'
        $keyword = $request->query('keyword', 'Bang Sue');
        $cacheKey = 'restaurants_' . md5($keyword);

        //check if the data is already cached
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        //if not cached, make a request to the Google Maps API
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/place/textsearch/json", [
        'query' => $keyword . ' restaurant',
        'key' => env('GOOGLE_MAPS_API_KEY'), 
        ]);

        //check if the response is successful
        $data = $response->json();
        Cache::put($cacheKey, $data, 60 * 10); // 10 minutes cache

        return response()->json($data);
    }
} 

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return 'Connection is OK';
});


//Route to handle the search for restaurants using the Google Maps API
// This route is prefixed with 'api/' to indicate that it is part of the API
Route::prefix('api/')->group(function () {
    Route::get('/restaurants', 
        [RestaurantController::class, 'search'
    ]);

});


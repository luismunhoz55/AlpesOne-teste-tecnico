<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/listings', function () {
    return Listing::with('images')->get();
});

<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::apiResource('listings', ListingController::class);

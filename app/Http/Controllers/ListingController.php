<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Listing::with('images')->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        $validated = $request->validated();

        $listing = Listing::create($validated);

        return response()->json(['success' => true, 'listing' => $listing], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return $listing->load('images');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $validated = $request->validated();

        $listing->update($validated);

        return response()->json(['success' => true, 'listing' => $listing]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return response()->noContent();
    }
}

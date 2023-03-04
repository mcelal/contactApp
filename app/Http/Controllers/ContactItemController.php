<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactItemRequest;
use App\Http\Requests\UpdateContactItemRequest;
use App\Models\ContactItem;

class ContactItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreContactItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactItem $contactItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactItem $contactItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactItemRequest $request, ContactItem $contactItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactItem $contactItem)
    {
        //
    }
}

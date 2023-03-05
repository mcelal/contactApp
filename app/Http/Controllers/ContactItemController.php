<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactItemRequest;
use App\Http\Requests\UpdateContactItemRequest;
use App\Models\Contact;
use App\Models\ContactItem;
use Illuminate\Contracts\View\View;

class ContactItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Contact $contact): View
    {
        return view('contact_items.create', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Contact $contact, StoreContactItemRequest $request)
    {
        $contact->contactItems()->create($request->validated());

        return redirect()->route('contact.edit', $contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact, ContactItem $item): View
    {
        return view('contact_items.edit', compact('contact', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactItemRequest $request, Contact $contact, ContactItem $item)
    {
        $item->update($request->validated());

        return redirect()->route('contact.edit', [$contact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact, ContactItem $item)
    {
        $item->delete();

        return redirect()->route('contact.edit', [$contact]);
    }
}

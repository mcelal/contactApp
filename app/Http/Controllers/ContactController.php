<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\ContactItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contacts = Contact::query()
            ->where('user_id', '=', Auth::id())
            ->latest('created_at')
            ->paginate(20);

        return view('contact.list', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = Auth::id();

        $file = $request->file('photo');

        if ($request->hasFile('photo')) {
            $destination = implode(
                DIRECTORY_SEPARATOR,
                [
                    'public',
                    'uploads',
                    'contacts',
                    $inputs['user_id'],
                ]
            );
            $fileName = implode('.', [Str::random(), Str::slug($file->getClientOriginalExtension())]);

            // Save storage folder
            $file->storeAs($destination, $fileName);

            // Fill photo path for model
            $inputs['photo'] = implode(
                DIRECTORY_SEPARATOR,
                [
                    'contacts',
                    $inputs['user_id'],
                    $fileName
                ]);
        }

        Contact::create($inputs);

        return redirect()->route('contact.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        $contact->load('contactItems');

        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return redirect()->route('contact.edit', [$contact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if ($contact->user_id === Auth::id()) {
            if ($contact->photo) {
                Storage::delete('public/uploads/'.$contact->photo);
            }

            $contact->delete();
        }

        return redirect()->route('contact.index');
    }
}

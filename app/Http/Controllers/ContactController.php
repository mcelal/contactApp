<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * @return View
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
     * @param StoreContactRequest $request
     * @return RedirectResponse
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        $inputs['user_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

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
     * @param Contact $contact
     * @return View
     */
    public function edit(Contact $contact): View
    {
        $items = $contact->contactItems()->paginate(20);

        return view('contact.edit', compact('contact', 'items'));
    }

    /**
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $payload = $request->validated();

        if ($request->hasFile('photo')) {
            // Remove old photo
            if ($contact->photo) {
                Storage::delete('public/uploads/'.$contact->photo);
            }

            // Upload new photo
            $file = $request->file('photo');

            $destination = implode(
                DIRECTORY_SEPARATOR,
                [
                    'public',
                    'uploads',
                    'contacts',
                    $contact->user_id,
                ]
            );
            $fileName = implode('.', [Str::random(), Str::slug($file->getClientOriginalExtension())]);

            // Save storage folder
            $file->storeAs($destination, $fileName);

            // Fill photo path for model
            $payload['photo'] = implode(
                DIRECTORY_SEPARATOR,
                [
                    'contacts',
                    $contact->user_id,
                    $fileName
                ]);
        }

        $contact->update($payload);

        return redirect()->route('contact.edit', [$contact]);
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
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

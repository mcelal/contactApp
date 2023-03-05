<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreContactRequest;
use App\Http\Requests\Api\v1\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contact endpoints
 * @authenticated
 */
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam page integer Example: 1
     */
    public function index()
    {
        return Contact::query()
            ->where('user_id', '=', Auth::id())
            ->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContactRequest $request
     * @return mixed
     */
    public function store(StoreContactRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = Auth::id();

        return Contact::create($payload);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return Contact
     */
    public function show(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return Contact
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }

        $contact->update($request->validated());

        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return bool|null
     */
    public function destroy(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }

        return $contact->delete();
    }
}

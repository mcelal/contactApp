<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreContactItemRequest;
use App\Http\Requests\Api\v1\UpdateContactItemRequest;
use App\Models\Contact;
use App\Models\ContactItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contact items endpoints
 * @authenticated
 */
class ContactItemController extends Controller
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
            ->paginate(2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContactItemRequest $request
     * @param Contact $contact
     * @return ContactItem
     */
    public function store(StoreContactItemRequest $request, Contact $contact): ContactItem
    {
        return $contact->contactItems()->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @param ContactItem $item
     * @return ContactItem
     */
    public function show(Contact $contact, ContactItem $item): ContactItem
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }

        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactItemRequest $request
     * @param Contact $contact
     * @param ContactItem $item
     * @return ContactItem
     */
    public function update(UpdateContactItemRequest $request, Contact $contact, ContactItem $item): ContactItem
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }

        $item->update($request->validated());

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Contact $contact, ContactItem $item): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            App::abort(404, 'Not found !');
        }

        $item->delete();

        return response()->json([
            'status' => true,
        ]);
    }
}

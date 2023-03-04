<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contacts = Contact::query()
            ->where('user_id', '=', Auth::user()->id)
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
        $inputs['user_id'] = Auth::user()->id;

        $file = $request->file('photo');

        if ($file) {
            $destination = implode(DIRECTORY_SEPARATOR,['uploads', $inputs['user_id']]);
            $fileName = implode('.', [Str::random(), Str::slug($file->getClientOriginalExtension())]);

            $file = $file->move($destination, $fileName);

            $inputs['photo'] = $file->getPathname();
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
    public function edit(Contact $contact)
    {
        dump($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}

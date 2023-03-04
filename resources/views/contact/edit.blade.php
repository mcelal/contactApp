<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Contact') }}: {{ $contact->full_name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('contact.update', [$contact]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-auto">
                                    <div class="grid grid-cols-1 gap-6">
                                        <!-- Name -->
                                        <div class="col-auto">
                                            <x-label for="name" value="{{ __('Name') }}" />
                                            <x-input id="name" type="text" value="{{ old('name') ?? $contact->name }}" class="mt-1 block w-full" name="name" autocomplete="name" />
                                            <x-input-error for="name" class="mt-2" />
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-auto">
                                            <x-label for="last_name" value="{{ __('Last Name') }}" />
                                            <x-input id="last_name" type="text" value="{{ old('last_name') ?? $contact->last_name }}" class="mt-1 block w-full" name="last_name" autocomplete="last_name" />
                                            <x-input-error for="last_name" class="mt-2" />
                                        </div>

                                        <!-- Company -->
                                        <div class="col-auto">
                                            <x-label for="company" value="{{ __('Company') }}" />
                                            <x-input id="company" type="text" value="{{ old('company') ?? $contact->company }}" class="mt-1 block w-full" name="company" autocomplete="company" />
                                            <x-input-error for="company" class="mt-2" />
                                        </div>

                                        <!-- Photo Change -->
                                        <div class="col-auto">
                                            <x-label for="file" value="{{ __('Photo') }}" />
                                            <input type="file" name="photo" value="{{ old('photo') }}" placeholder="Choose photo" id="photo">
                                            <x-input-error for="photo" class="mt-2" />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <!-- Photo -->
                                    <div class="col-span-1 flex flex-col justify-center">
                                        @if($contact->photo && true)
                                            <div class="flex flex-wrap justify-center">
                                                <img
                                                    src="{{ asset($contact->photo ? 'uploads/'.$contact->photo : 'uploads/profile-blank.webp') }}"
                                                    class="max-w-sm rounded border bg-white p-1 dark:border-neutral-700 dark:bg-neutral-800"
                                                    alt="..." />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <x-button>
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light dark:text-gray-100">
                                    <thead
                                        class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-gray-600">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Type</th>
                                        <th scope="col" class="px-6 py-4">Data</th>
                                        <th scope="col" class="px-6 py-4">#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contact->contactItems as $contactItem)
                                        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $contactItem->type }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $contactItem->data }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 flex gap-x-0.5">
                                                <a
                                                    class="text-blue-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none"
                                                    href="{{ route('contact.edit', [$contact]) }}"
                                                >
                                                    Edit
                                                </a>
                                                |
                                                <form action="{{ route('contact.destroy', [$contact]) }}" method="post" onsubmit="return confirm('Are you sure to delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-blue-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

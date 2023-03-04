<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Contact') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Name -->
                                <div class="col-auto">
                                    <x-label for="name" value="{{ __('Name') }}" />
                                    <x-input id="name" type="text" value="{{ old('name') }}" class="mt-1 block w-full" name="name" autocomplete="name" />
                                    <x-input-error for="name" class="mt-2" />
                                </div>

                                <!-- Last Name -->
                                <div class="col-auto">
                                    <x-label for="last_name" value="{{ __('Last Name') }}" />
                                    <x-input id="last_name" type="text" value="{{ old('last_name') }}" class="mt-1 block w-full" name="last_name" autocomplete="last_name" />
                                    <x-input-error for="last_name" class="mt-2" />
                                </div>

                                <!-- Company -->
                                <div class="col-auto">
                                    <x-label for="company" value="{{ __('Company') }}" />
                                    <x-input id="company" type="text" value="{{ old('company') }}" class="mt-1 block w-full" name="company" autocomplete="company" />
                                    <x-input-error for="company" class="mt-2" />
                                </div>

                                <!-- Photo -->
                                <div class="col-auto">
                                    <input type="file" name="photo" value="{{ old('photo') }}" placeholder="Choose photo" id="photo">
                                    <x-input-error for="photo" class="mt-2" />
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
</x-app-layout>

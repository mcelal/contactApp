<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Contacts List') }}
            </h2>

            <a href="{{ route('contact.create') }}">
                <x-button>Create New</x-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-3">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead
                                        class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">First</th>
                                        <th scope="col" class="px-6 py-4">Last</th>
                                        <th scope="col" class="px-6 py-4">Company</th>
                                        <th scope="col" class="px-6 py-4">#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts as $contact)
                                        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                            <td class="whitespace-nowrap px-6 py-4 flex items-center gap-x-1">
                                                <img class="object-cover w-8 h-8 rounded-full" src="{{ asset($contact->photo ?? 'uploads/profile-blank.webp') }}" alt="">
                                                {{ $contact->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $contact->last_name }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $contact->company }}</td>
                                            <td>
                                                <div class="flex items-center gap-x-2">
                                                    <div>
                                                        <h2 class="text-sm font-medium text-gray-800 dark:text-white ">Andi Lane</h2>
                                                        <p class="text-xs font-normal text-gray-600 dark:text-gray-400">andi@example.com</p>
                                                    </div>
                                                </div>
                                            </td>
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
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

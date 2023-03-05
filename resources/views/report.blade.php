<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Report') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-3">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light dark:text-gray-100">
                                    <thead
                                        class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-gray-600">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Location</th>
                                        <th scope="col" class="px-6 py-4">Total</th>
                                        <th scope="col" class="px-6 py-4">People</th>
                                        <th scope="col" class="px-6 py-4">Phone</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($report as $row)
                                        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                            <td class="whitespace-nowrap px-6 py-4">{{ $row->value }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $row->total }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $people[$row->value] ?? '-' }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $phone[$row->value] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-3">
                                {{ $report->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
            {{ __('Junior List') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Junior List</h2>

                        <a href="{{ route('juniors.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" > 
                            + Create New Junior 
                        </a>
                    </div>
                </div>

                <div class="p-3 sm:p-6">
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Name</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Gender</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Start Date</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">End Date</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($juniors as $junior)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">
                                            {{ $junior->name }}
                                        </td>

                                        <td class="border-b border-l border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">
                                            {{ $junior->gender }}
                                        </td>

                                        <td class="border-b border-l border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">
                                            {{ $junior->start_date }}
                                        </td>

                                        <td class="border-b border-l border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">
                                            {{ $junior->end_date }}
                                        </td>

                                        <td class="border-b border-l border-gray-200 px-4 py-4 text-center text-sm">
                                            @if ($junior->status === 1)
                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                    Active
                                                </span>
                                            @else
                                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                    {{ $junior->status }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border-b border-l border-gray-200 px-4 py-4 text-center text-sm">
                                            <div class="flex items-center justify-center gap-2">

                                                {{-- View Button --}}
                                                <a
                                                    href="{{ route('juniors.show', $junior) }}"
                                                    class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                >
                                                    View
                                                </a>

                                                {{-- Delete Button --}}
                                                <form
                                                    action="{{ route('juniors.destroy', $junior) }}"
                                                    method="POST"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this junior?')"
                                                        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="3"
                                            class="px-4 py-8 text-center text-sm text-gray-500"
                                        >
                                            No juniors found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
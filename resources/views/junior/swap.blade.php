<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Swap Assignment</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Choose another junior to take over this task.
                    </p>
                </div>

                <div class="p-6">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ optional($assignment->chore)->chore_name ?? 'Task' }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Current assignee: {{ optional($assignment->junior)->name ?? 'Unassigned' }}
                        </p>

                        <form action="{{ route('swap.confirm', $assignment) }}" method="POST" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label for="junior_id" class="block text-sm font-medium text-gray-700">Assign to</label>
                                <select name="junior_id" id="junior_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($availableJuniors as $junior)
                                        <option value="{{ $junior->id }}">{{ $junior->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="rounded-md bg-yellow-600 px-4 py-2 text-sm font-semibold text-white hover:bg-yellow-700">
                                Confirm Swap
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
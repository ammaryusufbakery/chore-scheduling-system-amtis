<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Swap Assignment</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Choose another junior to take over this task.
                    </p>
                </div>

                <div class="p-3 sm:p-6">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 shadow-sm sm:p-5">
                        <h3 class="text-base font-semibold text-gray-900 sm:text-lg">
                            {{ optional($assignment->chore)->chore_name ?? 'Task' }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Current assignee: {{ optional($assignment->junior)->name ?? 'Unassigned' }}
                        </p>

                        <form action="{{ route('swap.confirm', $assignment) }}" method="POST" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label for="junior_id" class="block text-sm font-medium text-gray-700">Assign to</label>
                                <select name="junior_id" id="junior_id" class="mt-1 block w-full rounded-lg border-gray-300 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($availableJuniors as $junior)
                                        <option value="{{ $junior->id }}">{{ $junior->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <a href="{{ route('junior-dashboard') }}" class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 sm:w-auto">
                                    Back
                                </a>
                                <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto">
                                    Confirm Swap
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
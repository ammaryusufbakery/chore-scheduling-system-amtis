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
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Today's Assignments</h2>
                    <p class="mt-1 text-sm text-gray-600">All tasks assigned for today.</p>
                </div>

                <div class="p-3 sm:p-6">
                    @if ($todayAssignments->isNotEmpty())
                        <div class="grid gap-3 sm:gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($todayAssignments as $assignment)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 shadow-sm sm:p-5 {{ $assignment->status === 1 ? 'border-green-400 bg-green-50' : '' }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="text-base font-semibold text-gray-900">
                                            {{ optional($assignment->chore)->chore_name ?? 'Task' }}
                                        </h3>
                                        <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $assignment->status === 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                            {{ $assignment->status === 1 ? 'Done' : 'Pending' }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        Assigned to {{ optional($assignment->junior)->name ?? 'Unassigned' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-300 p-5 text-center text-sm text-gray-500 sm:p-6">
                            No tasks have been assigned for today yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                    <h2 class="text-xl font-semibold text-gray-900">Today's Assignments</h2>
                    <p class="mt-1 text-sm text-gray-600">All tasks assigned for today.</p>
                </div>

                <div class="p-6">
                    @if ($todayAssignments->isNotEmpty())
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($todayAssignments as $assignment)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 shadow-sm {{ $assignment->status === 1 ? 'border-green-400 bg-green-50' : '' }}">
                                    <div class="flex items-center justify-between gap-3">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ optional($assignment->chore)->chore_name ?? 'Task' }}
                                        </h3>
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $assignment->status === 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
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
                        <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                            No tasks have been assigned for today yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                    <h2 class="text-xl font-semibold text-gray-900">Today's Tasks</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $junior ? $junior->name : 'Your' }} assigned duties for today.
                    </p>
                </div>

                <div class="p-6">
                    @if ($todayAssignments->isNotEmpty())
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($todayAssignments as $assignment)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        {{ optional($assignment->schedule)->day ?? 'Today' }}
                                    </p>
                                    <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                        {{ optional($assignment->chore)->chore_name ?? 'Task' }}
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-600">
                                        Assigned to {{ $junior->name ?? 'you' }} for today.
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                            No tasks have been assigned to you for today.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

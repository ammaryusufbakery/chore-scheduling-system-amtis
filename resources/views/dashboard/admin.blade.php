<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
                {{ __('Dashboard') }}
            </h2>
            <button
                id="enable-notifications"
                type="button"
                class="inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-blue-700 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    />
                </svg>

                <span>Enable Notifications</span>
            </button>
        </div>
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

                                    @if ($assignment->status !== 1)
                                        <p class="mt-2 text-sm text-gray-600">
                                            {{ $assignment->chore->start_time }} - {{ $assignment->chore->end_time }}
                                        </p>

                                        <form action="{{ route('done', $assignment) }}" method="POST" class="mt-4 space-y-3">
                                            @csrf
                                            <button type="submit" class="w-full rounded-md bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 sm:w-auto">
                                                Done
                                            </button>
                                        </form>

                                        <form action="{{ route('swap', $assignment) }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto">
                                                Swap
                                            </button>
                                        </form>
                                    @else
                                        <p class="mt-4 text-sm font-medium text-green-700">This task has already been completed.</p>
                                    @endif
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

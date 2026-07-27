<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Schedule') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-3 sm:space-y-8 sm:px-6 lg:px-8">
            @php($currentWeek = $weeklyAssignments->keys()->first())
            @php($currentWeekAssignments = $weeklyAssignments->get($currentWeek, collect()))
            @php($nextWeek = $weeklyAssignments->keys()->last())
            @php($nextWeekAssignments = $weeklyAssignments->get($nextWeek, collect()))
            @php($days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])
            @php($currentTasks = $currentWeekAssignments->pluck('chore.chore_name')->filter()->unique())
            @php($nextTasks = $nextWeekAssignments->pluck('chore.chore_name')->filter()->unique())

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">This Week Overview</h2>
                    <p class="mt-1 text-sm text-gray-600">This week's overview.</p>
                </div>

                <div class="p-3 sm:p-6">
                    @if ($currentTasks->isNotEmpty())
                        <div class="hidden overflow-x-auto sm:block">
                            <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Task</th>
                                        @foreach ($days as $day)
                                            <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($currentTasks as $taskName)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-900">{{ $taskName }}</td>
                                            @foreach ($days as $day)
                                                @php($assignment = $currentWeekAssignments->first(function ($item) use ($taskName, $day) {
                                                    return optional($item->chore)->chore_name === $taskName && optional($item->schedule)->day === $day;
                                                }))
                                                <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                                    {{ optional($assignment->junior)->name ?? '—' }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-3 sm:hidden">
                            @foreach ($currentTasks as $taskName)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $taskName }}</h3>
                                        <span class="rounded-full bg-indigo-100 px-2 py-1 text-[11px] font-medium text-indigo-700">Daily roster</span>
                                    </div>
                                    <div class="mt-3 space-y-2">
                                        @foreach ($days as $day)
                                            @php($assignment = $currentWeekAssignments->first(function ($item) use ($taskName, $day) {
                                                return optional($item->chore)->chore_name === $taskName && optional($item->schedule)->day === $day;
                                            }))
                                            <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2">
                                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</span>
                                                <span class="text-sm font-medium text-gray-700">{{ optional($assignment->junior)->name ?? '—' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-300 p-5 text-center text-sm text-gray-500 sm:p-6">
                            {{ __('No assignments have been generated for this week yet.') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Next Week Overview</h2>
                    <p class="mt-1 text-sm text-gray-600">Next week's overview.</p>
                </div>

                <div class="p-3 sm:p-6">
                    @if ($nextTasks->isNotEmpty())
                        <div class="hidden overflow-x-auto sm:block">
                            <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Task</th>
                                        @foreach ($days as $day)
                                            <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($nextTasks as $taskName)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-900">{{ $taskName }}</td>
                                            @foreach ($days as $day)
                                                @php($assignment = $nextWeekAssignments->first(function ($item) use ($taskName, $day) {
                                                    return optional($item->chore)->chore_name === $taskName && optional($item->schedule)->day === $day;
                                                }))
                                                <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                                    {{ optional($assignment->junior)->name ?? '—' }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-3 sm:hidden">
                            @foreach ($nextTasks as $taskName)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $taskName }}</h3>
                                        <span class="rounded-full bg-indigo-100 px-2 py-1 text-[11px] font-medium text-indigo-700">Daily roster</span>
                                    </div>
                                    <div class="mt-3 space-y-2">
                                        @foreach ($days as $day)
                                            @php($assignment = $nextWeekAssignments->first(function ($item) use ($taskName, $day) {
                                                return optional($item->chore)->chore_name === $taskName && optional($item->schedule)->day === $day;
                                            }))
                                            <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2">
                                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</span>
                                                <span class="text-sm font-medium text-gray-700">{{ optional($assignment->junior)->name ?? '—' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-300 p-5 text-center text-sm text-gray-500 sm:p-6">
                            {{ __('No assignments have been generated for this week yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
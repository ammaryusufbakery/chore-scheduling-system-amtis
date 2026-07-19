<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Schedule') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php($currentWeek = $weeklyAssignments->keys()->first())
            @php($currentWeekAssignments = $weeklyAssignments[$currentWeek] ?? collect())
            @php($days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])
            @php($tasks = $currentWeekAssignments->pluck('chore.chore_name')->filter()->unique())

            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Current Week Overview</h2>
                    <p class="mt-1 text-sm text-gray-600">This week's assignments shown in a weekly calendar layout.</p>
                </div>

                <div class="p-6 overflow-x-auto">
                    @if ($tasks->isNotEmpty())
                        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Task</th>
                                    @foreach ($days as $day)
                                        <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($tasks as $taskName)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-900">{{ $taskName }}</td>
                                        @foreach ($days as $day)
                                            @php($assignment = $currentWeekAssignments->first(function ($item) use ($taskName, $day) {
                                                return optional($item->chore)->chore_name === $taskName && optional($item->schedule)->day === $day;
                                            }))
                                            <td class="border-l border-gray-200 px-4 py-4 text-sm text-gray-700 text-center">
                                                {{ optional($assignment->junior)->name ?? '—' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                            No assignments have been generated for the current week yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
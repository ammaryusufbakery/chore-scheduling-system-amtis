<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
            {{ __('Shutter Duty') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Shutter Duty</h2>
                    <p class="mt-1 text-sm text-gray-600">This week's shutter assignments.</p>
                </div>

                <div class="p-3 sm:p-6">
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Task</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Monday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Tuesday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Wednesday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Thursday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Friday</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="hover:bg-gray-50">
                                    <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">Open Shutter</td>
                                    @for ($day = 0; $day < 5; $day++)
                                        <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                            @if (isset($week1Open[$day]))
                                                {{ $week1Open[$day]->junior->name ?? '-' }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">Close Shutter</td>
                                    @for ($day = 0; $day < 5; $day++)
                                        <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                            @if (isset($week1Close[$day]))
                                                {{ $week1Close[$day]->junior->name ?? '-' }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-3 sm:hidden">
                        @php($rows = [['label' => 'Open Shutter', 'data' => $week1Open], ['label' => 'Close Shutter', 'data' => $week1Close]])
                        @foreach ($rows as $row)
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                <div class="mb-2 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $row['label'] }}</h3>
                                    <span class="rounded-full bg-indigo-100 px-2 py-1 text-[11px] font-medium text-indigo-700">This week</span>
                                </div>
                                @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday'] as $index => $day)
                                    <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2 {{ $index < 4 ? 'mb-2' : '' }}">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ isset($row['data'][$index]) && isset($row['data'][$index]->junior->name) ? $row['data'][$index]->junior->name : '—' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">Shutter Duty</h2>
                    <p class="mt-1 text-sm text-gray-600">Next week's shutter assignments.</p>
                </div>

                <div class="p-3 sm:p-6">
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="min-w-full overflow-hidden rounded-lg border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Task</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Monday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Tuesday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Wednesday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Thursday</th>
                                    <th class="border-b border-gray-200 border-l px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Friday</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="hover:bg-gray-50">
                                    <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">Open Shutter</td>
                                    @for ($day = 0; $day < 5; $day++)
                                        <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                            @if (isset($week2Open[$day]))
                                                {{ $week2Open[$day]->junior->name ?? '-' }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border-r border-gray-200 px-4 py-4 text-sm font-medium text-gray-800">Close Shutter</td>
                                    @for ($day = 0; $day < 5; $day++)
                                        <td class="border-l border-gray-200 px-4 py-4 text-center text-sm text-gray-700">
                                            @if (isset($week2Close[$day]))
                                                {{ $week2Close[$day]->junior->name ?? '-' }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-3 sm:hidden">
                        @php($rows2 = [['label' => 'Open Shutter', 'data' => $week2Open], ['label' => 'Close Shutter', 'data' => $week2Close]])
                        @foreach ($rows2 as $row)
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                <div class="mb-2 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $row['label'] }}</h3>
                                    <span class="rounded-full bg-indigo-100 px-2 py-1 text-[11px] font-medium text-indigo-700">Next week</span>
                                </div>
                                @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday'] as $index => $day)
                                    <div class="flex items-center justify-between rounded-lg bg-white px-3 py-2 {{ $index < 4 ? 'mb-2' : '' }}">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ isset($row['data'][$index]) && isset($row['data'][$index]->junior->name) ? $row['data'][$index]->junior->name : '—' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
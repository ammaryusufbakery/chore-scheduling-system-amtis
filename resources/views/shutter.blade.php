<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shutter Duty') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Shutter Duty</h2>
                    <p class="mt-1 text-sm text-gray-600">This week's shutter assignments.</p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
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
                                    <td class="border-l border-gray-200 px-4 py-4 text-sm text-gray-700 text-center">
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
                                    <td class="border-l border-gray-200 px-4 py-4 text-sm text-gray-700 text-center">
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
            </div>

            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Shutter Duty</h2>
                    <p class="mt-1 text-sm text-gray-600">Next week's shutter assignments.</p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
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
                                    <td class="border-l border-gray-200 px-4 py-4 text-sm text-gray-700 text-center">
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
                                    <td class="border-l border-gray-200 px-4 py-4 text-sm text-gray-700 text-center">
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
            </div>
        </div>
    </div>
</x-app-layout>
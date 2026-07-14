<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"></div>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Chore</th>
                    </tr>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->schedule->schedule_date ?? ''}}</td>
                            <td>{{ $assignment->junior->name ?? ''}}</td>
                            <td>{{ $assignment->chore->chore_name ?? ''}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
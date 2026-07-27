<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
            {{ __('Junior Details') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-3xl px-3 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">
                            Junior Details
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            View the details of this junior.
                        </p>
                    </div>

                    <a
                        href="{{ route('juniors.edit', $junior) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Edit
                    </a>
                </div>

                {{-- Details --}}
                <div class="divide-y divide-gray-200">

                    {{-- Name --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Name
                        </dt>

                        <dd class="text-sm text-gray-900 sm:col-span-2">
                            {{ $junior->name }}
                        </dd>
                    </div>

                    {{-- Gender --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Gender
                        </dt>

                        <dd class="text-sm text-gray-900 sm:col-span-2">
                            {{ $junior->gender }}
                        </dd>
                    </div>

                    {{-- Start Date --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Start Date
                        </dt>

                        <dd class="text-sm text-gray-900 sm:col-span-2">
                            {{ $junior->start_date }}
                        </dd>
                    </div>

                    {{-- End Date --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            End Date
                        </dt>

                        <dd class="text-sm text-gray-900 sm:col-span-2">
                            {{ $junior->end_date }}
                        </dd>
                    </div>

                    {{-- Preferences --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Preferences
                        </dt>

                        <dd class="sm:col-span-2">
                            @if (!empty($junior->preferences))
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($junior->preferences as $preference)
                                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">
                                            {{ $preference }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-sm text-gray-500">
                                    No preferences selected.
                                </span>
                            @endif
                        </dd>
                    </div>

                    {{-- Status --}}
                    <div class="grid grid-cols-1 gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>

                        <dd class="sm:col-span-2">
                            @if ($junior->status === 'Active')
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                    Inactive
                                </span>
                            @endif
                        </dd>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex justify-end border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6">
                    <a
                        href="{{ route('juniors.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Back to Junior List
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
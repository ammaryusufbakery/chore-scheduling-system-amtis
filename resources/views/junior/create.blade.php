<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl">
            {{ __('Create New Junior') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-3xl px-3 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-gray-200 px-4 py-4 sm:px-6 sm:py-5">
                    <h2 class="text-lg font-semibold text-gray-900 sm:text-xl">
                        Create New Junior
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Enter the details of the new junior.
                    </p>
                </div>

                {{-- Form --}}
                <form action="{{ route('juniors.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6 p-4 sm:p-6">

                        {{-- Name --}}
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label
                                for="gender"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Gender
                            </label>

                            <select
                                name="gender"
                                id="gender"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>

                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Dates --}}
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            {{-- Start Date --}}
                            <div>
                                <label
                                    for="start_date"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    id="start_date"
                                    value="{{ old('start_date') }}"
                                    required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div>
                                <label
                                    for="end_date"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    id="end_date"
                                    value="{{ old('end_date') }}"
                                    required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        {{-- Preferences --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Preferences
                            </label>

                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($preferences as $preference)
                                    <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:bg-gray-50">
                                        <input
                                            type="checkbox"
                                            name="preferences[]"
                                            value="{{ $preference }}"
                                            {{ in_array($preference, old('preferences', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        >

                                        <span class="text-sm text-gray-700">
                                            {{ $preference }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @error('preferences')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            @error('preferences.*')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6">

                        <a
                            href="{{ route('juniors.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Create
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
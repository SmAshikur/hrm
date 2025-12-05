<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department') }}
        </h2>
    </x-slot>
    <section class="max-w-xl mx-auto mt-10">
        {{-- Page Title --}}
        <header class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Create Department</h2>
            <p class="mt-1 text-sm text-gray-600">
                Add a new department to the HRM system.
            </p>
        </header>

        {{-- Card --}}
        <div class="bg-white shadow-lg rounded-lg p-6">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('departments.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Department Name --}}
                <div>
                    <x-input-label for="name" :value="__('Department Name')" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Enter department name"
                        :value="old('name')"
                        autofocus
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Buttons --}}
                <div class="flex justify-between items-center pt-4">

                    <a
                        href="{{ route('departments.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                        Back
                    </a>

                    <x-primary-button>
                        {{ __('Create Department') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </section>

</x-app-layout>

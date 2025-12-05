<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<section class="max-w-xl mx-auto mt-10">

    {{-- Page Header --}}
    <header class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Employee Details</h2>
        <p class="mt-1 text-sm text-gray-600">
            Detailed information of the selected employee.
        </p>
    </header>

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6 space-y-4">

        {{-- Employee Info --}}
        <div>
            <h3 class="text-lg font-medium text-gray-800">Full Name</h3>
            <p class="mt-1 text-gray-600">{{ $employee->first_name }} {{ $employee->last_name }}</p>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-800">Email</h3>
            <p class="mt-1 text-gray-600">{{ $employee->email }}</p>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-800">Department</h3>
            <p class="mt-1 text-gray-600">
                {{ $employee->department->name ?? '-' }}
            </p>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-800">Skills</h3>
            @if($employee->skills->count())
                <ul class="list-disc list-inside mt-1 text-gray-600">
                    @foreach($employee->skills as $skill)
                        <li>{{ $skill->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="mt-1 text-gray-400">No skills assigned.</p>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between pt-4">
            <a href="{{ route('employees.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                Back to List
            </a>

            <a href="{{ route('employees.edit', $employee->id) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                Edit Employee
            </a>
        </div>

    </div>
</section>
</x-app-layout>

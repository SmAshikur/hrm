<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department') }}
        </h2>
    </x-slot>
<section class="w-2/3 mx-auto py-8" style="max-width:70%;">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">


        <a href="{{ route('departments.create') }}"
           class="px-4 py-2 bg-indigo-600 text-dark rounded-md shadow hover:bg-indigo-700 transition">
            + Add New Department
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <div class="border-b px-4 py-3 bg-gray-50">
            <strong class="text-gray-700">Department List</strong>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b">#</th>
                        <th class="px-4 py-3 border-b">Department Name</th>
                        <th class="px-4 py-3 border-b text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($departments as $key => $department)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b">{{ $key + 1 }}</td>
                            <td class="px-4 py-3 border-b">{{ $department->name }}</td>

                            <td class="px-4 py-3 border-b text-right space-x-2">

                                {{-- View --}}
                                <a href="{{ route('departments.show', $department->id) }}"
                                   class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                    View
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('departments.edit', $department->id) }}"
                                   class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('departments.destroy', $department->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this department?');">

                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                No departments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</section>


</x-app-layout>

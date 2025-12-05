<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees Overview') }}
        </h2>
    </x-slot>

<section class="w-3/4 mx-auto py-8">

    {{-- Page Header --}}
    {{-- <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Employees Overview</h2>
    </div> --}}
    <div class="flex items-center justify-between mb-6">


        <a href="{{ route('employees.create') }}"
           class="px-4 py-2 bg-indigo-600 text-dark rounded-md shadow hover:bg-indigo-700 transition">
            + Add New Employee
        </a>
    </div>

    {{-- Filter by Department --}}
    <div class="mb-6">
        <label for="filterDept" class="block mb-2 text-gray-700 font-medium">Filter by Department</label>
        <select id="filterDept" class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
            <option value="">All Departments</option>
            @foreach($departments as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Employee Table --}}
    <div id="empTable" class="bg-white shadow-md rounded-lg overflow-x-auto">

        <div class="border-b px-4 py-3 bg-gray-50">
            <strong class="text-gray-700">Employee Details</strong>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">First Name</th>
                    <th class="px-4 py-3 text-left">Last Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Department</th>
                    <th class="px-4 py-3 text-left">Skills</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($employees as $key => $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $key + 1 }}</td>
                        <td class="px-4 py-3">{{ $employee->first_name }}</td>
                        <td class="px-4 py-3">{{ $employee->last_name }}</td>
                        <td class="px-4 py-3">{{ $employee->email }}</td>
                        <td class="px-4 py-3">{{ $employee->department->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($employee->skills->count())
                                {{ $employee->skills->pluck('name')->join(', ') }}
                            @else
                                <span class="text-gray-400">No skills</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">

                            <a href="{{ route('employees.show', $employee->id) }}"
                               class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                View
                            </a>

                            <a href="{{ route('employees.edit', $employee->id) }}"
                               class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition">
                                Edit
                            </a>

                            <form action="{{ route('employees.destroy', $employee->id) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this employee?');">

                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- No Employees --}}
        @if($employees->isEmpty())
            <div class="p-4 text-center text-gray-500">
                No employees found.
            </div>
        @endif

    </div>
</section>

{{-- jQuery for AJAX Filtering --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#filterDept').change(function(){
    let deptId = $(this).val();
    $.get("{{ route('employees.index') }}", { department_id: deptId }, function(data){

        let html = '';

        if(data.length === 0){
            html = `<tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No employees found.</td>
                    </tr>`;
        } else {
            data.forEach((emp, index) => {
                let skills = emp.skills.length ? emp.skills.map(s => s.name).join(', ') : '<span class="text-gray-400">No skills</span>';
                html += `<tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">${index + 1}</td>
                            <td class="px-4 py-3">${emp.first_name}</td>
                            <td class="px-4 py-3">${emp.last_name}</td>
                            <td class="px-4 py-3">${emp.email}</td>
                            <td class="px-4 py-3">${emp.department ? emp.department.name : '-'}</td>
                            <td class="px-4 py-3">${skills}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="/employees/${emp.id}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">View</a>
                                <a href="/employees/${emp.id}/edit" class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition">Edit</a>
                                <form action="/employees/${emp.id}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition">Delete</button>
                                </form>
                            </td>
                        </tr>`;
            });
        }

        $('#empTable tbody').html(html);
    });
});
</script>


</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
        <section class="max-w-xl mx-auto mt-10">

            {{-- Page Header --}}
            <header class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Edit Employee</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Update employee information and skills.
                </p>
            </header>

            {{-- Card --}}
            <div class="bg-white shadow-lg rounded-lg p-6 space-y-5">

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
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    {{-- First Name --}}
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input
                            id="first_name"
                            name="first_name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Enter first name"
                            :value="old('first_name', $employee->first_name)"
                            autofocus
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input
                            id="last_name"
                            name="last_name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Enter last name"
                            :value="old('last_name', $employee->last_name)"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="emailInput"
                            name="email"
                            type="email"
                            class="mt-1 block w-full"
                            placeholder="Enter email"
                            :value="old('email', $employee->email)"
                        />
                        <span id="emailMsg" class="text-sm mt-1 block text-gray-600"></span>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    {{-- Department --}}
                    <div>
                        <x-input-label for="department_id" :value="__('Department')" />
                        <select
                            id="department_id"
                            name="department_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Department</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ old('department_id', $employee->department_id) == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                    </div>

                    {{-- Skills --}}
                    <div>
                        <x-input-label :value="__('Skills')" />
                        <div id="skillsWrapper" class="space-y-2 mt-1">
                            @foreach(old('skills', $employee->skills->pluck('id')->toArray()) as $skillId)
                                <div class="flex items-center space-x-2 skillRow">
                                    <select name="skills[]" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-2 py-1">
                                        <option value="">Select Skill</option>
                                        @foreach($skills as $s)
                                            <option value="{{ $s->id }}" {{ $skillId == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="removeSkill px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition">X</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="addSkill"
                            class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            + Add Skill
                        </button>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('employees.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                            Back
                        </a>
                        <x-primary-button>
                            {{ __('Update Employee') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </section>

        {{-- Scripts --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Add / Remove skills dynamically
            $('#addSkill').click(function(){
                $('#skillsWrapper').append(`
                    <div class="flex items-center space-x-2 skillRow">
                        <select name="skills[]" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-2 py-1">
                            <option value="">Select Skill</option>
                            @foreach($skills as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="removeSkill px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition">X</button>
                    </div>
                `);
            });

            $(document).on('click','.removeSkill',function(){
                $(this).parent().remove();
            });

            // Real-time email check
            $('#emailInput').on('keyup', function(){
                  $.post('/check-email', { email: this.value, _token:'{{ csrf_token() }}' }, function(res){
                    $('#emailMsg').html(res.exists ? '<span class="text-red-600">Already exists</span>' : '<span class="text-green-600">Available</span>');
                }, 'json');
            });
        </script>
</x-app-layout>

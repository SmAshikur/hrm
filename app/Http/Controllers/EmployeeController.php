<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Skill;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index(Request $request){
        $departments = Department::orderBy('name')->get();
        $employees = Employee::with('department','skills')->orderBy('id','desc')->paginate(12);
        // If AJAX department filter requested
        if($request->ajax() && $request->has('department_id')){
            $deptId = $request->get('department_id');
            $emps = Employee::with('department','skills')
                    ->when($deptId != '', function($q) use ($deptId){
                        $q->where('department_id', $deptId);
                    })->get();
            return response()->json($emps);
        }
        return view('employees.index', compact('employees','departments'));
    }

    public function create(){
        $departments = Department::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();
        return view('employees.create', compact('departments','skills'));
    }

    public function store(StoreEmployeeRequest $request){
        $data = $request->only(['first_name','last_name','email','department_id']);
        $employee = Employee::create($data);
        // sync skills if any
        $skills = $request->input('skills', []);
        $employee->skills()->sync($skills);
        return redirect()->route('employees.index')->with('success','Employee created.');
    }

    public function show(Employee $employee){
        $employee->load('department','skills');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee){
        $departments = Department::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();
        $employee->load('skills');
        return view('employees.edit', compact('employee','departments','skills'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee){
        $employee->update($request->only(['first_name','last_name','email','department_id']));
        $employee->skills()->sync($request->input('skills', [])); // correct sync usage
        return redirect()->route('employees.index')->with('success','Employee updated.');
    }

    public function destroy(Employee $employee){
        $employee->delete();
        return back()->with('success','Employee deleted.');
    }
}

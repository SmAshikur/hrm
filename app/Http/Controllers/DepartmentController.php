<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;

class DepartmentController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index(){
        $departments = Department::orderBy('name')->get();
        return view('departments.index', compact('departments'));
    }

    public function create(){ return view('departments.create'); }

    public function store(StoreDepartmentRequest $request){
       // dd($request);
        Department::create($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created.');
    }
}

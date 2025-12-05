<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Requests\StoreSkillRequest;

class SkillController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index(){
        $skills = Skill::orderBy('name')->get();
        return view('skills.index', compact('skills'));
    }

    public function create(){ return view('skills.create'); }

    public function store(StoreSkillRequest $request){
       // dd($request);
        Skill::create($request->validated());
        return redirect()->route('skills.index')->with('success', 'Skill created.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:2');
    }
    public function index()
    {

        return view('admin.college.index');
    }
    public function retrieve()
    {
        return response()->json(College::all());
    }

    public function store(Request $request)
    {

        College::create([
            'name' => $request->name,
        ]);
        return redirect()->back()->with("message", "Added Successfully");
    }
}

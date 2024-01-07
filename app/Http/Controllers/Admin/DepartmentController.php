<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:2');
    }
    public function index()
    {
        return view('admin.department.index', [
            'college' => College::where('status', 1)->get(),
        ]);
    }

    public function store(Request $request)
    {
        Department::create([
            'college_id' => $request->college,
            'name' => trim($request->name),
        ]);
        return redirect()->back()->with("message", "Added Successfully");
    }
    public function retrieveCollegeDepartment(Request $request)
    {
        return response()->json(Department::where('college_id', $request->id)->get());
    }
    public function retrieve()
    {
        return response()->json(Department::with('college')->get());
    }
}

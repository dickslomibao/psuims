<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\DeparmentEvaluator as ModelsDeparmentEvaluator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeparmentEvaluator extends Controller
{
    public function index()
    {
        $excludeUserIds = ModelsDeparmentEvaluator::pluck('user_id')->toArray();
        $faculty =
            User::where('campus_id', Auth::user()->campus_id)
            ->where('college_id', Auth::user()->college_id)
            ->where('department_id', Auth::user()->department_id)
            ->where('id', '!=', Auth::user()->id)
            ->where('designation', 1)
            ->whereNotIn('id', $excludeUserIds)
            ->get();
        return view('faculty.department_evaluator.index', [
            'faculty' => $faculty,
        ]);
    }
    public function create(Request $request)
    {
        if ($request->faculty) {
            $faculty = $request->faculty;

            ModelsDeparmentEvaluator::create([
                'campus_id' => Auth::user()->campus_id,
                'college_id' => Auth::user()->college_id,
                'department_id' => Auth::user()->department_id,
                'user_id' =>  $faculty,
            ]);
        }
        return redirect()->back();
    }

    public function remove($id)
    {

        ModelsDeparmentEvaluator::where('id', $id)->delete();
        return redirect()->back();
    }
    public function getDepartmentEvaluator()
    {
        return response()->json(ModelsDeparmentEvaluator::with(['faculty'])->where('campus_id', Auth::user()->campus_id)
            ->where('college_id', Auth::user()->college_id)
            ->where('department_id', Auth::user()->department_id)->get());
    }
}

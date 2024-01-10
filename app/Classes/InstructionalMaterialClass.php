<?php

namespace App\Classes;

use App\Models\Constant;
use App\Models\Repo;
use Illuminate\Support\Facades\Auth;

class InstructionalMaterialClass
{
    public static function totalPendingOnDeptEvaluation()
    {
        return  Repo::with(['faculty', 't_type'])
            ->whereHas('faculty', function ($query) {
                $query->where(function ($subQuery) {
                    $user = Auth::user();
                    $subQuery->where('department_id', $user->department_id)
                        ->where('campus_id', $user->campus_id);
                });
            })
            ->where('user_id', '!=', Auth::user()->id)
            ->where('status', 1)
            ->count();
    }

    public static function totalPendingOnPlagiarism()
    {
        return Repo::where('status', 2)
            ->count();
    }


    public static function totalDepartmentEvaluator()
    {
        return Constant::first()->department_evaluator_count;
    }
    public static function totalPendingOnUe()
    {
        return  Repo::where('status', 3)
            ->count();
    }
}

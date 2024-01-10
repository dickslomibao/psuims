<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixSubCriteriasScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'matrix_criterias_scores_id',
        'title',
        'percentage',
    ];

    public function getGetDeptEvaluatorAttribute($user_id, $trial_number)
    {

        return ImDepartmentScore::where('user_id', $user_id)
            ->where('trial', $trial_number)
            ->where('matrix_sub_critertias_score_id', $this->id)
            ->first();
    }


    public function getGetUniversityEvaluatorAttribute($user_id, $trial_number)
    {

        return ImUniversityScore::where('user_id', $user_id)
            ->where('trial', $trial_number)
            ->where('matrix_sub_critertias_score_id', $this->id)
            ->first();
    }
}

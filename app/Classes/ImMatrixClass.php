<?php

namespace App\Classes;

use App\Models\ImDepartmentEvaluator;
use App\Models\ImDepartmentScore;
use App\Models\Matrix;
use App\Models\MatrixCriteria;
use App\Models\MatrixCriteriasScore;
use App\Models\MatrixSubCriteria;
use App\Models\MatrixSubCriteriasScore;
use App\Models\Repo;
use Illuminate\Support\Facades\Auth;

class  ImMatrixClass
{
    public static  function setImMatrix($repo_id)
    {
        $file = Repo::findOrFail($repo_id);

        if ($file->matrices_id == 0) {
            $matrix = Matrix::FindOrFail(Matrix::where('status', 1)->first()->id);
            foreach (MatrixCriteria::where('matrices_id',  $matrix->id)->get() as $m_c) {
                $newRecord =   MatrixCriteriasScore::create([
                    'repo_id' => $repo_id,
                    'title' => $m_c->title,
                    'percentage' => $m_c->percentage,
                    'created_by' => 'auto',
                ]);
                foreach (MatrixSubCriteria::where('matrix_criterias_id', $m_c->id)->get() as  $s_c) {
                    MatrixSubCriteriasScore::create([
                        'matrix_criterias_scores_id' =>  $newRecord->id,
                        'title' =>   $s_c->title,
                        'percentage' =>   $s_c->percentage
                    ]);
                }
            }
            $file->matrices_id =  $matrix->id;
            $file->save();
        }
    }
}

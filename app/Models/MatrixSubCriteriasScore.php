<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixSubCriteriasScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'matrix_criterias_scores_id',
        'title',
        'percentage',
        'score',
        'scored_by',
        'u_score',
        'u_score_by'
    ];
}

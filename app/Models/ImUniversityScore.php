<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImUniversityScore extends Model
{

    use HasFactory;

    protected $table = 'ims_university_score';

    protected $fillable = [
        'repo_id',
        'matrix_critertias_score_id',
        'matrix_sub_critertias_score_id',
        'trial',
        'score',
        'user_id'
    ];
}

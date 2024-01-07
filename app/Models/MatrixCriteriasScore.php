<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatrixCriteriasScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'repo_id',
        'title',
        'percentage',
        'created_by'
    ];

    public function subCriteria()
    {
        return $this->hasMany(MatrixSubCriteriasScore::class, 'matrix_criterias_scores_id', 'id');
    }

    public function by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}

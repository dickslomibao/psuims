<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixCriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'matrices_id',
        'title',
        'percentage',
    ];

    public function getTotalSubCriteriaPercentageAttribute()
    {
        return MatrixSubCriteria::where('matrix_criterias_id', $this->id)->sum('percentage');
    }
}

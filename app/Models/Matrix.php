<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status'
    ];

    public function getTotalCriteriaPercentageAttribute()
    {
        return MatrixCriteria::where('matrices_id', $this->id)->sum('percentage');
    }
}

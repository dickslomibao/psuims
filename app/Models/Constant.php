<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    use HasFactory;
    protected $table = 'constant';
    protected $fillable = ['department_evaluator_count', 'university_evaluator_count'];
}

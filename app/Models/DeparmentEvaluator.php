<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeparmentEvaluator extends Model
{
    use HasFactory;

    protected $table = "department_evaluator";

    protected $fillable = [
        'campus_id',
        'college_id',
        'department_id',
        'user_id',
        'status',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

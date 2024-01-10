<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImUniversityEvaluator extends Model
{
    use HasFactory;


    protected $table = 'im_university_evaluators';
    protected $fillable = [
        'repo_id',
        'user_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

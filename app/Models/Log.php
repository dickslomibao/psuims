<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'repo_id',
        'process_by',
        'code',
        'feedback'
    ];

    public function proccessBy()
    {
        return $this->belongsTo(User::class, 'process_by', 'id');
    }
}

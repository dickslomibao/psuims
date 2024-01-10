<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'college_id', 'status'];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected  $fillable = ['repo_id', 'comment', 'user_id'];
    public function by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

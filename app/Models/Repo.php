<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{


    use HasFactory, HasUuids;
    protected $fillable = ['id', 'title', 'type', 'user_id', 'original_name', 'path', 'status', 'matrices_id'];
    public function faculty()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function t_type()
    {
        return $this->belongsTo(Type::class, 'type', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'repo_id', 'id')->orderBy('created_at', 'desc');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'repo_id', 'id')->orderBy('created_at', 'asc');
    }
}

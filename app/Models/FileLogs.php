<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLogs extends Model
{
    use HasFactory;

    protected $table = 'file_logs';
    protected $fillable = ['repo_id', 'path', 'filaname', 'code'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Repo extends Model
{


    use HasFactory, HasUuids;
    protected $fillable = ['id', 'title', 'type', 'user_id', 'original_name', 'path', 'status', 'matrices_id', 'state', 'trial'];
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
    public function fileLogs()
    {
        return $this->hasMany(FileLogs::class, 'repo_id', 'id')->orderBy('created_at', 'desc');
    }
    public function matrix()
    {
        return $this->hasMany(MatrixCriteriasScore::class, 'repo_id', 'id');
    }
    public function departmentEvaluator()
    {
        return $this->hasMany(ImDepartmentEvaluator::class, 'repo_id', 'id');
    }
    public function universityEvaluator()
    {
        return $this->hasMany(ImUniversityEvaluator::class, 'repo_id', 'id');
    }
    public function getDeptUserEvaluatorAlreadyAttribute()
    {
        return ImDepartmentScore::where('repo_id', $this->id)->where('user_id', Auth::user()->id)->where('trial', $this->trial)->exists();
    }

    public function getUniversitytUserEvaluatorAlreadyAttribute()
    {
        return ImUniversityScore::where('user_id', Auth::user()->id)->where('trial', $this->u_trial)->exists();
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'repo_id', 'id')->orderBy('created_at', 'asc');
    }

    public function getDeptUserCurrentAvgAttribute($user_id)
    {
        $data = MatrixCriteriasScore::where('repo_id', $this->id)->get();

        $total  = 0;
        foreach ($data as $key => $value) {
            $total   += $value->getAverageOfDeAttribute($this->trial, $user_id);
        }
        return $total;
    }

    public function getUeUserCurrentAvgAttribute($user_id)
    {
        $data = MatrixCriteriasScore::where('repo_id', $this->id)->get();
        $total  = 0;
        foreach ($data as $key => $value) {
            $total   += $value->getAverageOfUeAttribute($this->u_trial, $user_id);
        }
        return $total;
    }

    public function getTotalCurrentSubmittedDeptScoreAttribute()
    {

        return ImDepartmentScore::where('repo_id', $this->id)
            ->where('trial', $this->trial)
            ->distinct('user_id')
            ->count();
    }
    public function getTotalCurrentSubmittedUniversityScoreAttribute()
    {

        return ImUniversityScore::where('repo_id', $this->id)
            ->where('trial', $this->trial)
            ->distinct('user_id')
            ->count();
    }

    public function getLogsScoreAttribute($user_id, $trial, $status)
    {
        return Log::where('repo_id', $this->id)->where('process_by', $user_id)->where('code', $status)->where('trial', $trial)->first();
    }
}

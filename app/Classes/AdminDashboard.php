<?php

namespace App\Classes;

use App\Models\Campuse;
use App\Models\College;
use App\Models\Department;
use App\Models\Repo;
use App\Models\User;

class AdminDashboard
{
    public static function totalCampus()
    {
        return Campuse::count();
    }
    public static function totalCollege()
    {
        return College::count();
    }

    public static function totalDepartment()
    {
        return Department::count();
    }
    public static function totalIms()
    {
        return Repo::count();
    }
    public static function getImsBasedOnStatus($status)
    {
        return Repo::where('status', $status)->count();
    }
    public static function getUserBasedOnStatus($designation)
    {
        return User::where('designation', $designation)->count();
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatus;
use App\Models\Campuse;
use App\Models\Organization;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function organization()
    {
      
        return view(
            "auth.organization",
            [
                'programs' => Program::all(),
                'campuses' => Campuse::all(),
            ]
        );
    }
    public function student()
    {
        return view(
            "auth.student",
            [
                'programs' => Program::all(),
                'campuses' => Campuse::all(),
            ]
        );
    }
    public function registerOrganization(Request $request)
    {
      
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'attributes' => ['required', 'string', 'max:255'],
            'campus' => ['required', 'string'],
            'program' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $path = $request->file('image')->storePublicly('public/profile');
        $path = Str::replace('public', 'storage', $path);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' =>  $path,
            'type' => 2,
        ]);

        Organization::create([
            'user_id' => $user->id,
            'campus_id' => $request->campus,
            'program_id' => $request->program,
            'name' => $request->name,
            'attributes' => $request->input('attributes'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function registerStudent(Request $request)
    {

        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string', 'max:255'],
            'campus' => ['required', 'string'],
            'program' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $path = $request->file('image')->storePublicly('public/profile');

        $path = Str::replace('public', 'storage', $path);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' =>  $path,
            'type' => 1,
        ]);
        Student::create([
            'user_id' => $user->id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'birthdate' => $request->birthdate,
            'gender' => $request->sex,
            'campus_id' => $request->campus,
            'program_id' => $request->program,
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}

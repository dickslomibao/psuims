<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Campuse;
use App\Models\College;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.regcustom', [
            'campuses' => Campuse::where('status', 1)->get(),
            'college' => College::where('status', 1)->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $code = 200;
        $message = 'success';
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $path = $request->file('image')->storePublicly('public', [
                'disk' => 'public'
            ]);
            $user = User::create([
                'campus_id' => $request->campus,
                'college_id' => $request->college,
                'department_id' => $request->department,
                'designation' => $request->designation,
                'profile_image' =>  'storage/' . $path,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            event(new Registered($user));
            Auth::login($user);
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
}

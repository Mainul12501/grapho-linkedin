<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Backend\EmployerCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider, Request $request)
    {
        if ($request->has('user'))
        session()->put('userType', $request->user ?? 'Employee');

        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider, Request $request)
    {
        $user = Socialite::driver($provider)->user();

        $existingUser = User::where('email', $user->email)->first();
        // dd($user);
        if ($existingUser) {
            Auth::login($existingUser);
            if ($existingUser->roles[0] == 3)
            {
                return redirect()->route('employee.home')->with('success', 'Your registration completed successfully.');
            } elseif ($existingUser->roles[0] == 4)
            {
                return redirect()->route('employer.home')->with('success', 'Your registration completed successfully.');
            }
        } else {
            $userType = session('userType') ?? 'Employee';
            $newUser = User::create([
                'name'          => $user->name,
                'email'         => $user->email,
//                'password'      => Hash::make(Str::random(8)),
                'provider_name' => $provider,
                'provider_id'   => $user->id,
                'provider_token' => $user->token,
                'user_slug'     => str_replace(' ', '-', $user->name),
                'user_type'     => $userType,
                'organization_name'     => $user->name.' company',
            ]);
            if ($newUser)
            {
                $company = new EmployerCompany();
                $company->user_id   = $newUser->id;
                $company->name  = $user->name.' company';
                $company->status    = 1;
                $company->save();
            }
            Auth::login($newUser);
            if ($userType == 'Employee')
            {
                $newUser->roles()->sync(3);
                return redirect()->route('employee.home')->with('success', 'Your registration completed successfully.');
            } elseif ($userType == 'Employer')
            {
                $newUser->roles()->sync(4);
                return redirect()->route('employer.home')->with('success', 'Your registration completed successfully.');
            }
        }
        return redirect()->route('/');
    }
}

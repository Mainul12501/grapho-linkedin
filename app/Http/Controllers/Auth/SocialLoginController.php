<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Backend\EmployerCompany;
use App\Models\User;
use http\Env\Response;
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

        if ($request->has('g_req_from'))
        session()->put('g_req_from', $request->g_req_from ?? 'login');


        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider, Request $request)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $existingUser = User::where('email', $user->email)->first();
        // dd($user);
        $customLoginController = new CustomLoginController();
        if ($existingUser) {
            Auth::login($existingUser);
            return $customLoginController->redirectsAfterLogin($existingUser);
            if ($existingUser->roles[0]->id == 3)
            {
                return redirect()->route('employee.home')->with('success', 'Your registration completed successfully.');
            } elseif ($existingUser->roles[0]->id == 4)
            {
                return redirect()->route('employer.home')->with('success', 'Your registration completed successfully.');
            }
        } else {
            $userType = session('userType') ?? 'Employee';
            $g_req_from = session('g_req_from') ?? 'login';
            if ($g_req_from == 'home')
            {
                session()->put('user', $user);
                return redirect()->route('/', ['has_redirect' => 1])->with('success', 'Select User Type.');
//                return redirect()->route('auth.select-user-type')->with('success', 'Select User Type.');
            }
            $newUser = User::create([
                'name'          => $user->name,
                'email'         => $user->email,
//                'password'      => Hash::make(Str::random(8)),
                'provider_name' => $provider,
                'provider_id'   => $user->id,
                'provider_token' => $user->token,
                'user_slug'     => str_replace(' ', '-', $user->name),
                'user_type'     => $userType,
                'zego_caller_id'     => str()->uuid()->toString(),
                'organization_name'     => $user->name.' company',
                'is_approved'   => $userType == 'employer' ? 0 : 1,
            ]);

            if ($newUser && $userType == 'Employer')
            {
                $company = new EmployerCompany();
                $company->user_id   = $newUser->id;
                $company->name  = $user->name.' company';
                $company->status    = 1;
                $company->save();
            }
            if ($userType == 'Employee')
            {
                $newUser->roles()->sync(3);
            } elseif ($userType == 'Employer')
            {
                $newUser->roles()->sync(4);
            }
            Auth::login($newUser);
            return $customLoginController->redirectsAfterLogin($newUser);
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

    public function createUser(Request $request)
    {
        $user = session()->get('user');
        $userType = $request->user_type ?? 'Employee';
        $provider = $request->provider ?? 'google';
        $newUser = User::create([
            'name'          => $user->name,
            'email'         => $user->email,
//                'password'      => Hash::make(Str::random(8)),
            'provider_name' => $provider,
            'provider_id'   => $user->id,
            'provider_token' => $user->token,
            'user_slug'     => str_replace(' ', '-', $user->name),
            'user_type'     => $userType,
            'zego_caller_id'     => str()->uuid()->toString(),
            'organization_name'     => $user->name.' company',
            'is_approved'   => $userType == 'Employer' ? 0 : 1,
        ]);
        if ($newUser && $userType == 'Employer')
        {
            $company = new EmployerCompany();
            $company->user_id   = $newUser->id;
            $company->name  = $user->name.' company';
            $company->status    = 1;
            $company->save();
        }
        if ($userType == 'Employee')
        {
            $newUser->roles()->sync(3);
        } elseif ($userType == 'Employer')
        {
            $newUser->roles()->sync(4);
        }
        Auth::login($newUser);
        $customLoginController = new CustomLoginController();
        return $customLoginController->redirectsAfterLogin($newUser);
    }

    public function gLoginCheck(Request $request)
    {
        $existUser = User::where('email', $request->email)->first();
        if ($existUser) {
            return \response()->json([
                'success' => false,
                'message' => 'Email already exists.',
                'user'  => $existUser,
            ]);
        } else {
            return \response()->json([
                'success' => true,
                'message' => 'Email not registered.',
                'user'  => null,
            ]);
        }
    }
}

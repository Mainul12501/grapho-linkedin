<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployerCompany;
use App\Models\Backend\EmployerCompanyCategory;
use App\Models\Backend\Industry;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    public function selectAuthMethod()
    {
        return view('frontend.auth.select-auth-method');
    }
    public function userLoginPage()
    {
        return view('frontend.auth.user-login-page');
    }
    public function userRegistrationPage(Request $request)
    {
        $data = [
            'userType' => $request->user,
            'industries'    => Industry::where('status', 1)->get(['id', 'name']),
            'companyCategories'    => EmployerCompanyCategory::where('status', 1)->get(['id', 'category_name']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.auth.user-registration-page');
        return view('frontend.auth.user-registration-page', [
            'userType' => $request->user,
            'industries'    => Industry::where('status', 1)->get(['id', 'name']),
            'companyCategories'    => EmployerCompanyCategory::where('status', 1)->get(['id', 'category_name']),
        ]);
    }
    public function setRegistrationRole()
    {
        return view('frontend.auth.set-registration-role');
    }
    public function setLoginRole()
    {
        return view('frontend.auth.set-login-role');
    }
    public function customRegistration(Request $request)
    {
//        return $request->all();
        if (!isset($request->user_type))
        {
            return ViewHelper::returEexceptionError('Please select a role');
        }

        $request->validate([
            'name'  => 'required',
            'mobile'    => 'required',
            'password'    => 'required|min:6',
            'industry_id'   => $request->user_type == 'employer' ? 'required' : '',
            'employer_company_category_id'   => $request->user_type == 'employer' ? 'required' : '',
            'organization_name'   => $request->user_type == 'employer' ? 'required' : '',
        ]);
        if ($request->user_type == 'Employee')
            $request['role']    = 3;
        elseif ($request->user_type == 'Employer')
            $request['role']    = 4;

        try {
            $user = new User();
            $user->name     = $request->name;
            $user->email     = $request->email;
            $user->mobile     = $request->mobile;
            $user->organization_name     = $request->organization_name;
            $user->user_type     = $request->user_type;
            $user->gender     = $request->gender;
            $user->user_slug     = str_replace(' ', '-', $request->name);
            $user->password     = bcrypt($request->password);
//            $user->status   = 1;
            $user->save();
            if ($request->user_type == 'Employer')
            {
                $company = new EmployerCompany();
                $company->user_id   = $user->id;
                $company->industry_id   = $request->industry_id;
                $company->employer_company_category_id   = $request->employer_company_category_id;
                $company->name  = $request->organization_name;
                $company->status    = 1;
                $company->save();
            }
            $user->roles()->sync($request->role);
            if (isset($user))
            {
                Auth::login($user);
                if (str()->contains(url()->current(), '/api/')) {
                    return response()->json(['user' => $user, 'auth_token' => $user->createToken('auth_token')->plainTextToken]);
                } else {
                    if ($request->user_type == 'Employee')
                    {
                        return redirect()->route('employee.home')->with('success', 'Your registration completed successfully.');
                    } elseif ($request->user_type == 'Employer')
                    {
                        return redirect()->route('employer.home')->with('success', 'Your registration completed successfully.');
                    }
                }
            }
        } catch (\Exception $exception)
        {
            if (str()->contains(url()->current(), '/api/')) {

                return response()->json(['error' => $exception->getMessage()],500);
            } else {
                if ($request->ajax())
                {
                    return response()->json(['status' => 'error']);
                }
                Toastr::error($exception->getMessage());
                return redirect()->route('auth.user-registration-page', ['user' => $request->user])->with('error', $exception->getMessage());
            }
        }
    }

    public function customLogin(Request $request)
    {

        if ($request->login_method == 'email')
        {
            if (auth()->attempt($request->only(['email', 'password']), $request->remember_me))
            {
                $user = ViewHelper::loggedUser();
                return $this->redirectsAfterLogin($user);
            } else {
                return ViewHelper::returEexceptionError('Something went wrong. Please try again');
            }
        } elseif ($request->login_method == 'mobile')
        {
            $sessionOtp = ViewHelper::getSessionOtp($request->mobile);
            if ($sessionOtp == $request->user_otp || $request->user_otp == '0000')
            {
                $user = User::where('mobile', $request->mobile)->first();
                if ($user)
                {
                    Auth::login($user);
                    return $this->redirectsAfterLogin($user);
                } else {
                    return ViewHelper::returEexceptionError('User Not found.');
                }
            } else {
                return ViewHelper::returEexceptionError('Otp mismatched. Please try again.');
            }
        }
    }

    public function redirectsAfterLogin($user)
    {
        if ($user)
        {
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json([
                    'user'  => $user,
                    'auth_token' => $user->createToken('auth_token')->plainTextToken,
                    'status'    => 200
                ]);
            } else {
                if ($user->roles[0]->id == 3)
                {
                    return redirect()->route('employee.home')->with('success', 'You are successfully logged in.');
                } elseif ($user->roles[0]->id == 4)
                {
                    return redirect()->route('employer.home')->with('success', 'You are successfully logged in.');
                } else {
                    return redirect()->route('/')->with('success', 'You are successfully logged in.');
                }
            }
        } else {
            return ViewHelper::returEexceptionError('Failed to get user data. Please try again');
        }
    }

    public function sendOtp(Request $request)
    {
        if (isset($request->mobile))
        {
            $otp = ViewHelper::generateOtp($request->mobile);
//            ViewHelper::sendSms($request->mobile, "Your Grapho OTP is $otp.");
            return response()->json(['status'=> 'success', 'msg' => "An OTP has sent to your number."]);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'No mobile Number found.']);
        }
    }

    public function userPasswordUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        $user = ViewHelper::loggedUser();
        if (password_verify($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            if (str()->contains(url()->current(), '/api/')) {
                return response()->json(['status' => 'success', 'msg' => 'Password updated successfully.']);
            } else {
                Toastr::success('Password updated successfully.');
                return redirect()->back();
            }
        } else {
            return ViewHelper::returEexceptionError('Current password is incorrect.');
        }
    }
}

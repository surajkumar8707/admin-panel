<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showCustomerRegistrationForm()
    {
        return view('auth.register');
    }

    public function customerRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $otp = '123456';
        session(['otp' => $otp]);
        session(['customer_data' => $request->all()]);

        // Normally, you would send the OTP via an SMS or email service
        // For demonstration purposes, we're just logging it
        \Log::info('Generated OTP: ' . $otp);

        return response()->json(['success' => true]);
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');
        if ($otp == session('otp')) {
            $customerData = session('customer_data');

            $customer = Customer::create([
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'password' => $customerData['password'],
                'approved' => false, // Set approved to true if needed
            ]);

            session()->forget(['otp', 'customer_data']);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
        }
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function showCustomerLoginForm()
    {
        return view('auth.login', ['url' => 'customer']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/admin/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/customer/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function customerLogout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/customer/login');
    }
}

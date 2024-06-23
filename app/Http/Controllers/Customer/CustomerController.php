<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        // dd('Customer Dashboard');
        return view('customer.dashboard');
    }

    public function show()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile.show', compact('customer'));
    }

    public function edit()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            // Add other validation rules as needed
        ]);

        $customer->update($validatedData);

        return redirect()->route('customer.profile.show')->with('success', 'Profile updated successfully.');
    }
}

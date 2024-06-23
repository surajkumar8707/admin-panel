<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $customers = Customer::count();
        return view('admin.dashboard', compact('customers'));
    }
}

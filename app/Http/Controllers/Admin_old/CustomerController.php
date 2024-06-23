<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        // dd($customers);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ]);

        $approved = (isset($request->approved) and ($request->approved == 1)) ? 1 : 0;

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => $approved,
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customers created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
        ]);

        $customer = Customer::findOrFail($id);
        $data['approved'] = (isset($request->approved) and ($request->approved == 1)) ? 1 : 0;
        // dd($data);
        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customers updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customers deleted successfully');
    }

    public function approve(Request $request, Customer $customer)
    {
        $approved = ($request->approved == 1) ? true : false;
        $customer->approved = $approved;
        $customer->save();
        // dd($approved, $customer->toArray(), $request->all());

        if($approved == true){
            $message = "Status Approved successfully";
        }
        else{
            $message = "Status unapproved successfully";
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}

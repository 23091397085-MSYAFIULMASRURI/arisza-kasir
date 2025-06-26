<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PointRedemption;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        $customers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('customers.index', compact('customers'));
    }


    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:customers,phone',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer ditambahkan.');
    }

    public function search(Request $request)
    {
        $keyword = $request->query('q');

        $customers = Customer::where('name', 'like', "%{$keyword}%")
            ->orWhere('phone', 'like', "%{$keyword}%")
            ->limit(10)
            ->get(['id', 'name', 'phone', 'total_spent', 'points']); // <-- pastikan 'points' ikut diambil

        return response()->json($customers);
    }


    public function show($id)
    {
        $customer = Customer::with(['transactions.items', 'redemptions'])->findOrFail($id);
        return view('customers.show', compact('customer'));
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:customers,phone,' . $customer->id,
        ]);

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}

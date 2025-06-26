<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $totalAmount = $request->total_amount;
        $newTotalSpent = $customer->total_spent + $totalAmount;

        // Hitung poin berdasarkan setiap Rp200.000 dapat 10 poin
        $poinSebelum = intdiv($customer->total_spent, 200000) * 10;
        $poinSesudah = intdiv($newTotalSpent, 200000) * 10;
        $poinBaru = $poinSesudah - $poinSebelum;

        // Simpan transaksi
        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'amount' => $totalAmount,
            'points_earned' => $poinBaru,
        ]);

        // Update customer
        $customer->increment('total_spent', $totalAmount);
        $customer->increment('points', $poinBaru);

        return redirect()->route('customers.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}

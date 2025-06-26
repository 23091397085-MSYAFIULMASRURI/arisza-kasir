<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PointRedemption;
use Illuminate\Http\Request;

class PointRedemptionController extends Controller
{
    /**
     * Menampilkan form penukaran poin
     */
    public function create()
    {
        return view('redemptions.create');
    }

    /**
     * Menyimpan penukaran poin
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:100',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        // Hitung total poin yang digunakan (1 barang = 10 poin)
        $totalPoints = 0;
        $descriptionParts = [];

        foreach ($request->items as $item) {
            $totalPoints += $item['quantity'] * 10;
            $descriptionParts[] = "{$item['name']} x{$item['quantity']}";
        }

        // Pastikan customer punya cukup poin
        if ($customer->points < $totalPoints) {
            return back()->with('error', 'Poin tidak mencukupi untuk penukaran ini.');
        }

        // Simpan penukaran poin
        PointRedemption::create([
            'customer_id' => $customer->id,
            'points_used' => $totalPoints,
            'description' => implode(', ', $descriptionParts), // contoh: "Roti x2, Kopi x1"
        ]);

        // Kurangi poin dari customer
        $customer->decrement('points', $totalPoints);

        return back()->with('success', 'Poin berhasil ditukarkan.');
    }

    /**
     * Mengambil riwayat penukaran poin untuk customer
     */
    public function history($customerId)
    {
        $history = PointRedemption::where('customer_id', $customerId)
            ->latest()
            ->take(10)
            ->get(['points_used', 'description', 'created_at']);

        return response()->json($history);
    }
}

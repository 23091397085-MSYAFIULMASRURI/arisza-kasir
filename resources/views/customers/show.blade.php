<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Detail Customer</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Informasi Customer --}}
        <div class="bg-white p-6 rounded shadow mb-8">
            <h3 class="text-lg font-semibold mb-4">Informasi Customer</h3>
            <div class="space-y-2">
                <p><strong>Nama:</strong> {{ $customer->name }}</p>
                <p><strong>No. Telepon:</strong> {{ $customer->phone }}</p>
                <p><strong>Total Belanja:</strong> Rp{{ number_format($customer->total_spent, 0, ',', '.') }}</p>
                <p><strong>Poin Saat Ini:</strong> {{ $customer->points }}</p>
            </div>
        </div>

        {{-- Riwayat Transaksi & Penukaran Poin --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Riwayat Transaksi --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Riwayat Transaksi</h3>
                @forelse ($customer->transactions as $transaction)
                    <div class="border-b py-3">
                        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y') }}</p>
                        <p><strong>Total Belanja:</strong> Rp{{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        <p><strong>Poin Didapat:</strong> {{ $transaction->points_earned }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">Belum ada transaksi.</p>
                @endforelse
            </div>

            {{-- Riwayat Penukaran Poin --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Riwayat Penukaran Poin</h3>
                @forelse ($customer->redemptions as $redeem)
                    <div class="border-b py-3">
                        <p><strong>Tanggal:</strong> {{ $redeem->created_at->format('d M Y') }}</p>
                        <p><strong>Poin Digunakan:</strong> {{ $redeem->points_used }}</p>
                        <p><strong>Deskripsi:</strong> {{ $redeem->description ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">Belum ada penukaran poin.</p>
                @endforelse
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8">
            <a href="{{ route('customers.index') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                ← Kembali ke Daftar Customer
            </a>
        </div>
    </div>
</x-app-layout>

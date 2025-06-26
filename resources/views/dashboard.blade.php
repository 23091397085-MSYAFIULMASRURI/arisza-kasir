<x-app-layout>
     <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard Loyalty Customer</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card: Customers -->
            <a href="{{ route('customers.index') }}"
               class="bg-gray-800 hover:bg-gray-700 transition text-white p-6 rounded-2xl shadow flex flex-col items-start space-y-2">
                <div class="text-3xl mb-2">
                    
                </div>
                <div class="text-lg font-bold">Pengelolaan Customer</div>
                <p class="text-sm text-gray-300">Tambah, ubah, atau hapus data pelanggan.</p>
            </a>

            <!-- Card: New Transaction -->
            <a href="{{ route('transactions.create') }}"
               class="bg-gray-800 hover:bg-gray-700 transition text-white p-6 rounded-2xl shadow flex flex-col items-start space-y-2">
                <div class="text-3xl mb-2">
                    
                </div>
                <div class="text-lg font-bold">Transaksi Baru</div>
                <p class="text-sm text-gray-300">Input pembelian dan otomatis hitung poin.</p>
            </a>

            <!-- Card: Redeem Points -->
            <a href="{{ route('redeem.create') }}"
               class="bg-gray-800 hover:bg-gray-700 transition text-white p-6 rounded-2xl shadow flex flex-col items-start space-y-2">
                <div class="text-3xl mb-2">
                    
                </div>
                <div class="text-lg font-bold">Penukaran Poin</div>
                <p class="text-sm text-gray-300">Tukar poin dengan reward menarik.</p>
            </a>
        </div>
    </div>
</x-app-layout>

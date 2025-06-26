<x-app-layout>
        <x-slot name="title">Transaksi Baru</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Customer</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6">
        <form action="{{ route('customers.store') }}" method="POST" class="bg-white shadow p-6 rounded space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Nama</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold">Nomor Telepon</label>
                <input type="text" name="phone" class="w-full border rounded p-2" required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 hover:underline">
                    ← Kembali ke Daftar Customer
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

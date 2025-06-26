<x-app-layout>
    <x-slot name="title">List Customer</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Daftar Customer</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

<div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
    {{-- Form Pencarian --}}
    <form action="{{ route('customers.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama atau nomor telepon..."
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Cari
        </button>
    </form>

    {{-- Tombol Tambah Customer --}}
    <div class="text-end">
        <a href="{{ route('customers.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah Customer
        </a>
    </div>
</div>



        
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Nomor Telepon</th>
                    <th class="px-4 py-2 border">Total Belanja</th>
                    <th class="px-4 py-2 border">Poin</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $customer->name }}</td>
                        <td class="border px-4 py-2">{{ $customer->phone }}</td>
                        <td class="border px-4 py-2">Rp{{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $customer->points }}</td>
                        <td class="border px-4 py-2 space-x-1">
                            <a href="{{ route('customers.show', $customer->id) }}"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                Detail
                            </a>

                            <a href="{{ route('customers.edit', $customer->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                Edit
                            </a>

                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus customer ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>

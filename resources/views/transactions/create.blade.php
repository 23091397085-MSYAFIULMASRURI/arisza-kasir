<x-app-layout>
    <x-slot name="title">Transaksi Baru</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Baru</h2>
    </x-slot>

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="max-w-3xl mx-auto py-6">
        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white shadow p-6 rounded space-y-6">
            @csrf

            {{-- Pencarian Customer --}}
            <div>
                <label class="block font-semibold mb-1">Pilih Customer</label>
                <select id="customerSelect" name="customer_id" class="select2 w-full border rounded p-2" required>
                    <option disabled selected value="">-- Pilih Customer --</option>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}" data-points="{{ $customer->points }}">
                            {{ $customer->name }} ({{ $customer->phone }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Poin Customer --}}
            <div id="pointsDisplay" class="text-sm text-gray-600">
                Poin yang dimiliki: <span id="currentPoints">-</span>
            </div>

            {{-- Nominal Pembelian --}}
            <div>
                <label class="block font-semibold mb-1">Nominal Pembelian (Rp)</label>
                <input type="number" name="total_amount" placeholder="Masukkan nominal..." class="w-full border p-2 rounded" required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    ← Kembali ke Dashboard
                </a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>

    {{-- jQuery & Select2 Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#customerSelect').select2({
                placeholder: 'Cari nama atau nomor telepon',
                allowClear: true,
                width: '100%'
            });

            $('#customerSelect').on('change', function () {
                let selected = $(this).find(':selected');
                let points = selected.data('points') || 0;
                $('#currentPoints').text(points);
            });

            // Jalankan jika customer sudah terpilih sebelumnya
            $('#customerSelect').trigger('change');
        });
    </script>
</x-app-layout>

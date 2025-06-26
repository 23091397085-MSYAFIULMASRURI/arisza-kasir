<x-app-layout>
    <x-slot name="title">Penukaran Poin</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tukar Poin</h2>
    </x-slot>

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="max-w-xl mx-auto py-6">
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Penukaran Poin --}}
        <form action="{{ route('redeem.store') }}" method="POST" class="bg-white shadow p-6 rounded space-y-4">
            @csrf

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

            <div id="pointsDisplay" class="text-sm text-gray-600">
                Poin yang dimiliki: <span id="currentPoints">-</span>
            </div>
{{-- Barang Ditukar --}}
<div id="items">
    <label class="block font-semibold mb-1">Barang Ditukar</label>
    <div class="grid grid-cols-2 gap-2 mb-2 item-row">
        <input type="text" name="items[0][name]" placeholder="Nama Barang" class="border p-2 rounded w-full">
        <input type="number" name="items[0][quantity]" placeholder="Jumlah" class="border p-2 rounded w-full" min="1" oninput="calculateTotalPoints()">
    </div>
</div>

<div class="flex items-center justify-between mb-4">
    <button type="button" onclick="addItem()" class="text-blue-600 text-sm hover:underline">
        + Tambah Barang
    </button>
</div>

{{-- Total Poin yang Dibutuhkan --}}
<div class="mb-4">
    <label class="block font-semibold mb-1">Total Poin yang Digunakan</label>
    <input type="number" name="points_used" id="totalPoints" class="border p-2 rounded bg-gray-100 w-full" readonly required>
</div>


            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    ← Kembali ke Dashboard
                </a>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                    Tukar Poin
                </button>
            </div>
        </form>

        {{-- Riwayat Penukaran --}}
        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-2">Riwayat Penukaran Poin</h3>
            <div id="historyTable" class="text-sm text-gray-700">
                <p>Silakan pilih customer untuk melihat riwayat.</p>
            </div>
        </div>
    </div>

<script>
    let itemIndex = 1;

    function addItem() {
        const container = document.getElementById('items');
        const newRow = document.createElement('div');
        newRow.classList.add('grid', 'grid-cols-2', 'gap-2', 'mb-2', 'item-row');

        newRow.innerHTML = `
            <input type="text" name="items[${itemIndex}][name]" placeholder="Nama Barang" class="border p-2 rounded w-full">
            <input type="number" name="items[${itemIndex}][quantity]" placeholder="Jumlah" class="border p-2 rounded w-full" min="1" oninput="calculateTotalPoints()">
        `;
        container.appendChild(newRow);
        itemIndex++;
    }

    function calculateTotalPoints() {
        let total = 0;
        const quantities = document.querySelectorAll('[name^="items"][name$="[quantity]"]');
        quantities.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value * 10;
        });
        document.getElementById('totalPoints').value = total;
    }

    // Hitung saat pertama kali dimuat
    document.addEventListener('DOMContentLoaded', calculateTotalPoints);
</script>


    {{-- jQuery & Select2 Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2
            $('#customerSelect').select2({
                placeholder: 'Cari nama atau nomor telepon',
                allowClear: true,
                width: '100%'
            });

            // Saat customer berubah
            $('#customerSelect').on('change', function () {
                let selected = $(this).find(':selected');
                let points = selected.data('points') || 0;
                $('#currentPoints').text(points);

                let customerId = $(this).val();
                if (customerId) {
                    fetch(`/redeem/history/${customerId}`)
                        .then(res => res.json())
                        .then(data => {
                            const tableDiv = document.getElementById('historyTable');
                            if (data.length === 0) {
                                tableDiv.innerHTML = '<p>Belum ada riwayat penukaran poin.</p>';
                                return;
                            }

                            let html = `
                                <table class="w-full border mt-2 text-sm">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border px-2 py-1 text-left">Tanggal</th>
                                            <th class="border px-2 py-1 text-left">Poin Digunakan</th>
                                            <th class="border px-2 py-1 text-left">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                            data.forEach(item => {
                                html += `
                                    <tr>
                                        <td class="border px-2 py-1">${new Date(item.created_at).toLocaleDateString()}</td>
                                        <td class="border px-2 py-1">${item.points_used}</td>
                                        <td class="border px-2 py-1">${item.description ?? '-'}</td>
                                    </tr>
                                `;
                            });
                            html += '</tbody></table>';
                            tableDiv.innerHTML = html;
                        });
                } else {
                    $('#currentPoints').text('-');
                    $('#historyTable').html('<p>Silakan pilih customer untuk melihat riwayat.</p>');
                }
            });

            // Jalankan update awal jika ada customer terpilih
            $('#customerSelect').trigger('change');
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tukar Poin</h2>
    </x-slot>

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
                <select id="customerSelect" name="customer_id" class="w-full border rounded p-2" required onchange="updatePoints()">
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

            <div>
                <label class="block font-semibold mb-1">Jumlah Poin yang Digunakan</label>
                <input type="number" name="points_used" class="w-full border rounded p-2" required min="10">
            </div>

            <div>
                <label class="block font-semibold mb-1">Keterangan</label>
                <input type="text" name="description" class="w-full border rounded p-2" placeholder="Contoh: Tukar Kopi / Roti Gratis">
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

    {{-- Script --}}
    <script>
        function updatePoints() {
            const select = document.getElementById('customerSelect');
            const selectedOption = select.options[select.selectedIndex];
            const points = selectedOption.getAttribute('data-points');
            document.getElementById('currentPoints').textContent = points;

            // Ambil dan tampilkan riwayat penukaran poin
            const customerId = select.value;
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
        }

        // Jalankan saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', updatePoints);
    </script>

    
</x-app-layout>

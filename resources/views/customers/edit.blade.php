<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Customer</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Nama</label>
                <input type="text" name="name" id="name"
                       class="w-full border p-2 rounded"
                       value="{{ old('name', $customer->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block font-semibold mb-1">Nomor Telepon</label>
                <input type="text" name="phone" id="phone"
                       class="w-full border p-2 rounded"
                       value="{{ old('phone', $customer->phone) }}" required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('customers.index') }}"
                   class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    ← Kembali
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

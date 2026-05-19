<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('loans.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div class="max-w-xl">
                        <x-input-label for="user_npm" value="Nama Mahasiswa (NPM)"/>
                        <x-select-input id="user_npm" name="user_npm" class="mt-1 block w-full" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($users as $npm => $name)
                                <option value="{{ $npm }}" {{ old('user_npm') == $npm ? 'selected' : '' }}>
                                    {{ $name }} ({{ $npm }})
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('user_npm')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="loan_at" value="Tanggal Pinjam"/>
                        <x-text-input id="loan_at" type="date" name="loan_at" class="mt-1 block w-full" value="{{ old('loan_at', date('Y-m-d')) }}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('loan_at')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="return_at" value="Tanggal Batas Pengembalian"/>
                        <x-text-input id="return_at" type="date" name="return_at" class="mt-1 block w-full" value="{{ old('return_at') }}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('return_at')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="book_ids" value="Buku yang Dipinjam (Gunakan Ctrl/Cmd + Klik untuk memilih lebih dari 1)"/>
                        <select id="book_ids" name="book_ids[]" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-32" multiple required>
                            @foreach($books as $id => $title)
                                <option value="{{ $id }}" {{ is_array(old('book_ids')) && in_array($id, old('book_ids')) ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('book_ids')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-secondary-button tag="a" href="{{ route('loans') }}">Cancel</x-secondary-button>
                        <x-primary-button name="save" value="true">Simpan Transaksi</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
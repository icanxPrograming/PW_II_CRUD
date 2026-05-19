<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proses Pengembalian Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('returns.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div class="max-w-xl">
                        <x-input-label for="loan_detail_id" value="Pilih Buku & Peminjam (Daftar Aktif)"/>
                        <x-select-input id="loan_detail_id" name="loan_detail_id" class="mt-1 block w-full" required>
                            <option value="">-- Pilih Daftar Pinjaman Aktif --</option>
                            @foreach($active_loans as $detail)
                                <option value="{{ $detail->id }}" {{ old('loan_detail_id') == $detail->id ? 'selected' : '' }}>
                                    {{ $detail->book->title ?? 'Buku N/A' }} 
                                    - Peminjam: {{ $detail->loan->user->first_name ?? 'N/A' }} {{ $detail->loan->user->last_name ?? '' }} ({{ $detail->loan->user_npm }})
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('loan_detail_id')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="charge" value="Dikenakan Denda / Biaya Tambahan?"/>
                        <x-select-input id="charge" name="charge" class="mt-1 block w-full" required>
                            <option value="0" {{ old('charge') == '0' ? 'selected' : '' }}>Tidak (0)</option>
                            <option value="1" {{ old('charge') == '1' ? 'selected' : '' }}>Ya (1)</option>
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('charge')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="amount" value="Nominal Denda (Isi 0 jika tidak ada)"/>
                        <x-text-input id="amount" type="number" name="amount" min="0" class="mt-1 block w-full" value="{{ old('amount', 0) }}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-secondary-button tag="a" href="{{ route('returns') }}">Cancel</x-secondary-button>
                        <x-primary-button name="save" value="true">Proses Pengembalian</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
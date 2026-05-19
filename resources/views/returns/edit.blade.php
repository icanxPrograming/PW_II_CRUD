<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaksi Pengembalian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('returns.update', $return->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="max-w-xl">
                        <x-input-label value="Buku & Peminjam (Tidak Dapat Diubah)"/>
                        <x-text-input type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-500 cursor-not-allowed" 
                            value="{{ $return->loanDetail->book->title ?? 'Buku N/A' }} - Peminjam: {{ $return->loanDetail->loan->user->first_name ?? 'N/A' }} {{ $return->loanDetail->loan->user->last_name ?? '' }}" 
                            disabled />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="charge" value="Dikenakan Denda / Biaya Tambahan?"/>
                        <x-select-input id="charge" name="charge" class="mt-1 block w-full" required>
                            <option value="0" {{ old('charge', $return->charge) == '0' ? 'selected' : '' }}>Tidak (0)</option>
                            <option value="1" {{ old('charge', $return->charge) == '1' ? 'selected' : '' }}>Ya (1)</option>
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('charge')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="amount" value="Nominal Denda"/>
                        <x-text-input id="amount" type="number" name="amount" min="0" class="mt-1 block w-full" value="{{ old('amount', $return->amount) }}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-secondary-button tag="a" href="{{ route('returns') }}">Cancel</x-secondary-button>
                        <x-primary-button value="true">Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
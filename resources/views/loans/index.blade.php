<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button tag="a" href="{{ route('loans.create') }}">Tambah Transaksi Peminjaman</x-primary-button>
                <x-primary-button tag="a" href="{{ route('loans.print') }}" target="blank">Print Peminjaman</x-primary-button>
            </div>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa (NPM)</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Pengembalian</th>
                        <th>Buku yang Dipinjam</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>

                @php $num = 1; @endphp
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $num++ }}</td>
                        <td>
                            @if($loan->user)
                                {{ $loan->user->first_name }} {{ $loan->user->last_name }}
                            @else
                                <span class="text-gray-400">Data User Kosong</span>
                            @endif 
                            <span class="text-sm text-gray-500">({{ $loan->user_npm }})</span>
                        </td>
                        <td>{{ $loan->loan_at->format('d M Y') }}</td>
                        <td>{{ $loan->return_at->format('d M Y') }}</td>
                        <td>
                            <ul class="list-disc list-inside text-sm">
                                @forelse($loan->loanDetails as $detail)
                                    <li class="{{ $detail->is_return ? 'line-through text-green-600 dark:text-green-400' : '' }}">
                                        {{ $detail->book->title ?? 'Buku Dihapus' }}
                                        @if($detail->is_return)
                                            <span class="text-xs font-semibold">(Selesai)</span>
                                        @endif
                                    </li>
                                @empty
                                    <span class="text-gray-400">Tidak ada item buku</span>
                                @endforelse
                            </ul>
                        </td>
                        <td>
                            <x-primary-button tag="a" href="{{ route('loans.edit', $loan->id) }}">Edit</x-primary-button>

                            <x-danger-button 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-loan-deletion-{{ $loan->id }}')"
                            >
                                Hapus
                            </x-danger-button>

                            <x-modal name="confirm-loan-deletion-{{ $loan->id }}" maxWidth="2xl" focusable>
                                <form action="{{ route('loans.destroy', $loan->id) }}" method="post" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 whitespace-normal break-words">
                                        Apakah Anda yakin ingin menghapus transaksi peminjaman ini?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-normal break-words">
                                        Menghapus transaksi ini juga akan menghapus seluruh data detail riwayat buku terkait di dalamnya!
                                    </p>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-loan-deletion-{{ $loan->id }}')">
                                            Batal
                                        </x-secondary-button>

                                        <x-danger-button type="submit">
                                            Ya, Hapus Transaksi
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</x-app-layout>
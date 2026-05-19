<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Transaksi Pengembalian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button tag="a" href="{{ route('returns.create') }}">Proses Pengembalian Baru</x-primary-button>
                <x-primary-button tag="a" href="{{ route('returns.print') }}" target="blank">Print Pengembalian</x-primary-button>
            </div>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th class="w-16">#</th>
                        <th>Mahasiswa (NPM)</th>
                        <th>Buku yang Dikembalikan</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Status Denda</th>
                        <th>Nominal Denda</th>
                        <th class="w-48">Aksi</th>
                    </tr>
                </x-slot>

                @php $num = 1; @endphp
                @foreach($returns as $return)
                    <tr>
                        <td>{{ $num++ }}</td>
                        <td>
                            @if($return->loanDetail && $return->loanDetail->loan && $return->loanDetail->loan->user)
                                {{ $return->loanDetail->loan->user->first_name }} {{ $return->loanDetail->loan->user->last_name }}
                            @else
                                <span class="text-gray-400">User Tidak Ditemukan</span>
                            @endif
                            <span class="text-sm text-gray-500">({{ $return->loanDetail->loan->user_npm ?? 'N/A' }})</span>
                        </td>
                        <td>
                            {{ $return->loanDetail->book->title ?? 'Buku Sudah Dihapus' }}
                        </td>
                        <td>
                            {{ $return->created_at ? $return->created_at->format('d M Y H:i') : date('d M Y H:i') }}
                        </td>
                        <td class="text-center">
                            @if($return->charge)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Ya
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Tidak
                                </span>
                            @endif
                        </td>
                        <td>
                            Rp {{ number_format($return->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            <x-primary-button tag="a" href="{{ route('returns.edit', $return->id) }}">Edit</x-primary-button>

                            <x-danger-button 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-return-deletion-{{ $return->id }}')"
                            >
                                Hapus
                            </x-danger-button>

                            <x-modal name="confirm-return-deletion-{{ $return->id }}" maxWidth="2xl" focusable>
                                <form action="{{ route('returns.destroy', $return->id) }}" method="post" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 whitespace-normal break-words">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-normal break-words">
                                        Menghapus log ini berisiko mengubah status buku menjadi belum dikembalikan!
                                    </p>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-return-deletion-{{ $return->id }}')">
                                            Batal
                                        </x-secondary-button>

                                        <x-danger-button type="submit">
                                            Ya, Hapus Data
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
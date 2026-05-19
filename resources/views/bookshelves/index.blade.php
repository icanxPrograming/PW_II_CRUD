<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Rak Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button tag="a" href="{{ route('bookshelves.create') }}">Tambah Data Rak</x-primary-button>
            </div>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th class="w-16">#</th>
                        <th>Kode Rak</th>
                        <th>Nama Rak Buku</th>
                        <th class="w-48">Aksi</th>
                    </tr>
                </x-slot>

                @php $num = 1; @endphp
                @foreach($bookshelves as $bookshelf)
                    <tr>
                        <td>{{ $num++ }}</td>
                        <td>{{ $bookshelf->code }}</td>
                        <td>{{ $bookshelf->name }}</td>
                        <td>
                            <x-primary-button tag="a" href="{{ route('bookshelves.edit', $bookshelf->id) }}">Edit</x-primary-button>

                            <x-danger-button 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-bookshelf-deletion-{{ $bookshelf->id }}')"
                            >
                                Hapus
                            </x-danger-button>

                            <x-modal name="confirm-bookshelf-deletion-{{ $bookshelf->id }}" maxWidth="2xl" focusable>
                                <form action="{{ route('bookshelves.destroy', $bookshelf->id) }}" method="post" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 whitespace-normal break-words">
                                        Apakah anda yakin ingin menghapus rak ini?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-normal break-words">
                                        Tindakan ini tidak dapat dibatalkan. Pastikan tidak ada buku yang masih terdaftar di rak ini agar tidak terjadi kesalahan relasi data.
                                    </p>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-bookshelf-deletion-{{ $bookshelf->id }}')">
                                            Batal
                                        </x-secondary-button>

                                        <x-danger-button type="submit">
                                            Ya, Hapus Rak
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
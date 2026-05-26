<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-button tag="a" href="{{ route('books.create') }}">Tambah Data Buku</x-primary-button>
                <x-primary-button tag="a" href="{{ route('books.print') }}" target="blank">Print Buku</x-primary-button>
                 <x-primary-button tag="a" href="{{ route('books.export') }}" target="blank">Export Buku</x-primary-button>
                <x-primary-button 
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal','import-book')"
                    >{{ __('Import Buku') }}
                </x-primary-button>
            </div>

            <x-modal name="import-book" focusable maxWidth="xl">
                <form method="post" action="{{ route('books.import') }}"
                    class="p-6" enctype="multipart/form-data">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">

                    {{ __('Import Data Buku') }}
                    </h2>
                    <div class="max-w-xl">
                        <x-input-label for="cover" class="sr-only" value="File
                        Import"/>

                        <x-file-input id="cover" name="file" class="mt-1 block w-
                        full" required/>

                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button class="ml-3">
                            {{ __('Upload') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Penerbit</th>
                        <th>Kota</th>
                        <th>Cover</th>
                        <th>Kode Rak</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>

                @php $num = 1; @endphp
                @foreach($books as $book)
                    <tr>
                        <td>{{ $num++ }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->city }}</td>
                        <td>
                            @if($book->cover)
                                <img src="{{ asset('storage/cover_buku/' . $book->cover) }}" width="100px" alt="Cover" />
                            @else
                                <span class="text-gray-400">No image</span>
                            @endif
                        </td>
                        <td>{{ $book->bookshelf->code }}-{{ $book->bookshelf->name }}</td>
                        <td>
                            <x-primary-button tag="a" href="{{ route('books.edit', $book->id) }}">Edit</x-primary-button>

                            <x-danger-button 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-book-deletion-{{ $book->id }}')"
                            >
                                Hapus
                            </x-danger-button>

                            <x-modal name="confirm-book-deletion-{{ $book->id }}" maxWidth="2xl" focusable>
                                <form action="{{ route('books.destroy', $book->id) }}" method="post" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 whitespace-normal break-words">
                                        Apakah Anda yakin ingin menghapus buku ini?
                                    </h2>

                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 whitespace-normal break-words">
                                        Anda akan menghapus buku <strong>"{{ $book->title }}"</strong>. Tindakan ini permanen dan akan menghapus berkas gambar sampul yang tersimpan di sistem data lokal.
                                    </p>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-book-deletion-{{ $book->id }}')">
                                            Batal
                                        </x-secondary-button>

                                        <x-danger-button type="submit">
                                            Ya, Hapus Buku
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
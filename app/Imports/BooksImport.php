<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Bookshelf;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $bookshelfRaw = isset($row['bookshelf']) ? trim($row['bookshelf']) : '';

        if (empty($bookshelfRaw)) {
            $code = 'UNKNOWN';
            $name = 'Tanpa Kategori';
        } else {
            $bookshelfData = explode('-', $bookshelfRaw);
            $code = trim($bookshelfData[0]);

            $name = isset($bookshelfData[1]) ? trim($bookshelfData[1]) : 'Rak ' . $code;
        }

        $bookshelf = Bookshelf::firstOrCreate(
            ['code' => $code],
            ['name' => $name]
        );

        return new Book([
            'title'        => $row['judul'],
            'author'       => $row['penulis'],
            'year'         => $row['tahun'],
            'publisher'    => $row['penerbit'],
            'city'         => $row['kota'],
            'bookshelf_id' => $bookshelf->id,
        ]);
    }
}

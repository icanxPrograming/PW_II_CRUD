<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'cover',
        'bookshelf_id',
    ];

    public function bookshelf()
    {
        return $this->belongsTo(Bookshelf::class, 'bookshelf_id', 'id');
    }

    public static function getDataBooks()
    {
        $books = Book::with('bookshelf')->get();
        $books_filter = [];

        foreach ($books as $index => $book) {
            $bookshelf_format = $book->bookshelf
                ? $book->bookshelf->code . '-' . $book->bookshelf->name
                : '-';

            $books_filter[$index] = [
                'no'        => $index + 1,
                'title'     => $book->title,
                'author'    => $book->author,
                'year'      => $book->year,
                'publisher' => $book->publisher,
                'city'      => $book->city,
                'bookshelf' => $bookshelf_format,
                'created_at' => $book->created_at ? $book->created_at->format('Y-m-d H:i:s') : '-',
            ];
        }

        return $books_filter;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $data['books'] = Book::with('bookshelf')->get();
        return view('books.index', $data);
    }

    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|max:255',
            'author'       => 'required|max:150',
            'year'         => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'publisher'    => 'required|max:100',
            'city'         => 'required|max:75',
            'quantity'     => 'required|numeric',
            'bookshelf_id' => 'required',
            'cover'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs(
                'cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::create($validated);

        $notification = [
            'message'    => 'Data buku berhasil ditambahkan',
            'alert-type' => 'success'
        ];

        if ($request->has('save')) {
            return redirect()->route('books')->with($notification);
        }

        return redirect()->route('books.create')->with($notification);
    }

    public function edit(int $id)
    {
        $data['book'] = Book::findOrFail($id);
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|max:255',
            'author'       => 'required|max:150',
            'year'         => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'publisher'    => 'required|max:100',
            'city'         => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::delete('public/cover_buku/' . $book->cover);
            }

            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }

        $book->update($validated);

        $notification = [
            'message'    => 'Data buku berhasil diperbarui',
            'alert-type' => 'success'
        ];

        return redirect()->route('books')->with($notification);
    }

    public function destroy(int $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover) {
            Storage::delete('public/cover_buku/' . $book->cover);
        }

        $book->delete();

        $notification = [
            'message'    => 'Data buku berhasil dihapus',
            'alert-type' => 'success'
        ];

        return redirect()->route('books')->with($notification);
    }

    public function print()
    {
        $books = Book::all();
        $pdf = Pdf::loadView('books.print', ['books' => $books]);
        return $pdf->stream('daftar_buku.pdf');
    }
}

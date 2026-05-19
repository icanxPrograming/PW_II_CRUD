<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\Request;

class BookshelfController extends Controller
{
    public function index()
    {
        $data['bookshelves'] = Bookshelf::all();
        return view('bookshelves.index', $data);
    }

    public function create()
    {
        return view('bookshelves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|max:10|unique:bookshelf,code',
            'name' => 'required|max:100',
        ]);

        Bookshelf::create($validated);

        $notification = [
            'message' => 'Data rak buku berhasil ditambahkan',
            'alert-type' => 'success'
        ];

        if ($request->save == true) {
            return redirect()->route('bookshelves')->with($notification);
        } else {
            return redirect()->route('bookshelves.create')->with($notification);
        }
    }

    public function edit(int $id)
    {
        $data['bookshelf'] = Bookshelf::findOrFail($id);
        return view('bookshelves.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $bookshelf = Bookshelf::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|max:10|unique:bookshelf,code,' . $id,
            'name' => 'required|max:100',
        ]);

        $bookshelf->update($validated);

        $notification = [
            'message' => 'Data rak buku berhasil diperbarui',
            'alert-type' => 'success'
        ];

        return redirect()->route('bookshelves')->with($notification);
    }

    public function destroy(int $id)
    {
        $bookshelf = Bookshelf::findOrFail($id);

        $bookshelf->delete();

        $notification = [
            'message' => 'Data rak buku berhasil dihapus',
            'alert-type' => 'success'
        ];

        return redirect()->route('bookshelves')->with($notification);
    }
}

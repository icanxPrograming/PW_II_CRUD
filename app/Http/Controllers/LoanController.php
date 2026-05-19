<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\LoanDetail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    public function index()
    {
        $data['loans'] = Loans::with(['user', 'loanDetails.book'])->get();
        return view('loans.index', $data);
    }

    public function create()
    {
        $data['users'] = User::select('npm', DB::raw("CONCAT(first_name, ' ', last_name) as full_name"))
            ->pluck('full_name', 'npm');

        $data['books'] = Book::pluck('title', 'id');
        return view('loans.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_npm'  => 'required|exists:users,npm',
            'loan_at'    => 'required|date',
            'return_at'  => 'required|date|after_or_equal:loan_at',
            'book_ids'   => 'required|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        $loan = Loans::create([
            'user_npm'  => $validated['user_npm'],
            'loan_at'    => $validated['loan_at'],
            'return_at'  => $validated['return_at'],
        ]);

        foreach ($validated['book_ids'] as $bookId) {
            LoanDetail::create([
                'loan_id'   => $loan->id,
                'book_id'   => $bookId,
                'is_return' => false,
            ]);
        }

        $notification = [
            'message'    => 'Transaksi peminjaman berhasil dicatat',
            'alert-type' => 'success'
        ];

        return redirect()->route('loans')->with($notification);
    }

    public function edit(int $id)
    {
        $data['loan'] = Loans::findOrFail($id);

        $data['users'] = User::select('npm', DB::raw("CONCAT(first_name, ' ', last_name) as full_name"))
            ->pluck('full_name', 'npm');

        return view('loans.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $loan = Loans::findOrFail($id);

        $validated = $request->validate([
            'user_npm' => 'required|exists:users,npm',
            'loan_at'   => 'required|date',
            'return_at' => 'required|date|after_or_equal:loan_at',
        ]);

        $loan->update($validated);

        $notification = [
            'message'    => 'Data peminjaman berhasil diperbarui',
            'alert-type' => 'success'
        ];

        return redirect()->route('loans')->with($notification);
    }

    public function destroy(int $id)
    {
        $loan = Loans::findOrFail($id);
        $loan->delete();

        $notification = [
            'message'    => 'Data transaksi peminjaman berhasil dihapus',
            'alert-type' => 'success'
        ];

        return redirect()->route('loans')->with($notification);
    }

    public function print()
    {
        $loans = Loans::with(['user', 'loanDetails.book'])->get();

        $pdf = Pdf::loadView('loans.print', [
            'loans' => $loans
        ]);

        return $pdf->stream('laporan_peminjaman_buku.pdf');
    }
}

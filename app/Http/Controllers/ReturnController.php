<?php

namespace App\Http\Controllers;

use App\Models\Returns;
use App\Models\LoanDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReturnController extends Controller
{
    public function index()
    {
        $data['returns'] = Returns::with('loanDetail.book')->get();
        return view('returns.index', $data);
    }

    public function create()
    {
        $data['active_loans'] = LoanDetail::with(['loan.user', 'book'])
            ->where('is_return', false)
            ->get();

        return view('returns.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_detail_id' => 'required|exists:loan_detail,id',
            'charge'         => 'required|boolean',
            'amount'         => 'required|numeric|min:0',
        ]);

        Returns::create($validated);

        $loanDetail = LoanDetail::findOrFail($validated['loan_detail_id']);
        $loanDetail->update(['is_return' => true]);

        $notification = [
            'message'    => 'Proses pengembalian buku berhasil diproses',
            'alert-type' => 'success'
        ];

        return redirect()->route('returns')->with($notification);
    }

    public function edit(int $id)
    {
        $data['return'] = Returns::with(['loanDetail.book', 'loanDetail.loan.user'])->findOrFail($id);

        return view('returns.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $returnData = Returns::findOrFail($id);

        $validated = $request->validate([
            'charge' => 'required|boolean',
            'amount' => 'required|numeric|min:0',
        ]);

        $returnData->update($validated);

        $notification = [
            'message'    => 'Data denda transaksi pengembalian berhasil diperbarui',
            'alert-type' => 'success'
        ];

        return redirect()->route('returns')->with($notification);
    }

    public function destroy(int $id)
    {
        $returnData = Returns::findOrFail($id);

        $loanDetail = LoanDetail::findOrFail($returnData->loan_detail_id);

        $loanDetail->update(['is_return' => false]);

        $returnData->delete();

        $notification = [
            'message'    => 'Data pengembalian berhasil dihapus',
            'alert-type' => 'success'
        ];

        return redirect()->route('returns')->with($notification);
    }

    public function print()
    {
        $returns = Returns::with(['loanDetail.book', 'loanDetail.loan.user'])->get();

        $pdf = Pdf::loadView('returns.print', [
            'returns' => $returns
        ]);

        return $pdf->stream('laporan_pengembalian_buku.pdf');
    }
}

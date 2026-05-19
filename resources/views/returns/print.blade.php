<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengembalian Buku</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 13px;
        }
        h1 {
            text-align: center;
            text-transform: uppercase;
            font-size: 20px;
            margin-bottom: 5px;
            color: #111;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #666;
        }
        th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            padding: 8px;
            text-align: center;
        }
        td {
            padding: 7px;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-sm {
            font-size: 11px;
            color: #555;
        }
        .denda-ya {
            color: #c62828;
            font-weight: bold;
        }
        .denda-tidak {
            color: #2e7d32;
        }
    </style>
</head>
<body>

    <h1>Laporan Transaksi Pengembalian Buku</h1>
    <p class="subtitle">Sistem Informasi Perpustakaan | Dicetak pada: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 25%;">MAHASISWA (NPM)</th>
                <th style="width: 25%;">JUDUL BUKU</th>
                <th style="width: 15%;">TANGGAL KEMBALI</th>
                <th style="width: 12%;">DENDA</th>
                <th style="width: 18%;">NOMINAL</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($returns as $return)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>
                    @if($return->loanDetail && $return->loanDetail->loan && $return->loanDetail->loan->user)
                        <strong>{{ $return->loanDetail->loan->user->first_name }} {{ $return->loanDetail->loan->user->last_name }}</strong>
                    @else
                        <strong>N/A</strong>
                    @endif
                    <div class="text-sm">NPM: {{ $return->loanDetail->loan->user_npm ?? 'N/A' }}</div>
                </td>
                <td>{{ $return->loanDetail->book->title ?? 'Buku Telah Dihapus' }}</td>
                <td class="text-center">{{ $return->created_at ? $return->created_at->format('d M Y H:i') : date('d M Y H:i') }}</td>
                <td class="text-center">
                    @if($return->charge)
                        <span class="denda-ya">Ya</span>
                    @else
                        <span class="denda-tidak">Tidak</span>
                    @endif
                </td>
                <td class="text-right">
                    Rp {{ number_format($return->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
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
        .text-sm {
            font-size: 11px;
            color: #555;
        }
        ul {
            margin: 0;
            padding-left: 15px;
        }
        li {
            margin-bottom: 2px;
        }
        .status-selesai {
            color: #2e7d32;
            font-size: 10px;
            font-weight: bold;
        }
        .status-pinjam {
            color: #c62828;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Laporan Transaksi Peminjaman Buku</h1>
    <p class="subtitle">Sistem Informasi Perpustakaan | Dicetak pada: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 25%;">MAHASISWA (NPM)</th>
                <th style="width: 15%;">TANGGAL PINJAM</th>
                <th style="width: 15%;">BATAS KEMBALI</th>
                <th style="width: 40%;">DAFTAR BUKU & STATUS ITEM</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($loans as $loan)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>
                    <strong>{{ $loan->user->first_name ?? 'N/A' }} {{ $loan->user->last_name ?? '' }}</strong>
                    <div class="text-sm">NPM: {{ $loan->user_npm }}</div>
                </td>
                <td class="text-center">{{ $loan->loan_at->format('d-m-Y') }}</td>
                <td class="text-center">{{ $loan->return_at->format('d-m-Y') }}</td>
                <td>
                    <ul>
                        @foreach($loan->loanDetails as $detail)
                            <li>
                                {{ $detail->book->title ?? 'Buku Telah Dihapus' }}
                                @if($detail->is_return)
                                    <span class="status-selesai">(Selesai Kembali)</span>
                                @else
                                    <span class="status-pinjam">(Masih Dipinjam)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
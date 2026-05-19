<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Koleksi Buku Perpustakaan</title>
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
            font-size: 22px;
            margin-bottom: 5px;
            color: #111;
            letter-spacing: 0.5px;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 12px;
            color: #666;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #777;
        }
        th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            padding: 10px 8px;
            text-align: center;
            letter-spacing: 0.5px;
        }
        td {
            padding: 8px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .cover-container {
            text-align: center;
            padding: 5px;
        }
        .cover-img {
            width: 65px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 2px;
            background: #fff;
        }
        .no-image {
            font-size: 11px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

    <h1>Daftar Koleksi Buku Perpustakaan</h1>
    <p class="subtitle">Sistem Informasi Perpustakaan | Laporan per Tanggal: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 15%;">COVER</th>
                <th style="width: 35%;">JUDUL BUKU</th>
                <th style="width: 20%;">PENULIS</th>
                <th style="width: 10%;">TAHUN</th>
                <th style="width: 15%;">PENERBIT</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($books as $book)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="cover-container">
                    @if($book->cover && file_exists(public_path('storage/cover_buku/'.$book->cover)))
                        <img src="{{ public_path('storage/cover_buku/'.$book->cover) }}" class="cover-img" alt="Cover">
                    @else
                        <span class="no-image">No Image</span>
                    @endif
                </td>
                <td><strong>{{ $book->title }}</strong></td>
                <td>{{ $book->author }}</td>
                <td class="text-center">{{ $book->year }}</td>
                <td>{{ $book->publisher }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
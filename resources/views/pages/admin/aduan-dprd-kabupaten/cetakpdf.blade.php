<!DOCTYPE html>
<html>
<head>
<style>
        @page {
            size: A4 landscape;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin-top: 100px; /* Tinggi kop surat */
        }
        .kop-surat {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #000;
        }
        .kop-surat h2 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-print {
            display: none;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>Bawaslu Surabaya</h2>
        <p>Jl. Raya Dharmahusada Indah No.100, Surabaya</p>
        <p>Telp: (031) 123456 | Email: bawaslu@surabaya.go.id</p>
        <p>Tahun Pemilihan: {{ $tahunPemilihan }}</p>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p>Data Aduan DPRD - KABUPATEN/KOTA</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelapor</th>
                <th>Jenis Atribut</th>
                <th>Jenis Pemilihan</th>
                <th>Nama</th>
                <th>Nama Partai</th>
                <th>Nama Jalan</th>
                <th>Dapil</th>
                <th>Tanggal Laporan</th>
                <th>Tanggal Akhir Ditertibkan</th>
                <th>Keterangan</th>
                <th>Tanggal Penertiban</th>
                <th>Jenis Penertiban</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aduans as $aduan)
                <tr>
                    <td>{{ $aduan->id }}</td>
                    <td>{{ $aduan->user->name }}</td>
                    <td>{{ $aduan->jenis_atribut }}</td>
                    <td>{{ $aduan->jenis_pemilihan }}</td>
                    <td>{{ $aduan->nama }}</td>
                    <td>{{ $aduan->nama_partai }}</td>
                    <td>{{ $aduan->nama_jalan }}</td>
                    <td>{{ $aduan->dapil }}</td>
                    <td>{{ $aduan->tanggal_laporan }}</td>
                    <td>{{ $aduan->tanggal_akhir_ditertibkan }}</td>
                    <td>{{ $aduan->keterangan }}</td>
                    <td>{{ $aduan->tanggal_penertiban }}</td>
                    <td>{{ $aduan->jenis_penertiban }}</td>
                </tr>
            @endforeach
    </tbody>
    </table>
</body>
</html>

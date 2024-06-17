<!DOCTYPE html>
<html>
<head>
    <title>Aduan Presiden dan Wakil Presiden</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .kop-surat {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 20px; /* Tambahkan margin bawah untuk memberi ruang */
        }
        .kop-surat h2 {
            margin: 0;
        }
        .content {
            margin-top: 120px; /* Beri ruang untuk kop surat di halaman pertama */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
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
        @media print {
            .kop-surat {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
            }
            .kop-surat + .content {
                margin-top: 180px; /* Sesuaikan dengan tinggi kop surat */
            }
            .kop-surat ~ table {
                page-break-before: auto;
            }
            .no-print {
                display: none;
            }
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

    <!-- Konten Aduan -->
    <div class="content">
    <br>
        <p>Aduan Presiden dan Wakil Presiden</p>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Pelapor</th>
                    <th>Jenis Atribut</th>
                    <th>Jenis Pemilihan</th>
                    <th>Nama Calon Presiden</th>
                    <th>Lokasi Pemasangan</th>
                    <th>Tanggal Laporan</th>
                    <th>Tanggal Akhir Ditertibkan</th>
                    <th>Keterangan</th>
                    <th>Tanggal Penertiban</th>
                    <th>Jenis Penertiban</th>
                </tr>
            </thead>
            <tbody>
            @php $no = 1; @endphp
                @foreach ($aduans as $aduan)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $aduan->user->name }}</td>
                        <td>{{ $aduan->jenis_atribut }}</td>
                        <td>{{ $aduan->jenis_pemilihan }}</td>
                        <td>{{ $aduan->nama_calon }}</td>
                        <td>{{ $aduan->nama_jalan }}</td>
                        <td>{{ $aduan->tanggal_laporan }}</td>
                        <td>{{ $aduan->tanggal_akhir_ditertibkan }}</td>
                        <td>{{ $aduan->keterangan }}</td>
                        <td>{{ $aduan->tanggal_penertiban }}</td>
                        <td>{{ $aduan->jenis_penertiban }}</td>
                       
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tombol Print -->
    <button class="no-print" onclick="window.print()">Print</button>
</body>
</html>

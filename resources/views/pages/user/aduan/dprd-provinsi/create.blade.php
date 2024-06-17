@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Content -->
        <div class="content">
            @include('../layout/components/top-bar-tenagaahli')
            <style>
                #map {
                    height: 400px;
                    width: 100%;
                }
            </style>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <br>
                            <div class="card-header">Tambah Aduan Calon DPRD PROVINSI</div>
                            <br>
                            <div class="card-body">
                                <form id="aduan_form" action="{{ route('aduan_dprd_provinsi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                   
                                    <div class="form-group mb-3">
                                        <label for="jenis_atribut">Jenis Atribut:</label>
                                        <select name="jenis_atribut" id="jenis_atribut" class="form-control">
                                            <option value="apk">APK</option>
                                            <option value="bk">BK</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nama">Nama Calon DPD RI:</label>
                                        <select name="nama" id="nama" class="form-control" onchange="updatePartaiDropdown()">
                                        <option value="">-- Pilih Calon --</option>
                                            @foreach ($presiden as $calon)
                                                <option value="{{ $calon->nama_calon_dprd }}" data-partai="{{ $calon->partai->nama_partai }}">{{ $calon->nama_calon_dprd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nama_partai">Nama Partai:</label>
                                        <input type="text" name="nama_partai" id="nama_partai" class="form-control" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lokasi_pemasangan">Pilih Lokasi Pemasangan:</label>
                                        <div id="map"></div>
                                        <!-- Input tersembunyi untuk menyimpan nilai koordinat lokasi pemasangan -->
                                        <input type="hidden" id="selected_location" name="lokasi_pemasangan">
                                        <!-- Input tersembunyi untuk menyimpan nama jalan -->
                                        <input type="hidden" id="nama_jalan" name="nama_jalan">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tahun_pemilihan_id">Tahun Aktif</label>
                                        <input type="text" class="form-control" id="tahun_pemilihan_id" name="tahun_pemilihan_id" value="{{ $activeYear->tahun_pemilihan_aktif }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nama_jalan_manual">Nama Jalan :</label>
                                        <input type="text" class="form-control" id="nama_jalan_manual" name="nama_jalan_manual">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tanggal_laporan">Tanggal Laporan:</label>
                                        <input type="date" class="form-control" id="tanggal_laporan" name="tanggal_laporan" value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tanggal_akhir_ditertibkan">Tanggal Akhir Ditertibkan:</label>
                                        <?php
                                        // Get the current date
                                        $currentDate = date('Y-m-d');
                                        
                                        // Add 3 days to the current date
                                        $tanggalAkhirditertibkan = date('Y-m-d', strtotime($currentDate . ' + 3 days'));
                                        ?>
                                        <input type="date" class="form-control" id="tanggal_akhir_ditertibkan" name="tanggal_akhir_ditertibkan" value="{{ $tanggalAkhirditertibkan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar_sebelum">Gambar Sebelum:</label>
                                        <input type="file" class="form-control" id="gambar_sebelum" name="gambar_sebelum">
                                    </div>
                                    <br>
                                    <button type="button" onclick="submitForm()" class="btn btn-primary">Tambah Aduan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

            <script>
                var map = L.map('map').setView([-6.2088, 106.8456], 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var marker = L.marker([-6.2088, 106.8456], { draggable: true }).addTo(map);

                function updateMarker(e) {
                    var markerLocation = marker.getLatLng();
                    document.getElementById('selected_location').value = markerLocation.lat + ',' + markerLocation.lng;

                    // Menggunakan OpenStreetMap Nominatim untuk mengonversi koordinat menjadi alamat
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${markerLocation.lat}&lon=${markerLocation.lng}`)
                        .then(response => response.json())
                        .then(data => {
                            // Memperbarui nilai input dengan alamat yang ditemukan
                            document.getElementById('lokasi_pemasangan').value = data.display_name;
                            
                            // Menyimpan nama jalan ke dalam input tersembunyi
                            document.getElementById('nama_jalan').value = data.address.road;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                marker.on('dragend', updateMarker);

                function onLocationFound(e) {
                    marker.setLatLng(e.latlng);
                    updateMarker(e);
                }

                function onLocationError(e) {
                    alert(e.message);
                }

                map.on('locationfound', onLocationFound);
                map.on('locationerror', onLocationError);

                map.locate({setView: true, maxZoom: 16});

                function submitForm() {
                    var namaJalanManual = document.getElementById('nama_jalan_manual').value;
                    if (namaJalanManual.trim() !== '') {
                        // Jika pengguna memasukkan nama jalan manual, simpan nilainya di field tersembunyi
                        document.getElementById('nama_jalan').value = namaJalanManual;
                    } else {
                        // Jika pengguna tidak memasukkan nama jalan manual, biarkan nilainya kosong
                        document.getElementById('nama_jalan').value = '';
                    }
                    // Lanjutkan dengan proses submit form
                    document.getElementById('aduan_form').submit();
                }

                function updatePartaiDropdown() {
                    var namaCalonSelect = document.getElementById('nama');
                    var selectedOption = namaCalonSelect.options[namaCalonSelect.selectedIndex];
                    var partai = selectedOption.getAttribute('data-partai');
                    
                    var namaPartaiInput = document.getElementById('nama_partai');
                    namaPartaiInput.value = partai;
                }
            </script>
@endsection

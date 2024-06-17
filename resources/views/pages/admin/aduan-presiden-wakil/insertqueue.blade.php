@extends('../layout/' . $layout)

@section('subhead')
    <title>Edit Aduan Presiden dan Wakil Presiden</title>
@endsection

@section('subcontent')

<div class="container">

<style>
    /* CSS untuk penataan formulir */
    .form-group {
        margin-bottom: 20px;
    }

    /* CSS untuk gambar */
    img {
        max-width: 100%;
        height: auto;
    }

    /* CSS untuk modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        color: #fff;
        position: absolute;
        top: 15px;
        right: 35px;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .image-preview {
    position: relative;
    width: 200px;
    height: auto;
}

.preview-image {
    max-width: 100%;
    height: auto;
}

.no-image {
    color: #888;
    font-style: italic;
}
</style>

<br>
    <h1>Aproval Aduan Presiden dan Wakil Presiden</h1>
    
    <form action="{{ route('updatequeuePresidenWakil', $aduan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <br>
        <div class="form-group">
    <label for="status">Status:</label>
    <input type="text" name="status" class="form-control" value="{{ $aduan->status }}" readonly>
</div>

        <div class="form-group">
            <label for="jenis_atribut">Jenis Atribut:</label>
            <input type="text" name="jenis_atribut" value="{{ $aduan->jenis_atribut }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="nama_calon">Nama Calon:</label>
            <input type="text" name="nama_calon" value="{{ $aduan->nama_calon }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="lokasi_pemasangan">Lokasi Pemasangan:</label>
            <div id="map" style="height: 300px;"></div>
        </div>
        <div class="form-group">
            <label for="lokasi_pemasangan">Lokasi Pemasangan:</label>
            <input type="text" name="lokasi_pemasangan" value="{{ $aduan->lokasi_pemasangan }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="nama_jalan">Nama Jalan:</label>
            <input type="text" name="nama_jalan" value="{{ $aduan->nama_jalan }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="tanggal_laporan">Tanggal Laporan:</label>
            <input type="date" name="tanggal_laporan" value="{{ $aduan->tanggal_laporan }}" class="form-control"readonly>
        </div>
        <div class="form-group">
            <label for="tanggal_akhir_ditertibkan">Tanggal Akhir Ditertibkan:</label>
            <input type="date" name="tanggal_akhir_ditertibkan" value="{{ $aduan->tanggal_akhir_ditertibkan }}" class="form-control"readonly>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <select name="keterangan" class="form-control">
                <option value="belum di tertibkan" {{ $aduan->keterangan == 'belum di tertibkan' ? 'selected' : '' }}>Belum di Tertibkan</option>
                <option value="terlambat" {{ $aduan->keterangan == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="done" {{ $aduan->keterangan == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_penertiban">Tanggal Penertiban:</label>
            <input type="date" name="tanggal_penertiban" value="{{ $aduan->tanggal_penertiban }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="jenis_penertiban">Jenis Penertiban:</label>
            <select name="jenis_penertiban" class="form-control">
                <option value="penertiban mandiri" {{ $aduan->jenis_penertiban == 'penertiban mandiri' ? 'selected' : '' }}>Penertiban Mandiri</option>
                <option value="penertiban satpol pp" {{ $aduan->jenis_penertiban == 'penertiban satpol pp' ? 'selected' : '' }}>Penertiban Satpol PP</option>
            </select>
        </div>

        <div class="form-group">
    <label for="gambar_sebelum">Gambar Sebelum:</label>
    <br>
    <br>
    <input type="file" name="gambar_sebelum" class="form-control-file">
   
    <div class="image-preview">
    <br>
        @if($aduan->gambar_sebelum)
            <a href="{{ asset('storage/' . $aduan->gambar_sebelum) }}" target="_blank" class="preview-link">
                <img src="{{ asset('storage/' . $aduan->gambar_sebelum) }}" alt="Gambar Sebelum" class="preview-image">
            </a>
        @else
            <p class="no-image">Belum upload</p>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="gambar_sesudah">Gambar Sesudah:</label>
    <br>
    <br>
    <input type="file" name="gambar_sesudah" class="form-control-file">
    <div class="image-preview">
        @if($aduan->gambar_sesudah)
            <a href="{{ asset('storage/' . $aduan->gambar_sesudah) }}" target="_blank" class="preview-link">
                <img src="{{ asset('storage/' . $aduan->gambar_sesudah) }}" alt="Gambar Sesudah" class="preview-image">
            </a>
        @else
        <br>
            <p class="no-image">Belum upload</p>
        @endif
    </div>
</div>


        <!-- Button Update -->
        <button type="submit" class="btn btn-primary">Aprove Aduan</button>
    </form>

    <!-- Modal untuk zoom gambar -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="zoomImage">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

<script>
    var koordinat = "{{ $aduan->lokasi_pemasangan }}".split(',');
    var latitude = parseFloat(koordinat[0]);
    var longitude = parseFloat(koordinat[1]);

    var map = L.map('map').setView([latitude, longitude], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);
    marker.bindPopup("<b>Lokasi Pemasangan</b><br>{{ $aduan->lokasi_pemasangan }}").openPopup();
</script>

<script>
// Fungsi untuk membuka modal gambar
function openModal(imgSrc) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("zoomImage");
    modal.style.display = "block";
    modalImg.src = imgSrc;
}

// Fungsi untuk menutup modal gambar
var closeModal = document.getElementsByClassName("close")[0];
closeModal.onclick = function() {
    var modal = document.getElementById("imageModal");
    modal.style.display = "none";
}
</script>
@endsection

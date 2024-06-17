@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Tambah Presiden dan Wakil Presiden</div>
                    <br>
                    <div class="card-body">
                        <form action="{{ route('storePresiden') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nama_presiden">Nama Presiden:</label>
                                <input type="text" class="form-control" id="nama_presiden" name="nama_presiden">
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama_wakil">Nama Wakil Presiden:</label>
                                <input type="text" class="form-control" id="nama_wakil" name="nama_wakil">
                            </div>

                            <div class="form-group mb-3">
                                
                                <label for="nama_wakil">Tahun Pemilihan Aktif:</label>
                                <select name="tahun_pemilihan_id" id="tahun_pemilihan_id" class="form-control" required>
                                    @foreach($tahunPemilihans as $tahunPemilihan)
                                        <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

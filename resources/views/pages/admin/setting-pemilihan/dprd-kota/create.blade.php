@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Tambah Calon DPRD Kota</div>
                    <div class="card-body">
                        <form action="{{ route('calon-dprd-kota.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_calon_dprd_kota">Nama Calon DPRD Kota:</label>
                                <input type="text" class="form-control" id="nama_calon_dprd_kota" name="nama_calon_dprd_kota">
                            </div>
                            <div class="form-group">
                                <label for="partai_id">Partai:</label>
                                <select name="partai_id" id="partai_id" class="form-control">
                                    @foreach($partais as $partai)
                                        <option value="{{ $partai->id }}">{{ $partai->nama_partai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_pemilihan_id">Tahun Pemilihan:</label>
                                <select name="tahun_pemilihan_id" id="tahun_pemilihan_id" class="form-control">
                                    @foreach($tahunPemilihans as $tahunPemilihan)
                                        <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dapil">Dapil:</label>
                                <select name="dapil" id="dapil" class="form-control">
                                    <option value="I">Dapil I</option>
                                    <option value="II">Dapil II</option>
                                    <option value="III">Dapil III</option>
                                    <option value="IV">Dapil IV</option>
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

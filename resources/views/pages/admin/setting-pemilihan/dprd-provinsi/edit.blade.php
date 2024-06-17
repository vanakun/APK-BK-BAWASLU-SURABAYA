@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                   <br>
                   <a class="btn btn-primary" href="{{ route('calon_dprd_provinsi.index') }}">Back</a>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('calon_dprd_provinsi.update', $calonDprdProvinsi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <br>
                            <div class="form-group">
                                <label for="nama_calon_dprd">Nama Calon DPRD:</label>
                                <input type="text" class="form-control" id="nama_calon_dprd" name="nama_calon_dprd" value="{{ $calonDprdProvinsi->nama_calon_dprd }}">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="partai_id">Partai:</label>
                                <select class="form-control" id="partai_id" name="partai_id">
                                    <option value="">Select Partai</option>
                                    @foreach($partais as $partai)
                                        <option value="{{ $partai->id }}" {{ $calonDprdProvinsi->partai_id == $partai->id ? 'selected' : '' }}>{{ $partai->nama_partai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tahun_pemilihan_id">Tahun Pemilihan:</label>
                                <select class="form-control" id="tahun_pemilihan_id" name="tahun_pemilihan_id">
                                    <option value="">Select Tahun Pemilihan</option>
                                    @foreach($tahunPemilihans as $tahunPemilihan)
                                        <option value="{{ $tahunPemilihan->id }}" {{ $calonDprdProvinsi->tahun_pemilihan_id == $tahunPemilihan->id ? 'selected' : '' }}>{{ $tahunPemilihan->tahun_pemilihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

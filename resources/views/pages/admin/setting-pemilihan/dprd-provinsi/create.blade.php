@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Create New Calon DPRD Provinsi</div>
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

                        <form action="{{ route('calon_dprd_provinsi.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_calon_dprd">Nama Calon DPRD:</label>
                                <input type="text" class="form-control" id="nama_calon_dprd" name="nama_calon_dprd" placeholder="Enter Nama Calon DPRD">
                            </div>
                            <div class="form-group">
                                <label for="partai_id">Partai:</label>
                                <select class="form-control" id="partai_id" name="partai_id">
                                    <option value="">Select Partai</option>
                                    @foreach($partais as $partai)
                                        <option value="{{ $partai->id }}">{{ $partai->nama_partai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun_pemilihan_id">Tahun Pemilihan:</label>
                                <select class="form-control" id="tahun_pemilihan_id" name="tahun_pemilihan_id">
                                    <option value="">Select Tahun Pemilihan</option>
                                    @foreach($tahunPemilihans as $tahunPemilihan)
                                        <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


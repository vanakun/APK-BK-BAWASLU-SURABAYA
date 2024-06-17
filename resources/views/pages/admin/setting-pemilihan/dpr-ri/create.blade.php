@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
        <br>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('indexDprRi') }}">Back</a>
            </div>
            <br>
        </div>
    </div>

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

    <form action="{{ route('StoreDprRi') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="form-group">
                    <strong>Nama:</strong>
                    <input type="text" name="nama" class="form-control" placeholder="Nama">
                </div>
            </div>
            <div class="col-md-6">
            <br>
                <div class="form-group">
                    <strong>Partai:</strong>
                    <select id="partai_id" name="partai_id" class="form-control" required>
                        <option value="">Select Partai</option>
                        @foreach($partais as $partai)
                            <option value="{{ $partai->id }}">{{ $partai->nama_partai }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <br>
                <div class="form-group">
                    <strong>Tahun Pemilihan:</strong>
                    <select name="tahun_pemilihan_id" id="tahun_pemilihan_id" class="form-control" required>
                        <option value="">Select Tahun Pemilihan</option>
                        @foreach($tahunPemilihans as $tahunPemilihan)
                            <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
        <br>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection

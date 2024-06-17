@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
               <div class="pull-right">
                <br>
                <a class="btn btn-primary" href="{{ route('indexpartai') }}">Back</a>
            </div>
            </div>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('storepartai') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <br>
                <strong>Nama Partai:</strong>
                <br>
                <input type="text" name="nama_partai" class="form-control" placeholder="Nama Partai" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <br>
                <strong>Tahun Pemilihan Aktif:</strong>
                <br>
                <select name="tahun_pemilihan_id" id="tahun_pemilihan_id" class="form-control" required>
                    @foreach($tahunPemilihans as $tahunPemilihan)
                        <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

    </div>
@endsection

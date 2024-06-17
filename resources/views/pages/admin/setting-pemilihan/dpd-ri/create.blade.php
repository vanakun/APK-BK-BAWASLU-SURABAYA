@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('calon_dpd_ri.index') }}"> Back</a>
                </div>
                <br><br>
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
                <form action="{{ route('calon_dpd_ri.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama Calon DPD:</strong>
                                <input type="text" name="nama_calon_dpd" class="form-control" placeholder="Nama Calon DPD">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Tahun Pemilihan:</strong>
                                <select name="tahun_pemilihan_id" class="form-control">
                                    @foreach($tahunPemilihans as $tahunPemilihan)
                                        <option value="{{ $tahunPemilihan->id }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

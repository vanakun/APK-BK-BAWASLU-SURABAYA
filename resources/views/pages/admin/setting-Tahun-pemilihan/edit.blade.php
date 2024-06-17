@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('SettingTahunPemilihan') }}">Back</a>
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

    <form action="{{ route('updateTahunPemilihan', $tahunPemilihan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tahun Pemilihan:</strong>
                    <input type="text" name="tahun_pemilihan" value="{{ $tahunPemilihan->tahun_pemilihan }}" class="form-control" placeholder="Enter Tahun Pemilihan">
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
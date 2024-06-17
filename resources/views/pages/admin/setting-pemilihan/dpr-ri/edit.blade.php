@extends('../layout/' . $layout)

@section('subhead')
    <title>Edit Calon DPR RI - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               <br>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('indexDprRi') }}"> Back</a>
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

    <form action="{{ route('updateDprRi', $calonDprRi->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama:</strong>
                    <input type="text" name="nama" value="{{ $calonDprRi->nama }}" class="form-control" placeholder="Nama">
                </div>
            </div>
            <div class="mb-4">
                <label for="partai_id" class="block text-sm font-medium text-gray-700">Partai:</label>
                <select id="partai_id" name="partai_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach($partais as $partai)
                        <option value="{{ $partai->id }}" {{ $calonDprRi->partai_id == $partai->id ? 'selected' : '' }}>{{ $partai->nama_partai }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tahun Pemilihan:</strong>
                    <select name="tahun_pemilihan_id" id="tahun_pemilihan_id" class="form-control" required>
                        @foreach($tahunPemilihans as $tahunPemilihan)
                            <option value="{{ $tahunPemilihan->id }}" {{ $calonDprRi->tahun_pemilihan_id == $tahunPemilihan->id ? 'selected' : '' }}>{{ $tahunPemilihan->tahun_pemilihan }}</option>
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

@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <br>
            <a class="btn btn-primary" href="{{ route('indexPresiden') }}">Back</a>
            
                <div class="card-body">
                <br>
                    <form method="POST" action="{{ route('presiden-wakil-presiden.update', $presidenWakilPresiden->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="nama_presiden" class="col-md-4 col-form-label text-md-right">Nama Presiden</label>

                            <div class="col-md-6">
                                <input id="nama_presiden" type="text" class="form-control @error('nama_presiden') is-invalid @enderror" name="nama_presiden" value="{{ $presidenWakilPresiden->nama_presiden }}" required autocomplete="nama_presiden" autofocus>

                                @error('nama_presiden')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="nama_wakil" class="col-md-4 col-form-label text-md-right">Nama Wakil Presiden</label>

                            <div class="col-md-6">
                                <input id="nama_wakil" type="text" class="form-control @error('nama_wakil') is-invalid @enderror" name="nama_wakil" value="{{ $presidenWakilPresiden->nama_wakil }}" required autocomplete="nama_wakil">

                                @error('nama_wakil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
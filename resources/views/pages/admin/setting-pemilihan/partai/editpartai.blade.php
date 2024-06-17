@extends('../layout/' . $layout)

@section('subhead')
    <title>Edit Partai - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a class="btn btn-primary" href="{{ route('indexpartai') }}">Back</a>
            </div>
        </div>
        <br>

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

        <form action="{{ route('partai.update', $partai->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nama Partai:</strong>
                            <input type="text" name="nama_partai" value="{{ $partai->nama_partai }}" class="form-control" placeholder="Nama Partai">
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

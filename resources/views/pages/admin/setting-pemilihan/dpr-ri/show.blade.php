@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a href="{{ route('createDprRi') }}" class="btn btn-primary">Create Calon DPR - RI</a>
            </div>
            <br>
        </div>
        
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                <p>{{ $message }}</p>
            </div>
        @endif

        <form action="{{ route('indexDprRi') }}" method="GET">
            <div class="form-group">
                <label for="tahun">Tahun:</label>
                <select name="tahun" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($tahunPemilihans as $tahunPemilihan)
                        <option value="{{ $tahunPemilihan->id }}" {{ $tahunPemilihan->id == $tahunSelected ? 'selected' : '' }}>
                            {{ $tahunPemilihan->tahun_pemilihan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        
        <div class="overflow-x-auto">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Partai</th>
                        <th class="px-4 py-2">Tahun Pemilihan</th>
                        <th class="px-4 py-2" width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calons as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>
                                @foreach($partais as $calon)
                                    @if($p->partai_id == $calon->id)
                                        {{ $calon->nama_partai }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($tahunPemilihans as $tahun)
                                    @if($p->tahun_pemilihan_id == $tahun->id)
                                        {{ $tahun->tahun_pemilihan }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('calon_dpr_ri.destroy', $p->id) }}" method="POST">
                                    <a href="{{ route('editDprRI', ['id' => $p->id]) }}" class="btn btn-primary">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('custom_pagination', ['paginator' => $calons])
    </div>
@endsection

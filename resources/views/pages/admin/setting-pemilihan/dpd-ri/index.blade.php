@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a href="{{ route('calon_dpd_ri.create') }}" class="btn btn-primary">Create New Calon DPD RI</a>
                <br>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <br>
                <form action="{{ route('calon_dpd_ri.index') }}" method="GET">
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
                <br>
                <div class="overflow-x-auto">
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Calon DPD</th>
                                <th>Tahun Pemilihan</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calonDpdRis as $calonDpdRi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $calonDpdRi->nama_calon_dpd }}</td>
                                    <td>
                                        @foreach($tahunPemilihans as $tahun)
                                            @if($calonDpdRi->tahun_pemilihan_id == $tahun->id)
                                                {{ $tahun->tahun_pemilihan }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('calon_dpd_ri.destroy', $calonDpdRi->id) }}" method="POST">
                                            <a href="{{ route('calon_dpd_ri.edit', $calonDpdRi->id) }}" class="btn btn-primary">Edit</a>
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
                <br>
                @include('custom_pagination', ['paginator' => $calonDpdRis])
                <br>
            </div>
        </div>
    </div>
@endsection

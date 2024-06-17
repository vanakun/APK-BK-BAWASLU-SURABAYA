@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a href="{{ route('calon_dprd_provinsi.create') }}" class="btn btn-primary">Tambah Calon</a>
                <br>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <br>
                <form action="{{ route('calon-dprd-kota.index') }}" method="GET">
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
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Calon</th>
                                <th class="px-4 py-2">Partai</th>
                                <th class="px-4 py-2">Tahun Pemilihan</th>
                                <th class="px-4 py-2">Dapil</th>
                                <th class="px-4 py-2" width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calonDprdKotas as $key => $calon)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $calon->nama_calon_dprd_kota }}</td>
                                    <td>{{ $calon->partai->nama_partai }}</td>
                                    <td>
                                        @foreach($tahunPemilihans as $tahun)
                                            @if($calon->tahun_pemilihan_id == $tahun->id)
                                                {{ $tahun->tahun_pemilihan }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $calon->dapil }}</td>
                                    <td>
                                        <form action="{{ route('calon-dprd-kota.destroy', $calon->id) }}" method="POST">
                                            <a href="{{ route('calon-dprd-kota.edit', $calon->id) }}" class="btn btn-primary">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus calon ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                {{ $calonDprdKotas->links() }}
                <br>
            </div>
        </div>
    </div>
@endsection

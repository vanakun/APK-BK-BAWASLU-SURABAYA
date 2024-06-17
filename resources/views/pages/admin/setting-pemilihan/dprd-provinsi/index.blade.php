@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a href="{{ route('calon_dprd_provinsi.create') }}" class="btn btn-primary">Create New Calon DPRD Provinsi</a>
                <br>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <br>
                <form action="{{ route('calon_dprd_provinsi.index') }}" method="GET">
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
                                <th class="px-4 py-2">Nama Calon DPRD</th>
                                <th class="px-4 py-2">Partai</th>
                                <th class="px-4 py-2">Tahun Pemilihan</th>
                                <th class="px-4 py-2" width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calonDprdProvinsis as $key => $calonDprdProvinsi)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $calonDprdProvinsi->nama_calon_dprd }}</td>
                                    <td>
                                        @foreach($partais as $partai)
                                            @if($calonDprdProvinsi->partai_id == $partai->id)
                                                {{ $partai->nama_partai }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($tahunPemilihans as $tahunPemilihan)
                                            @if($calonDprdProvinsi->tahun_pemilihan_id == $tahunPemilihan->id)
                                                {{ $tahunPemilihan->tahun_pemilihan }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('calon_dprd_provinsi.destroy', $calonDprdProvinsi->id) }}" method="POST">
                                            <a href="{{ route('calon_dprd_provinsi.edit', $calonDprdProvinsi->id) }}" class="btn btn-primary">Edit</a>
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
                @include('custom_pagination', ['paginator' => $calonDprdProvinsis])
                <br>
            </div>
        </div>
    </div>
@endsection

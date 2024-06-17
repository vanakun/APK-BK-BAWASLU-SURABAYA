@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <a href="{{ route('createpresiden') }}" class="btn btn-primary mb-3">Tambah Calon Presiden dan Wakil Presiden</a>
                       
                        <form action="{{ route('indexPresiden') }}" method="GET">
                            <div class="form-group">
                            <br>
                      
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
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">ID</th>
                                        <th class="px-4 py-2">Nama Presiden</th>
                                        <th class="px-4 py-2">Nama Wakil Presiden</th>
                                        <th class="px-4 py-2">Tahun Pemilihan</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presidenWakilPresiden as $presiden)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="border px-4 py-2">{{ $presiden->nama_presiden }}</td>
                                            <td class="border px-4 py-2">{{ $presiden->nama_wakil }}</td>
                                            <td class="border px-4 py-2">
                                                @foreach($tahunPemilihans as $tahun)
                                                    @if($presiden->tahun_pemilihan_id == $tahun->id)
                                                        {{ $tahun->tahun_pemilihan }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('editPresiden', $presiden->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('presiden-wakil-presiden.destroy', $presiden->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        @include('custom_pagination', ['paginator' => $presidenWakilPresiden])
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

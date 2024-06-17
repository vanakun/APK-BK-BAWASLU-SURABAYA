@extends('../layout/' . $layout)

@section('subhead')
    <title>Upload Surat - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <a class="btn btn-primary" href="{{ route('createpartai') }}">Create New Partai</a>
                <br>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <br>
                <form action="{{ route('indexpartai') }}" method="GET">
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
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">NO</th>
                                <th class="px-4 py-2">Nama Partai</th>
                                <th class="px-4 py-2">Tahun Pemilihan</th>
                                <th class="px-4 py-2" width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partai as $p)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $p->nama_partai }}</td>
                                    <td class="border px-4 py-2">
                                        @foreach($tahunPemilihans as $tahun)
                                            @if($p->tahun_pemilihan_id == $tahun->id)
                                                {{ $tahun->tahun_pemilihan }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('partai.destroy', $p->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('editpartai', ['id' => $p->id]) }}">Edit</a>
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
                @include('custom_pagination', ['paginator' => $partai])
                <br>
            </div>
        </div>
    </div>
@endsection

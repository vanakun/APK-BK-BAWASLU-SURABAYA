@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Content -->
        <div class="content">
        <h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan DPRD - PROVINSI </h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <h2 class="intro-y text-lg font-medium mt-10">Antrian</h2>
                    <br>
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Status</th>
                                <th class="whitespace-nowrap">Jenis Atribut</th>
                                <th class="whitespace-nowrap">Nama Calon</th>
                                <th class="whitespace-nowrap">Nama Partai</th>
                                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                                <th class="whitespace-nowrap">Tanggal Laporan</th>
                                <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                                <th class="whitespace-nowrap">Jenis Penertiban</th>
                                <th class="whitespace-nowrap">Keterangan</th>
                                <th class="whitespace-nowrap">User</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($aduandprdprovinsiqueue as $aduan)
                <tr class="intro-x image-fit zoom-in">
                <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                        <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->status }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_atribut }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_partai }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_jalan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_laporan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_akhir_ditertibkan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_penertiban}}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->keterangan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('insertqueuedprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->user->name }}</div>
                        </a>
                    </td>
                </tr>
                @endforeach
                         
                        </tbody>
                    </table>
                    <div class="intro-y flex flex-col mt-4">
                        {!! $aduandprdprovinsiqueue->links('pagination') !!}
                    </div>
                </div>

                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <h2 class="intro-y text-lg font-medium mt-10">Proses Aduan</h2>
                    <br>
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Status</th>
                                <th class="whitespace-nowrap">Jenis Atribut</th>
                                <th class="whitespace-nowrap">Nama Calon</th>
                                <th class="whitespace-nowrap">Nama Partai</th>
                                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                                <th class="whitespace-nowrap">Tanggal Laporan</th>
                                <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                                <th class="whitespace-nowrap">Jenis Penertiban</th>
                                <th class="whitespace-nowrap">Keterangan</th>
                                <th class="whitespace-nowrap">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aduandprdprovinsiproces as $aduan)
                            <tr class="intro-x image-fit zoom-in">
                            <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                        <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->status }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_atribut }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_partai }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_jalan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_laporan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_akhir_ditertibkan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_penertiban}}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->keterangan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->user->name }}</div>
                        </a>
                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="intro-y flex flex-col mt-4">
                        {!! $aduandprdprovinsiproces->links('pagination') !!}
                    </div>
                </div>
                <!-- END: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <h2 class="intro-y text-lg font-medium mt-10">Done</h2>
                    <br>
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                 <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Status</th>
                                <th class="whitespace-nowrap">Jenis Atribut</th>
                                <th class="whitespace-nowrap">Nama Calon</th>
                                <th class="whitespace-nowrap">Nama Partai</th>
                                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                                <th class="whitespace-nowrap">Tanggal Laporan</th>
                                <th class="whitespace-nowrap">Batas Tanggal Ditertibkan</th>
                                <th class="whitespace-nowrap">Tanggal Ditertibkan</th>
                                <th class="whitespace-nowrap">Jenis Penertiban</th>
                                <th class="whitespace-nowrap">Keterangan</th>
                                <th class="whitespace-nowrap">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aduandprdprovinsidone as $aduan)
                            <tr class="intro-x image-fit zoom-in">
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                        <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->status }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_atribut }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_partai }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_jalan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_laporan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_akhir_ditertibkan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_penertiban }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_penertiban}}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->keterangan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('editaduandprdprovinsi', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->user->name }}</div>
                        </a>
                    </td>
                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="intro-y flex flex-col mt-4">
                        {!! $aduandprdprovinsidone->links('pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Any additional scripts -->
@endsection

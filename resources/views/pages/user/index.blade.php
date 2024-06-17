@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Content -->
        <div class="content">
        @include('../layout/components/top-bar-tenagaahli')
        
        <h2 class="intro-y text-lg font-medium mt-10">Permohonan Pengajuan Aduan</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        {{-- Tampilkan tombol "Tambah Pengajuan Surat" hanya jika pengguna memiliki peran "User" --}}
        @php
            $allowedRoles = ['User'];
            $userRole = auth()->user()->role;
        @endphp

        @if(in_array($userRole, $allowedRoles))
            <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('createaduan') }}">Tambah Pengajuan Aduan</a></button>
        @endif
        <!-- <div id="real-time-clock" class="intro-y hidden md:block mx-auto text-slate-500"></div> -->
        <div class="intro-y mx-auto md:block mt-4">
           
        </div>
        
    </div>
    <!-- BEGIN: Data List -->
   
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan Presiden Dan Wakil Presiden</h2>
    <br>
    
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Jenis Atribut</th>
                    <th class="whitespace-nowrap">Nama Calon Presiden Dan Wakil</th>
                    <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                    <th class="whitespace-nowrap">Tanggal Laporan</th>
                    <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                    <th class="whitespace-nowrap">Tanggal Penertiban</th>
                    <th class="whitespace-nowrap">Jenis Penertiban</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aduanPresidenWakil as $aduan)
                <tr class="intro-x image-fit zoom-in">
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->status }}</div>
                        </a>
                    </td>
                    
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_atribut }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_calon }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->nama_jalan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_laporan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_akhir_ditertibkan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanDprdKabupaten', ['id' => $aduan->id]) }}"> 
                            <div class="font-medium whitespace-nowrap">{{ $aduan->tanggal_penertiban}}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->jenis_penertiban}}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->keterangan }}</div>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('showaduanPresidenWakil', ['id' => $aduan->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $aduan->user->name }}</div>
                        </a>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
        <div class="intro-y flex flex-col mt-4">
            {!! $aduanPresidenWakil->links('pagination') !!}
        </div>
    </div>
    <!-- END: Data List -->
</div>

<!-- Include Axios for making HTTP requests -->




<!-- Tabel kedua -->
<h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan DPD - RI </h2>
    <br>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Jenis Atribut</th>
                    <th class="whitespace-nowrap">Nama Calon DPD - RI</th>
                    <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                    <th class="whitespace-nowrap">Tanggal Laporan</th>
                    <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                    <th class="whitespace-nowrap">Tanggal Penertiban</th>
                    <th class="whitespace-nowrap">Jenis Penertiban</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">User</th>
                </tr>
        </thead>
        <tbody>
            @foreach($aduanDpdRi as $surat)
                <tr class="intro-x image-fit zoom-in">
                    <td>
                        <a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->status }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_atribut }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_calon_dpd }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_jalan }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_laporan }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_akhir_ditertibkan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_penertiban}}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_penertiban }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->keterangan }}</div></a></td>
                <td><a href="{{ route('showaduanDpd', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->user->name }}</div></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="intro-y flex flex-col mt-4">
        {!! $aduanDpdRi->links('pagination') !!}
    </div>
</div>
<h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan DPR - RI</h2>
    <br>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap">Tanggal</th>
                <th class="whitespace-nowrap">Nama Calon DPR - RI</th>
                <th class="whitespace-nowrap">Nama Partai</th>
                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                <th class="whitespace-nowrap">Tanggal Laporan</th>
                <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                <th class="whitespace-nowrap">Tanggal Penertiban</th>
                <th class="whitespace-nowrap">Jenis Penertiban</th>
                <th class="whitespace-nowrap">Keterangan</th>
                <th class="whitespace-nowrap">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aduanDprRi as $surat)
            <tr class="intro-x image-fit zoom-in">
               
                    <td>
                        <a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}">
                            <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                        </a>
                    </td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->status }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_atribut }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_partai }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_jalan }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_laporan }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_akhir_ditertibkan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_penertiban}}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_penertiban }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->keterangan }}</div></a></td>
                <td><a href="{{ route('showaduanDpr', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->user->name }}</div></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="intro-y flex flex-col mt-4">
        {!! $aduanDprRi->links('pagination') !!}
    </div>
</div>
<h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan DPRD - PROVINSI</h2>
    <br>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap">Tanggal</th>
                <th class="whitespace-nowrap">Nama Calon DPRD - PROVINSI</th>
                <th class="whitespace-nowrap">Nama Partai</th>
                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                <th class="whitespace-nowrap">Tanggal Laporan</th>
                <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                <th class="whitespace-nowrap">Tanggal Penertiban</th>
                <th class="whitespace-nowrap">Jenis Penertiban</th>
                <th class="whitespace-nowrap">Keterangan</th>
                <th class="whitespace-nowrap">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aduanDprdProvinsi as $surat)
            <tr class="intro-x image-fit zoom-in">
               
                <td>
                    <a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}">
                        <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                    </a>
                </td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->status }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_atribut }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_partai }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_jalan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_laporan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_akhir_ditertibkan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_penertiban}}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_penertiban }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->keterangan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdProvinsi', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->user->name }}</div></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="intro-y flex flex-col mt-4">
        {!! $aduanDprdProvinsi->links('pagination') !!}
    </div>
</div>
<h2 class="intro-y text-lg font-medium mt-10">Pengajuan Aduan DPRD - KABUPATEN/PROVINSI</h2>
    <br>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap">Tanggal</th>
                <th class="whitespace-nowrap">Nama Calon DPRD - PROVINSI</th>
                <th class="whitespace-nowrap">Nama Partai</th>
                <th class="whitespace-nowrap">Lokasi Pemasangan</th>
                <th class="whitespace-nowrap">Tanggal Laporan</th>
                <th class="whitespace-nowrap">Tanggal Akhir Ditertibkan</th>
                <th class="whitespace-nowrap">Tanggal Penertiban</th>
                <th class="whitespace-nowrap">Jenis Penertiban</th>
                <th class="whitespace-nowrap">Keterangan</th>
                <th class="whitespace-nowrap">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aduanDprdKabupaten as $surat)
            <tr class="intro-x image-fit zoom-in">
            <td>
                    <a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}">
                        <div class="font-medium whitespace-nowrap">{{ $loop->iteration }}</div>
                    </a>
                </td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->status }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_atribut }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_partai }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->nama_jalan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_laporan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_akhir_ditertibkan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->tanggal_penertiban}}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->jenis_penertiban }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->keterangan }}</div></a></td>
                <td><a href="{{ route('showaduanDprdKabupaten', ['id' => $surat->id]) }}"> <div class="font-medium whitespace-nowrap">{{ $surat->user->name }}</div></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="intro-y flex flex-col mt-4">
        {!! $aduanDprdKabupaten->links('pagination') !!}
    </div>
</div>


</div>
<div class="pubble-app" data-app-id="126364" data-app-identifier="126364" ></div>
<script type="text/javascript" src="https://cdn.chatify.com/javascript/loader.js" defer></script>

@endsection

@section('script')


@endsection

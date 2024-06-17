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
           
            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">Permohonan Pengajuan Aduan</h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('aduan_presiden_wakil_presiden.create') }}">Tambah Pengajuan Aduan Presiden Dan Wakil Presiden</a></button>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('aduan_dpd_ri.create') }}">Tambah Pengajuan Aduan Dpd Ri </a></button>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('aduan_dpr_ri.create') }}">Tambah Pengajuan Aduan Dpr Ri </a></button>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('aduan_dprd_provinsi.create') }}">Tambah Pengajuan Aduan Dprd Provinsi </a></button>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2"><a href="{{ route('aduan_dprd_kabupaten.create') }}">Tambah Pengajuan Aduan Dprd Kota/Kab </a></button>
                </div>
                <!-- END: Blog Layout -->
            </div>
            
        </div>
        <!-- END: Content -->
    </div>
@endsection

@section('script')


@endsection
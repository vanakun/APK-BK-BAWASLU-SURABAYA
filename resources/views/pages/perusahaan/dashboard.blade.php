@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="relative">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-9 2xl:col-span-9 z-10">
                <div class="mt-6 -mb-6 intro-y">
                    <div class="alert alert-dismissible show box bg-primary text-white flex items-center mb-6" role="alert">
                        <span>
                            APK BK Bawaslu Surabaya
                        </span>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close">
                            <i data-feather="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <style>
        .chart-container {
           
            height: 200px; /* Atur tinggi canvas sesuai kebutuhan */
            width: 200px; /* Atur lebar canvas sesuai kebutuhan */
        }
    </style>
       
   
               
   
<div class="mt-14 mb-3 grid grid-cols-12 sm:gap-10 intro-y">

    <div class="col-span-12 md:col-span-8 md:col-span-4 py-6 sm:pl-5 md:pl-1 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
      
            <br>
            <div class="text-slate-500"></div>
            <br>
            <br>
            <div class="flex items-center">
                <div class="container">
               
           
                <canvas id="doughnutChart"></canvas>
                </div>
            </div>
            <br>
            <br>
            
            <br>
          
           
           
        </div>
    </div>
                <!-- END: Official Store -->
    <div class="col-span-12 md:col-span-8 md:col-span-4 py-6 sm:pl-5 md:pl-1 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
        <div class="text-slate-500">Total Aduan Presiden dan Wakil  </div> <br>
            <br>
            <div class="text-slate-500"></div>
            <br>
            <br>
            <div class="flex items-center">
                <div class="container">
               
           
            <canvas id="chart-aduan-presiden-status"></canvas>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
           
           
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 md:col-span-4 py-6 sm:pl-5 md:pl-0 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
        <div class="text-slate-500">Total Aduan DPD RI </div>  
        <br>
        <br>
        <br>
            <div class="flex items-center">
           
                <div class="container">
                    <canvas id="chart-dpd"></canvas>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
           
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 md:col-span-4 py-6 sm:pl-5 md:pl-0 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
            <div class="text-slate-500">Total Aduan DPR RI  </div>
            <br>
            <div class="flex items-center">
                <div class="container">
                    <canvas id="chart-dpr"></canvas>
                </div>
            </div>
            <br>
          
            <br>
            <div class="text-slate-500"></div>
        </div>
    </div>

    <!-- Row 2 -->
    <div class="col-span-12 sm:col-span-6 md:col-span-4 py-6 sm:pl-5 md:pl-0 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
            <div class="text-slate-500">Total Aduan DPRD PROVINSI  </div>
            <br>
            <div class="flex items-center">
                <div class="container">
                    <canvas id="chart-dprd-provinsi"></canvas>
                </div>
            </div>
            <br>
            <br>
            <div class="text-slate-500"></div>
        </div>
    </div>

    <div class="col-span-12 sm:col-span-6 md:col-span-4 py-6 sm:pl-5 md:pl-0 lg:pl-5 relative text-center sm:text-left">
        <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
            <div class="text-slate-500">Total Aduan DPRD KABUPATEN  </div>
            <br>
            <div class="flex items-center">
                <div class="container">
                    <canvas id="chart-dprd-kabupaten"></canvas>
                </div>
            </div>
            <br>
            <br>
            <div class="text-slate-500"></div>
        </div>
    </div>

                <!-- END: Official Store -->
    
   
   
    

        </div>
        <div class="report-box-4 w-full h-full grid grid-cols-12 gap-6 xl:absolute -mt-8 xl:mt-0 pb-6 xl:pb-0 top-0 right-0 z-30 xl:z-auto">
            <div class="col-span-12 xl:col-span-3 xl:col-start-10 xl:pb-16 z-30">
                <div class="h-full flex flex-col">
                    

                   
                    <div class="box p-5 mt-6 bg-primary intro-x">
                        <div class="flex flex-wrap gap-3">
                        <div class="mr-auto">
                            <div class="block text-white leading-3">
                                Pilih Tahun Aduan Aktif 
                            </div>
                            <div class="text-white relative text-2xl font-medium leading-5 pl-4 mt-3.5">
                                {{ $tahunPemilihanAktif }}
                            </div>
                            <br>
                            <form action="{{ route('updatetahunpemilianaktif') }} " method="POST" id="tahun_form" class="flex flex-col space-y-4">
                                @csrf
                                <div>
                        <label for="tahun_pemilihan_aktif" class="block text-white">Tahun Aduan:</label>
                        <select name="tahun_pemilihan_aktif" id="tahun_pemilihan_aktif" onchange="submitForm()" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <option value="">Pilih Tahun</option>
                            @foreach($tahunPemilihans as $tahunPemilihan)
                                <option value="{{ $tahunPemilihan->tahun_pemilihan }}">{{ $tahunPemilihan->tahun_pemilihan }}</option>
                            @endforeach
                        </select>
                    </div>

            
        </form>
    </div>
    </div>
</div>

<script>
    function submitForm() {
        // Mendapatkan nilai tahun yang dipilih
        var selectedYear = document.getElementById("tahun_pemilihan_aktif").value;

        // Meminta pengguna untuk memasukkan kode akses
        var accessCode = prompt("Masukkan kode akses untuk melanjutkan:");

        // Jika pengguna membatalkan, tidak lakukan apa-apa
        if (accessCode === null) {
            return;
        }

        // Jika kode akses sesuai, submit form
        if (accessCode === "bawaslu123") {
            document.getElementById("tahun_form").submit();
        } else {
            // Jika kode akses tidak sesuai, tampilkan pesan kesalahan
            alert("Kode akses tidak valid. Silakan coba lagi.");
        }
    }
</script>

                    <div class="report-box-4__content xl:min-h-0 intro-x">
                    <div class="max-h-full xl:overflow-y-auto box mt-5">
    <div class="xl:sticky top-0 px-5 pt-5 pb-6">
        <div class="flex items-center justify-between">
            <div class="text-lg font-medium truncate mr-5">Log Pengajuan Aduan</div>
            <a href="" class="ml-auto flex items-center text-primary">
                <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Refresh
            </a>
        </div>
        <br>
        <div class="flex items-center">
            <div class="bg-white w-full rounded shadow-md p-4 pl-5"> <!-- Added pl-5 here -->
                @foreach($aduanLogs as $aduanLog)
                <br>
                    <div class="mb-4 pl-5"> <!-- Added pl-5 here -->
                        <div class="text-gray-800">{{ $aduanLog->user->name }}</div>
                        <div class="text-sm text-gray-600">
                            Mengajukan Aduan {{ $aduanLog->aduan->jenis_pemilihan ?? 'not found' }}
                        </div>
                        <div class="text-xs text-gray-400">{{ $aduanLog->created_at }}</div>
                    </div>
                    <hr class="my-2"> <!-- Pemisah visual (garis horizontal) -->
                    <br>
                @endforeach
                {!! $aduanLogs->links('pagination') !!}
                <br>
            </div>
        </div>
    </div>
</div>


                       
                    
            </div>
        </div>
    </div>
    
                
                    
       
                    
                </div>
            </div>
        </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var ctx = document.getElementById('chart-aduan-presiden-status').getContext('2d');
        var suratChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($aduanPresidenCounts->pluck('status')), // Use status as labels
                datasets: [{
                    label: 'Total Aduan Presiden Dan Wakil',
                    data: @json($aduanPresidenCounts->pluck('total')), // Use total counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Green background
                    borderColor: 'rgba(91, 173, 128, 1)', 
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('chart-dpd').getContext('2d');
        var suratChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($aduanDPDCounts->pluck('status')), // Use status as labels
                datasets: [{
                    label: 'Total DPD - RI',
                    data: @json($aduanDPDCounts->pluck('total')), // Use total counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Green background
                    borderColor: 'rgba(91, 173, 128, 1)', 
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('chart-dpr').getContext('2d');
        var suratChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($aduanDPRCounts->pluck('status')), // Use status as labels
                datasets: [{
                    label: 'Total DPR - RI',
                    data: @json($aduanDPRCounts->pluck('total')), // Use total counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Green background
                    borderColor: 'rgba(91, 173, 128, 1)', 
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('chart-dprd-provinsi').getContext('2d');
        var suratChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($aduanDPRDprovinsiCounts->pluck('status')), // Use status as labels
                datasets: [{
                    label: 'Total DPRD - PROVINSI',
                    data: @json($aduanDPRDprovinsiCounts->pluck('total')), // Use total counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Green background
                    borderColor: 'rgba(91, 173, 128, 1)', 
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('chart-dprd-kabupaten').getContext('2d');
        var suratChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($aduanDPRDkabupatenCounts->pluck('status')), // Use status as labels
                datasets: [{
                    label: 'Total DPRD - KABUPATEN',
                    data: @json($aduanDPRDkabupatenCounts->pluck('total')), // Use total counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Green background
                    borderColor: 'rgba(91, 173, 128, 1)', 
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<script>
        var ctx = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Presiden', 'DPD', 'DPR', 'DPRD Provinsi', 'DPRD Kabupaten'],
                datasets: [{
                    data: [
                        {{ $totalAkhirpresiden }},
                        {{ $totalAkhirdpd }},
                        {{ $totalAkhirdpr }},
                        {{ $totalAkhirdprdprovinsi }},
                        {{ $totalAkhirdprdkabupaten }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Total Aduan per Kategori'
                    }
                }
            }
        });
    </script>

@endsection

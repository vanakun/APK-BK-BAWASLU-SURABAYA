@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    @include('../layout/components/mobile-menu')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Content -->
        <div class="content">
            @yield('subcontent')
            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">Setting Aduan</h2>
            </div>
            <div class="intro-y grid grid-cols-12 gap-6 mt-5">
                <!-- BEGIN: Blog Layout -->
                
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                <div class="ml-3 text-white mr-auto">
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">Partai</span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('indexpartai') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak Klasifikasi PM">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                
                                <div class="ml-3 text-white mr-auto">
                                </div>
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="bg-white/20 dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Post
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Post
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">  PRESIDEN DAN WAKIL PRESIDEN</span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('indexPresiden') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak PDF">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                
                                <div class="ml-3 text-white mr-auto">
                                </div>
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="bg-white/20 dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Post
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Post
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">  DPD RI (DPD)</span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('calon_dpd_ri.index') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak PDF">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                
                                <div class="ml-3 text-white mr-auto">
                                </div>
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="bg-white/20 dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Post
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Post
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">  DPR RI (DPR)</span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('indexDprRi') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak PDF">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                
                                <div class="ml-3 text-white mr-auto">
                                </div>
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="bg-white/20 dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Post
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Post
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">  DPRD PROVINSI</span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('calon_dprd_provinsi.index') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak PDF">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-6 box zoom-in">
                        <div class="h-[320px] before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black/90 before:to-black/10 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-t-md" src="{{ asset('dist/images/bg_surat/download.jpg') }}">
                            <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                                
                                <div class="ml-3 text-white mr-auto">
                                </div>
                                <div class="dropdown ml-3">
                                    <a href="javascript:;" class="bg-white/20 dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Post
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Post
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <span class="bg-white/20 px-2 py-1 rounded">  DPRD KAB/Kota </span>
                                <a href="" class="block font-medium text-xl mt-3"> </a>
                            </div>
                        </div>
                        <div class="p-5 text-slate-600 dark:text-slate-500"></div>
                        <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="mr-auto flex items-center text-primary" href="{{ route('calon-dprd-kota.index') }}">
                                <div><i data-feather="eye" class="w-4 h-4"></i></div>
                                <div class="ml-1">View Details</div>
                            </a>
                            
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Cetak PDF">
                                <i data-feather="share" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                         
                <!-- END: Blog Layout -->
            </div>
            <div class="mt-6 text-center">
                
            </div>
        </div>
        <!-- END: Content -->
    </div>
@endsection

@section('script')
<script>
    function openSharePopup(projectId) {
        // Kirim permintaan AJAX ke backend untuk mendapatkan tautan proyek
        axios.get('/projects/' + projectId + '/share-link')
            .then(function (response) {
                // Tampilkan pop-up berisi tautan proyek dan tombol berbagi
                let shareLink = response.data.shareLink;
                let sharePopup = `
                    <div class="share-popup">
                        <a href="whatsapp://send?text=${shareLink}" target="_blank">
                            <i class="fab fa-whatsapp"></i> Share via WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=${shareLink}" target="_blank">
                            <i class="fab fa-facebook"></i> Share via Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=${shareLink}" target="_blank">
                            <i class="fab fa-twitter"></i> Share via Twitter
                        </a>
                        <button onclick="copyShareLink('${shareLink}')">
                            <i class="fas fa-copy"></i> Copy Link
                        </button>
                    </div>
                `;
                // Tampilkan pop-up
                // Misalnya, menggunakan library SweetAlert atau Bootstrap modal
                swal({
                    content: sharePopup,
                    button: false
                });
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function copyShareLink(shareLink) {
        // Salin tautan ke clipboard
        navigator.clipboard.writeText(shareLink)
            .then(function () {
                // Tampilkan pesan sukses
                swal("Link copied to clipboard!", "", "success");
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>


@endsection

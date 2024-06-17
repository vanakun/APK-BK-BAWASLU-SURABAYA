<?php

namespace App\Http\Controllers\Tenagaahli;

use App\Http\Controllers\Controller;
use App\Models\AduanDpdRi;
use App\Models\AduanDprdKabupaten;
use App\Models\AduanDprdProvinsi;
use App\Models\AduanDprRi;
use App\Models\AduanPresidenWakilPresiden;
use App\Models\Partai;
use App\Models\PresidenWakilPresiden;
use App\Models\SuratHubunganMasyarakat;
use App\Models\SuratHukum;
use App\Models\SuratKepegawaian;
use App\Models\SuratKetatausahaanDanKerumahtangaan;
use App\Models\SuratKeuangan;
use App\Models\SuratLog;
use App\Models\SuratOrganisasiDanTataLaksana;
use App\Models\SuratPenangananPelanggaranSengketaPemilu;
use App\Models\SuratPengawasan;
use App\Models\SuratPengawasanPemilu;
use App\Models\SuratPenyelesaianSengketa;
use App\Models\SuratPerencanaan;
use App\Models\SuratPerlengkapan;
use App\Models\SuratPersuratanDanKearsipan;
use App\Models\SuratTeknologiInformasi;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TenagaahliController extends Controller
{
   

public function index(Request $request)
{
    // Ambil ID pengguna yang saat ini masuk
    $userId = Auth::id();

    $aduanPresidenWakil = AduanPresidenWakilPresiden::where('user_id', $userId)->paginate(5);

    $aduanDpdRi = AduanDpdRi::where('user_id', $userId)->paginate(5);

    $aduanDprRi = AduanDprRi::where('user_id', $userId)->paginate(5);

    $aduanDprdProvinsi = AduanDprdProvinsi::where('user_id', $userId)->paginate(5);

    $aduanDprdKabupaten = AduanDprdKabupaten::where('user_id', $userId)->paginate(5);
    
    
    


   
    
    return view('pages.user.index', compact('aduanDprdKabupaten','aduanDprdProvinsi','aduanDprRi','aduanDpdRi','aduanPresidenWakil'));
}


    public function createaduan()
    {
        return view ('pages/user/listaduan');
    }

    public function showaduanPresidenWakil($id)
    {
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
        return view('pages.user.aduan.presiden-wakil.show', compact('aduan'));
    }

    public function showaduanDpd($id)
    {
        $aduan = AduanDpdRi::findOrFail($id);
        return view('pages.user.aduan.dpd-ri.show', compact('aduan'));
    }

    public function showaduanDpr($id)
    {
        $aduan = AduanDprRi::findOrFail($id);
        return view('pages.user.aduan.dpr-ri.show', compact('aduan'));
    }

    public function showaduanDprdProvinsi($id)
    {
        $aduan = AduanDprdProvinsi::findOrFail($id);
        return view('pages.user.aduan.dpr-ri.show', compact('aduan'));
    }

    public function showaduanDprdKabupaten($id)
    {
        $aduan = AduanDprdKabupaten::findOrFail($id);
        return view('pages.user.aduan.dprd-kabupaten.show', compact('aduan'));
    }


    public function createsuratpm()
    {

        $activeYear = TahunPemilihanAktif::first();

        if ($activeYear) {
            $partais = Partai::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $partais = collect();
        }

       // dd($partais, $activeYear);
        return view ('pages/user/surat/createpm', compact('partais', 'activeYear'));
    }

    public function createsuratpp()
    {
        return view ('pages/user/surat/createpp');
    }
    public function createsuratps()
    {
        return view ('pages/user/surat/createps');
    }
    public function createsuratpr()
    {
        return view ('pages/user/surat/createpr');
    }

    public function createsuratot()
    {
        return view ('pages/user/surat/createot');
    }

    public function createsuratka()
    {
        return view ('pages/user/surat/createka');
    }

    public function createsuratku()
    {
        return view ('pages/user/surat/createku');
    }

    public function createsuratpl()
    {
        return view ('pages/user/surat/createpl');
    }

    public function createsurathm()
    {
        return view ('pages/user/surat/createhm');
    }

    public function createsuratkp()
    {
        return view ('pages/user/surat/createkp');
    }
    public function createsurathk()
    {
        return view ('pages/user/surat/createhk');
    }

    public function createsuratrt()
    {
        return view ('pages/user/surat/creatert');
    }

    public function createsuratpw()
    {
        return view ('pages/user/surat/createpw');
    }

    public function createsuratti()
    {
        return view ('pages/user/surat/createti');
    }

    public function tolakSurat(Request $request, $id)
    {
        // Ambil data surat berdasarkan ID
        $surat = SuratPengawasanPemilu::findOrFail($id);
    
        // Ubah status surat menjadi "reject"
        $surat->status = 'reject';
        $surat->save();
    
        // Redirect atau berikan respon yang sesuai
        return response()->json(['message' => 'Status surat berhasil diubah menjadi reject']);
    }
    
    public function storesuratpm(Request $request)
{
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'substantif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'Pengawasan Pemilu (PM)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();
    $validatedData['user_id'] = $userId;

    // Create the record
    $surat = SuratPengawasanPemilu::create($validatedData);

    // Log the creation of the surat
    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPengawasanPemilu::class,
    ]);

    // Juga bisa log ke file
    \Log::info('Surat PM created', [
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPengawasanPemilu::class,
        'timestamp' => now(),
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

   

    public function storesuratpp(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'substantif' => 'required|string',
    ]);
    
    $userId = auth()->id();

   
    $validatedData['user_id'] = $userId;

    $validatedData['j_surat'] = 'Penanganan Pelangaran dan Sengketa Pemilu (PP)';

    // Create the record
    $surat = SuratPenangananPelanggaranSengketaPemilu::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPenangananPelanggaranSengketaPemilu::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function showsuratpmuser($id)
    {
        $suratPengawasanPemilus = SuratPengawasanPemilu::findOrFail($id);
        // Tampilkan halaman edit surat
        return view('pages/user/surat/show-surat/showpm', compact('suratPengawasanPemilus'));
    }

    public function storesuratps(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'substantif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'PENYELESAIAN SENGKETA (PS)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    $validatedData['user_id'] = $userId;

    // Create the record

    $surat = SuratPenyelesaianSengketa::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPenyelesaianSengketa::class,
    ]);
    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }    
    public function storesuratpr(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'PERENCANAAN (PR)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    
    $validatedData['user_id'] = $userId;

    // Create the record


    $surat = SuratPerencanaan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPerencanaan::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }    

    
    public function storesuratot(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'ORGANISASI DAN TATA LAKSANA (OT)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    $validatedData['user_id'] = $userId;

    // Create the record

    $surat = SuratOrganisasiDanTataLaksana::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratOrganisasiDanTataLaksana::class,
    ]);

    

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }
    public function storesuratka(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'PERSURATAN DAN KEARSIPAN (KA)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    // Ambil nomor surat terakhir dari database
   
    $validatedData['user_id'] = $userId;

    // Create the record

    $surat = SuratPersuratanDanKearsipan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPersuratanDanKearsipan::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }
    public function storesuratku(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'KEUANGAN (KU)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

   
    $validatedData['user_id'] = $userId;

    // Create the record
    

    $surat = SuratKeuangan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratKeuangan::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function storesuratpl(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'PERLENGKAPAN (PL)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    $validatedData['user_id'] = $userId;

    // Create the record
    

    $surat = SuratPerlengkapan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPerlengkapan::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function storesurathm(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'HUBUNGAN MASYARAKAT (HM)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    $validatedData['user_id'] = $userId;

    // Create the record

    $surat = SuratHubunganMasyarakat::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratHubunganMasyarakat::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }
    
    public function storesuratkp(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'KEPEGAWAIAN (KP)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    // Ambil nomor surat terakhir dari database
    
    $validatedData['user_id'] = $userId;

    // Create the record
   

    $surat = SuratKepegawaian::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratKepegawaian::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }
    
    public function storesuratrt(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'KETATAUSAHAAN DAN KERUMAHTANGGAAN (RT)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

   
    $validatedData['user_id'] = $userId;

    // Create the record
   

    $surat = SuratKetatausahaanDanKerumahtangaan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratKetatausahaanDanKerumahtangaan::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function storesurathk(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'HUKUM(HK)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    // Ambil nomor surat terakhir dari database
   
    $validatedData['user_id'] = $userId;

    // Create the record
   

    $surat = SuratHukum::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratHukum::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function storesuratpw(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'PENGAWASAN(PW)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    // Ambil nomor surat terakhir dari database
   
    $validatedData['user_id'] = $userId;

    // Create the record
    $surat = SuratPengawasan::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratPengawasan::class,
    ]);


    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }

    public function storesuratti(Request $request)
    {
    // Validasi data input
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'perihal' => 'required|string',
        'tujuan' => 'required|string',
        'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
        'keterangan' => 'required|string',
        'kota' => 'required|string',
        'fasilitatif' => 'required|string',
    ]);

    $validatedData['j_surat'] = 'TEKNOLOGI INFORMASI(TI)';

    // Ambil ID pengguna yang sedang masuk
    $userId = auth()->id();

    // Ambil nomor surat terakhir dari database
   
    $validatedData['user_id'] = $userId;

    // Create the record
   

    $surat = SuratTeknologiInformasi::create($validatedData);

    SuratLog::create([
        'user_id' => $userId,
        'surat_id' => $surat->id,
        'surat_type' => SuratTeknologiInformasi::class,
    ]);

    // Redirect to success page or do any other operation upon successful submission
    return redirect()->route('tenagaahliDashboard');
    }
}

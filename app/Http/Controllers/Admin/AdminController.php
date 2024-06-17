<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AduanDpdRi;
use App\Models\AduanDprdProvinsi;
use App\Models\AduanDprRi;
use App\Models\AduanLog;
use App\Models\AduanPresidenWakilPresiden;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Step;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function updatetahunpemilianaktif(Request $request)
    {
        $request->validate([
            'tahun_pemilihan_aktif' => 'required|integer|min:1900|max:' . date('Y')
        ]);

        // Assuming there is only one active election year at a time
        $tahunPemilihanAktif = TahunPemilihanAktif::first();
        if (!$tahunPemilihanAktif) {
            $tahunPemilihanAktif = new TahunPemilihanAktif();
        }
        
        $tahunPemilihanAktif->tahun_pemilihan_aktif = $request->input('tahun_pemilihan_aktif');
        $tahunPemilihanAktif->save();

        return view('pages/admin/setting-pemilihan/show');
    }
    public function SettingPemilihan(){
       
        return view('pages/admin/setting-pemilihan/show');
    }

    public function SettingTahunPemilihan(){
       
        $tahunPemilihan = TahunPemilihan::all();
        return view('pages/admin/setting-Tahun-pemilihan/show', compact('tahunPemilihan'));
    }

    public function createTahunPemilihan()
    {
        return view('pages/admin/setting-Tahun-pemilihan/create');
    }

    public function storeTahunPemilihan(Request $request)
    {
    $request->validate([
        'tahun_pemilihan' => 'required|date_format:Y',
    ]);

    $tahunPemilihan = new TahunPemilihan;
    $tahunPemilihan->tahun_pemilihan = $request->tahun_pemilihan;
    $tahunPemilihan->save();

    return redirect()->route('SettingTahunPemilihan')->with('success', 'Tahun Pemilihan berhasil ditambahkan.');
    }

    public function destroyTahunPemilihan($id)
{
    $tahunPemilihan = TahunPemilihan::findOrFail($id);
    $tahunPemilihan->delete();

    return redirect()->route('SettingTahunPemilihan')->with('success', 'Tahun Pemilihan berhasil dihapus.');
}

public function editTahunPemilihan($id)
{
    $tahunPemilihan = TahunPemilihan::findOrFail($id);

    return view('pages/admin/setting-Tahun-pemilihan/edit', compact('tahunPemilihan'));
}

public function updateTahunPemilihan(Request $request, $id)
{
    $request->validate([
        'tahun_pemilihan' => 'required|date_format:Y',
    ]);

    $tahunPemilihan = TahunPemilihan::findOrFail($id);
    $tahunPemilihan->tahun_pemilihan = $request->tahun_pemilihan;
    $tahunPemilihan->save();

    return redirect()->route('SettingTahunPemilihan')->with('success', 'Tahun Pemilihan berhasil diperbarui.');
}

public function index()
{
    // Dapatkan tahun pemilihan aktif
    $tahunPemilihanAktif = TahunPemilihanAktif::pluck('tahun_pemilihan_aktif')->first();
    $tahunPemilihans = TahunPemilihan::all();

    // Ambil total aduan berdasarkan status untuk tahun pemilihan aktif
    $aduanPresidenCounts = AduanPresidenWakilPresiden::select('status', \DB::raw('count(*) as total'))
        ->where('tahun_pemilihan_id', $tahunPemilihanAktif)
        ->groupBy('status')
        ->get();

    $aduanDPDCounts = AduanDpdRi::select('status', \DB::raw('count(*) as total'))
        ->where('tahun_pemilihan_id', $tahunPemilihanAktif)
        ->groupBy('status')
        ->get();

    $aduanDPRCounts = AduanDprRi::select('status', \DB::raw('count(*) as total'))
        ->where('tahun_pemilihan_id', $tahunPemilihanAktif)
        ->groupBy('status')
        ->get();
    
    $aduanDPRDprovinsiCounts = AduanDprdProvinsi::select('status', \DB::raw('count(*) as total'))
        ->where('tahun_pemilihan_id', $tahunPemilihanAktif)
        ->groupBy('status')
        ->get();

    $aduanDPRDkabupatenCounts = AduanDprdProvinsi::select('status', \DB::raw('count(*) as total'))
        ->where('tahun_pemilihan_id', $tahunPemilihanAktif)
        ->groupBy('status')
        ->get();

    $totalAkhirpresiden = $aduanPresidenCounts->sum('total');
    $totalAkhirdpd = $aduanDPDCounts->sum('total');
    $totalAkhirdpr = $aduanDPRCounts->sum('total');
    $totalAkhirdprdprovinsi = $aduanDPRDprovinsiCounts->sum('total');
    $totalAkhirdprdkabupaten = $aduanDPRDkabupatenCounts->sum('total');

    $aduanLogs = AduanLog::orderBy('created_at', 'desc')->paginate(5);

    //dd($totalAkhirpresiden);
    

    return view('pages.perusahaan.dashboard', [
        'tahunPemilihanAktif' => $tahunPemilihanAktif,
        'tahunPemilihans' => $tahunPemilihans,
        'aduanPresidenCounts' => $aduanPresidenCounts,
        'aduanDPDCounts' => $aduanDPDCounts,
        'aduanDPRCounts' => $aduanDPRCounts,
        'aduanDPRDprovinsiCounts' => $aduanDPRDprovinsiCounts,
        'aduanDPRDkabupatenCounts' => $aduanDPRDkabupatenCounts,
        'totalAkhirpresiden' => $totalAkhirpresiden,
        'totalAkhirdpd' => $totalAkhirdpd,
        'totalAkhirdpr' => $totalAkhirdpr,
        'totalAkhirdprdprovinsi' => $totalAkhirdprdprovinsi,
        'totalAkhirdprdkabupaten' => $totalAkhirdprdkabupaten,
        'aduanLogs' => $aduanLogs,
    ]);
}





    public function indexAntrian()
    {
        $userId = Auth::id();

        // Cari surat pengawasan pemilu yang terkait dengan pengguna yang saat ini masuk
        $suratPengawasanPemilus = SuratPengawasanPemilu::where('user_id', $userId)->get();
        $tahunPemilihans = TahunPemilihan::all();

        return view('pages/admin/index', compact('tahunPemilihans','suratPengawasanPemilus'));
    }

    //Surat PM
    public function indexAntrianpm()
    {
    $suratPengawasanPemilus = SuratPengawasanPemilu::where('status', 'waiting')
                                                    ->paginate(5);
    $suratPengawasanPemilusdone = SuratPengawasanPemilu::where('status', 'done')
                                                    ->paginate(5);
    $suratPengawasanPemilusqueue = SuratPengawasanPemilu::where('status', 'queue')
                                                    ->paginate(5);
    return view('pages/admin/pm/showpm', compact('suratPengawasanPemilus','suratPengawasanPemilusdone','suratPengawasanPemilusqueue'));
    }
    public function editsuratpm($id)
    {
    $suratPengawasanPemilus = SuratPengawasanPemilu::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pm/editpm', compact('suratPengawasanPemilus'));
    }
    public function updatepm(Request $request, $id)
{
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'substantif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
    ]);

    // Ambil nomor surat terakhir dari database
    $lastSuratNumber = SuratPengawasanPemilu::max('no_surat');

    // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
    if (!$lastSuratNumber) {
        $lastSuratNumber = '001';
    } else {
        // Ambil angka dari nomor surat terakhir dan tambahkan 1
        $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
        // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
        $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
    }

    // Generate nomor surat baru
    $no_surat = $lastSuratNumber . '/' . $validatedData['substantif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');

    // Cari surat pengawasan pemilu berdasarkan ID
    $suratPengawasanPemilus = SuratPengawasanPemilu::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratPengawasanPemilus->update([
        'status' => 'waiting', // Set the status to 'waiting' initially
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'no_surat' => $no_surat, // Gunakan nomor surat baru
    ]);
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratPengawasanPemilus->file_surat = $fileName;
        $suratPengawasanPemilus->status = 'done'; // Ubah status menjadi 'done'
        $suratPengawasanPemilus->save();
    }
   //dd($suratPengawasanPemilus);

    // Save the updated model
    $suratPengawasanPemilus->save();

    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianpm')->with('success', 'Surat berhasil diperbarui.');
}

    public function editsuratpmdone($id)
    {
    $suratPengawasanPemilus = SuratPengawasanPemilu::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pm/editpmdone', compact('suratPengawasanPemilus'));
    }
    public function updatepmdone(Request $request, $id)
{
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'substantif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
        'nomor_surat' => 'required',
    ]);


    // Cari surat pengawasan pemilu berdasarkan ID
    $suratPengawasanPemilus = SuratPengawasanPemilu::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratPengawasanPemilus->update([
        'status' => $request->status,
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
    ]);

    // Jika ada file surat yang diunggah, simpan file tersebut
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratPengawasanPemilus->file_surat = $fileName;
        $suratPengawasanPemilus->status = 'done'; // Ubah status menjadi 'done'
        $suratPengawasanPemilus->save();
    }
    $suratPengawasanPemilus->save();
    //dd($suratPengawasanPemilus);
    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianpm')->with('success', 'Surat berhasil diperbarui.');
    }


    public function indexAntrianpp()
    {
    $suratpp = SuratPenangananPelanggaranSengketaPemilu::where('status', 'waiting')
                                                    ->paginate(5);
    $suratppdone = SuratPenangananPelanggaranSengketaPemilu::where('status', 'done')
                                                    ->paginate(5);
    $suratppqueue = SuratPenangananPelanggaranSengketaPemilu::where('status', 'queue')
                                                    ->paginate(5);
    return view('pages/admin/pp/showpp', compact('suratpp','suratppdone','suratppqueue'));
    }

    public function editsuratpp($id)
    {
    $suratpp = SuratPenangananPelanggaranSengketaPemilu::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pp/editpp', compact('suratpp'));
    }

    public function editsuratppdone($id)
    {
    $suratpp = SuratPenangananPelanggaranSengketaPemilu::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pp/editppdone', compact('suratpp'));
    }

    public function updatepp(Request $request, $id){
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'substantif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
    ]);

    // Ambil nomor surat terakhir dari database
    $lastSuratNumber = SuratPenangananPelanggaranSengketaPemilu::max('no_surat');

    // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
    if (!$lastSuratNumber) {
        $lastSuratNumber = '001';
    } else {
        // Ambil angka dari nomor surat terakhir dan tambahkan 1
        $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
        // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
        $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
    }

    // Generate nomor surat baru
    $no_surat = $lastSuratNumber . '/' . $validatedData['substantif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');

    // Cari surat pengawasan pemilu berdasarkan ID
    $suratpp = SuratPenangananPelanggaranSengketaPemilu::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratpp->update([
        'status' => 'waiting', // Set the status to 'waiting' initially
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'no_surat' => $no_surat, // Gunakan nomor surat baru
    ]);
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratpp->file_surat = $fileName;
        $suratpp->status = 'done'; // Ubah status menjadi 'done'
        $suratpp->save();
    }
   //dd($suratPengawasanPemilus);

    // Save the updated model
    $suratpp->save();

    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianpp')->with('success', 'Surat berhasil diperbarui.');
    }
    public function updateppdone(Request $request, $id)
    {
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'substantif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
        'nomor_surat' => 'required',
    ]);


    // Cari surat pengawasan pemilu berdasarkan ID
    $suratpp = SuratPenangananPelanggaranSengketaPemilu::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratpp->update([
        'status' => $request->status,
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
    ]);

    // Jika ada file surat yang diunggah, simpan file tersebut
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratpp->file_surat = $fileName;
        $suratpp->status = 'done'; // Ubah status menjadi 'done'
        $suratpp->save();
    }
    $suratpp->save();
    //dd($suratPengawasanPemilus);
    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianpp')->with('success', 'Surat berhasil diperbarui.');
    }

    public function indexAntrianps()
    {
    $suratps = SuratPenyelesaianSengketa::where('status', 'waiting')
                                                    ->paginate(5);
    $suratpsdone = SuratPenyelesaianSengketa::where('status', 'done')
                                                    ->paginate(5);
    $suratpsqueue = SuratPenyelesaianSengketa::where('status', 'queue')
                                                    ->paginate(5);
    return view('pages/admin/ps/showps', compact('suratps','suratpsdone','suratpsqueue'));
    }

    public function editsuratps($id)
    {
    $suratps = SuratPenyelesaianSengketa::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/ps/editps', compact('suratps'));
    }

    public function editsuratpsdone($id)
    {
    $suratps = SuratPenyelesaianSengketa::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/ps/editpsdone', compact('suratps'));
    }
    public function updatesuratps(Request $request, $id){
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'status' => 'required',
            'surat' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
            'perihal' => 'required',
            'tujuan' => 'required',
            'jenis_surat' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
            'substantif' => 'required', // Validasi untuk substantif
            'kota' => 'required', // Validasi untuk kota
        ]);
    
        // Ambil nomor surat terakhir dari database
        $lastSuratNumber = SuratPenyelesaianSengketa::max('no_surat');
    
        // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
        if (!$lastSuratNumber) {
            $lastSuratNumber = '001';
        } else {
            // Ambil angka dari nomor surat terakhir dan tambahkan 1
            $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
            // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
            $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
        }
    
        // Generate nomor surat baru
        $no_surat = $lastSuratNumber . '/' . $validatedData['substantif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
    
        // Cari surat pengawasan pemilu berdasarkan ID
        $suratps = SuratPenyelesaianSengketa::findOrFail($id);
    
        // Perbarui data surat dengan data yang diterima dari formulir
        $suratps->update([
            'status' => 'waiting', // Set the status to 'waiting' initially
            'surat' => $request->surat,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'no_surat' => $no_surat, // Gunakan nomor surat baru
        ]);
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
    
            // Simpan nama file surat dalam database
            $suratps->file_surat = $fileName;
            $suratps->status = 'done'; // Ubah status menjadi 'done'
            $suratps->save();
        }
        //dd($suratps);
    
        // Save the updated model
        $suratps->save();
    
        // Redirect ke halaman yang sesuai setelah pembaruan
        return redirect()->route('indexAntrianps')->with('success', 'Surat berhasil diperbarui.');
        }
    
        public function updatepsdone(Request $request, $id)
    {
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'substantif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
        'nomor_surat' => 'required',
    ]);


    // Cari surat pengawasan pemilu berdasarkan ID
    $suratps = SuratPenyelesaianSengketa::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratps->update([
        'status' => $request->status,
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
    ]);

    // Jika ada file surat yang diunggah, simpan file tersebut
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratps->file_surat = $fileName;
        $suratps->status = 'done'; // Ubah status menjadi 'done'
        $suratps->save();
    }
    $suratps->save();
    //dd($suratps);
    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianps')->with('success', 'Surat berhasil diperbarui.');
    }

    public function indexAntrianpr()
    {
    $suratpr = SuratPerencanaan::where('status', 'waiting')
                                                    ->paginate(5);
    $suratprdone = SuratPerencanaan::where('status', 'done')
                                                    ->paginate(5);
    $suratprqueue = SuratPerencanaan::where('status', 'queue')
                                                    ->paginate(5);
    return view('pages/admin/pr/showpr', compact('suratpr','suratprdone','suratprqueue'));
    }

    public function editsuratpr($id)
    {
    $suratpr = SuratPerencanaan::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pr/editpr', compact('suratpr'));
    }

    public function editsuratprdone($id)
    {
    $suratpr = SuratPerencanaan::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/pr/editprdone', compact('suratpr'));
    }

    public function updatesuratpr(Request $request, $id){
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'status' => 'required',
            'surat' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
            'perihal' => 'required',
            'tujuan' => 'required',
            'jenis_surat' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
            'fasilitatif' => 'required', // Validasi untuk substantif
            'kota' => 'required', // Validasi untuk kota
        ]);
    
        // Ambil nomor surat terakhir dari database
        $lastSuratNumber = SuratPerencanaan::max('no_surat');
    
        // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
        if (!$lastSuratNumber) {
            $lastSuratNumber = '001';
        } else {
            // Ambil angka dari nomor surat terakhir dan tambahkan 1
            $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
            // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
            $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
        }
    
        // Generate nomor surat baru
        $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
    
        // Cari surat pengawasan pemilu berdasarkan ID
        $suratpr = SuratPerencanaan::findOrFail($id);
    
        // Perbarui data surat dengan data yang diterima dari formulir
        $suratpr->update([
            'status' => 'waiting', // Set the status to 'waiting' initially
            'surat' => $request->surat,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'no_surat' => $no_surat, // Gunakan nomor surat baru
        ]);
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
    
            // Simpan nama file surat dalam database
            $suratpr->file_surat = $fileName;
            $suratpr->status = 'done'; // Ubah status menjadi 'done'
            $suratpr->save();
        }
        //dd($suratps);
    
        // Save the updated model
        $suratpr->save();
    
        // Redirect ke halaman yang sesuai setelah pembaruan
        return redirect()->route('indexAntrianpr')->with('success', 'Surat berhasil diperbarui.');
        }
    
        public function updateprdone(Request $request, $id)
    {
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'status' => 'required',
        'surat' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'perihal' => 'required',
        'tujuan' => 'required',
        'jenis_surat' => 'required',
        'keterangan' => 'required',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
        'fasilitatif' => 'required', // Validasi untuk substantif
        'kota' => 'required', // Validasi untuk kota
        'nomor_surat' => 'required',
    ]);


    // Cari surat pengawasan pemilu berdasarkan ID
    $suratpr = SuratPerencanaan::findOrFail($id);

    // Perbarui data surat dengan data yang diterima dari formulir
    $suratpr->update([
        'status' => $request->status,
        'surat' => $request->surat,
        'tanggal' => $request->tanggal,
        'nama' => $request->nama,
        'perihal' => $request->perihal,
        'tujuan' => $request->tujuan,
        'jenis_surat' => $request->jenis_surat,
        'keterangan' => $request->keterangan,
        'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
    ]);

    // Jika ada file surat yang diunggah, simpan file tersebut
    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan

        // Simpan nama file surat dalam database
        $suratpr->file_surat = $fileName;
        $suratpr->status = 'done'; // Ubah status menjadi 'done'
        $suratpr->save();
    }
    $suratpr->save();
    //dd($suratps);
    // Redirect ke halaman yang sesuai setelah pembaruan
    return redirect()->route('indexAntrianpr')->with('success', 'Surat berhasil diperbarui.');
    }

    public function indexAntrianot()
    {
    $suratot = SuratOrganisasiDanTataLaksana::where('status', 'waiting')
                                                    ->paginate(5);
    $suratotdone = SuratOrganisasiDanTataLaksana::where('status', 'done')
                                                    ->paginate(5);
    $suratotqueue = SuratOrganisasiDanTataLaksana::where('status', 'queue')
                                                    ->paginate(5);
    return view('pages/admin/ot/showot', compact('suratot','suratotdone','suratotqueue'));
    }

    public function editsuratot($id)
    {
    $suratot = SuratOrganisasiDanTataLaksana::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/ot/editot', compact('suratot'));
    }

    public function editsuratotdone($id)
    {
    $suratot = SuratOrganisasiDanTataLaksana::findOrFail($id);
    // Tampilkan halaman edit surat
    return view('pages/admin/ot/editotdone', compact('suratot'));
    }

    public function updatesuratot(Request $request, $id){
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'status' => 'required',
            'surat' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
            'perihal' => 'required',
            'tujuan' => 'required',
            'jenis_surat' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
            'fasilitatif' => 'required', // Validasi untuk substantif
            'kota' => 'required', // Validasi untuk kota
        ]);
    
        // Ambil nomor surat terakhir dari database
        $lastSuratNumber = SuratOrganisasiDanTataLaksana::max('no_surat');
    
        // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
        if (!$lastSuratNumber) {
            $lastSuratNumber = '001';
        } else {
            // Ambil angka dari nomor surat terakhir dan tambahkan 1
            $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
            // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
            $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
        }
    
        // Generate nomor surat baru
        $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
    
        // Cari surat pengawasan pemilu berdasarkan ID
        $suratot = SuratOrganisasiDanTataLaksana::findOrFail($id);
    
        // Perbarui data surat dengan data yang diterima dari formulir
        $suratot->update([
            'status' => 'waiting', // Set the status to 'waiting' initially
            'surat' => $request->surat,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'no_surat' => $no_surat, // Gunakan nomor surat baru
        ]);
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
    
            // Simpan nama file surat dalam database
            $suratot->file_surat = $fileName;
            $suratot->status = 'done'; // Ubah status menjadi 'done'
            $suratot->save();
        }
        //dd($suratot);
    
        // Save the updated model
        $suratot->save();
    
        // Redirect ke halaman yang sesuai setelah pembaruan
        return redirect()->route('indexAntrianot')->with('success', 'Surat berhasil diperbarui.');
        }
        public function updateotdone(Request $request, $id)
        {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'status' => 'required',
            'surat' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
            'perihal' => 'required',
            'tujuan' => 'required',
            'jenis_surat' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
            'fasilitatif' => 'required', // Validasi untuk substantif
            'kota' => 'required', // Validasi untuk kota
            'nomor_surat' => 'required',
        ]);
    
    
        // Cari surat pengawasan pemilu berdasarkan ID
        $suratpr = SuratOrganisasiDanTataLaksana::findOrFail($id);
    
        // Perbarui data surat dengan data yang diterima dari formulir
        $suratpr->update([
            'status' => $request->status,
            'surat' => $request->surat,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
        ]);
    
        // Jika ada file surat yang diunggah, simpan file tersebut
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
    
            // Simpan nama file surat dalam database
            $suratpr->file_surat = $fileName;
            $suratpr->status = 'done'; // Ubah status menjadi 'done'
            $suratpr->save();
        }
        $suratpr->save();
        //dd($suratps);
        // Redirect ke halaman yang sesuai setelah pembaruan
        return redirect()->route('indexAntrianot')->with('success', 'Surat berhasil diperbarui.');
        }
    
        public function indexAntrianka()
        {
        $suratka = SuratPersuratanDanKearsipan::where('status', 'waiting')
                                                        ->paginate(5);
        $suratkadone = SuratPersuratanDanKearsipan::where('status', 'done')
                                                        ->paginate(5);
        $suratkaqueue = SuratPersuratanDanKearsipan::where('status', 'queue')
                                                        ->paginate(5);
        return view('pages/admin/ka/showka', compact('suratka','suratkadone','suratkaqueue'));
        }

        public function editsuratka($id)
        {
        $suratka = SuratPersuratanDanKearsipan::findOrFail($id);
        // Tampilkan halaman edit surat
        return view('pages/admin/ka/editka', compact('suratka'));
        }

        public function editsuratkadone($id)
        {
        $suratka = SuratPersuratanDanKearsipan::findOrFail($id);
        // Tampilkan halaman edit surat
        return view('pages/admin/ka/editkadone', compact('suratka'));
        }
        public function updatesuratka(Request $request, $id){
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'status' => 'required',
                'surat' => 'required',
                'tanggal' => 'required|date',
                'nama' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'jenis_surat' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                'fasilitatif' => 'required', // Validasi untuk substantif
                'kota' => 'required', // Validasi untuk kota
            ]);
        
            // Ambil nomor surat terakhir dari database
            $lastSuratNumber = SuratPersuratanDanKearsipan::max('no_surat');
        
            // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
            if (!$lastSuratNumber) {
                $lastSuratNumber = '001';
            } else {
                // Ambil angka dari nomor surat terakhir dan tambahkan 1
                $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
            }
        
            // Generate nomor surat baru
            $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
        
            // Cari surat pengawasan pemilu berdasarkan ID
            $suratka = SuratPersuratanDanKearsipan::findOrFail($id);
        
            // Perbarui data surat dengan data yang diterima dari formulir
            $suratka->update([
                'status' => 'waiting', // Set the status to 'waiting' initially
                'surat' => $request->surat,
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'jenis_surat' => $request->jenis_surat,
                'keterangan' => $request->keterangan,
                'no_surat' => $no_surat, // Gunakan nomor surat baru
            ]);
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
        
                // Simpan nama file surat dalam database
                $suratka->file_surat = $fileName;
                $suratka->status = 'done'; // Ubah status menjadi 'done'
                $suratka->save();
            }
            //dd($suratot);
        
            // Save the updated model
            $suratka->save();
        
            // Redirect ke halaman yang sesuai setelah pembaruan
            return redirect()->route('indexAntrianka')->with('success', 'Surat berhasil diperbarui.');
            }
            public function updatekadone(Request $request, $id)
        {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'status' => 'required',
            'surat' => 'required',
            'tanggal' => 'required|date',
            'nama' => 'required',
            'perihal' => 'required',
            'tujuan' => 'required',
            'jenis_surat' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
            'fasilitatif' => 'required', // Validasi untuk substantif
            'kota' => 'required', // Validasi untuk kota
            'nomor_surat' => 'required',
        ]);
    
    
        // Cari surat pengawasan pemilu berdasarkan ID
        $suratka = SuratPersuratanDanKearsipan::findOrFail($id);
    
        // Perbarui data surat dengan data yang diterima dari formulir
        $suratka->update([
            'status' => $request->status,
            'surat' => $request->surat,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
        ]);
    
        // Jika ada file surat yang diunggah, simpan file tersebut
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
    
            // Simpan nama file surat dalam database
            $suratka->file_surat = $fileName;
            $suratka->status = 'done'; // Ubah status menjadi 'done'
            $suratka->save();
        }
        $suratka->save();
        //dd($suratps);
        // Redirect ke halaman yang sesuai setelah pembaruan
        return redirect()->route('indexAntrianka')->with('success', 'Surat berhasil diperbarui.');
        }

        public function indexAntrianku()
        {
        $suratku = SuratKeuangan::where('status', 'waiting')
                                                        ->paginate(5);
        $suratkudone = SuratKeuangan::where('status', 'done')
                                                        ->paginate(5);
        $suratkuqueue = SuratKeuangan::where('status', 'queue')
                                                        ->paginate(5);
        return view('pages/admin/ku/showku', compact('suratku','suratkudone','suratkuqueue'));
        }

        public function editsuratku($id)
        {
        $suratku = SuratKeuangan::findOrFail($id);
        // Tampilkan halaman edit surat
        return view('pages/admin/ku/editku', compact('suratku'));
        }

        public function editsuratkudone($id)
        {
        $suratku = SuratKeuangan::findOrFail($id);
        // Tampilkan halaman edit surat
        return view('pages/admin/ku/editkudone', compact('suratku'));
        }

        public function updatesuratku(Request $request, $id){
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'status' => 'required',
                'surat' => 'required',
                'tanggal' => 'required|date',
                'nama' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'jenis_surat' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                'fasilitatif' => 'required', // Validasi untuk substantif
                'kota' => 'required', // Validasi untuk kota
            ]);
        
            // Ambil nomor surat terakhir dari database
            $lastSuratNumber = SuratKeuangan::max('no_surat');
        
            // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
            if (!$lastSuratNumber) {
                $lastSuratNumber = '001';
            } else {
                // Ambil angka dari nomor surat terakhir dan tambahkan 1
                $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
            }
        
            // Generate nomor surat baru
            $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
        
            // Cari surat pengawasan pemilu berdasarkan ID
            $suratka = SuratKeuangan::findOrFail($id);
        
            // Perbarui data surat dengan data yang diterima dari formulir
            $suratka->update([
                'status' => 'waiting', // Set the status to 'waiting' initially
                'surat' => $request->surat,
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'jenis_surat' => $request->jenis_surat,
                'keterangan' => $request->keterangan,
                'no_surat' => $no_surat, // Gunakan nomor surat baru
            ]);
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
        
                // Simpan nama file surat dalam database
                $suratka->file_surat = $fileName;
                $suratka->status = 'done'; // Ubah status menjadi 'done'
                $suratka->save();
            }
            //dd($suratot);
        
            // Save the updated model
            $suratka->save();
        
            // Redirect ke halaman yang sesuai setelah pembaruan
            return redirect()->route('indexAntrianku')->with('success', 'Surat berhasil diperbarui.');
            }

            public function updatekudone(Request $request, $id)
            {
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'status' => 'required',
                'surat' => 'required',
                'tanggal' => 'required|date',
                'nama' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'jenis_surat' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                'fasilitatif' => 'required', // Validasi untuk substantif
                'kota' => 'required', // Validasi untuk kota
                'nomor_surat' => 'required',
            ]);
        
        
            // Cari surat pengawasan pemilu berdasarkan ID
            $suratku = SuratKeuangan::findOrFail($id);
        
            // Perbarui data surat dengan data yang diterima dari formulir
            $suratku->update([
                'status' => $request->status,
                'surat' => $request->surat,
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'jenis_surat' => $request->jenis_surat,
                'keterangan' => $request->keterangan,
                'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
            ]);
        
            // Jika ada file surat yang diunggah, simpan file tersebut
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
        
                // Simpan nama file surat dalam database
                $suratku->file_surat = $fileName;
                $suratku->status = 'done'; // Ubah status menjadi 'done'
                $suratku->save();
            }
            $suratku->save();
            //dd($suratps);
            // Redirect ke halaman yang sesuai setelah pembaruan
            return redirect()->route('indexAntrianku')->with('success', 'Surat berhasil diperbarui.');
            }

            public function indexAntrianpl()
            {
            $suratpl = SuratPerlengkapan::where('status', 'waiting')
                                                            ->paginate(5);
            $suratpldone = SuratPerlengkapan::where('status', 'done')
                                                            ->paginate(5);
            $suratplqueue = SuratPerlengkapan::where('status', 'queue')
                                                            ->paginate(5);
            return view('pages/admin/pl/showpl', compact('suratpl','suratpldone','suratplqueue'));
            }
    
            public function editsuratpl($id)
            {
            $suratpl = SuratPerlengkapan::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/pl/editpl', compact('suratpl'));
            }
    
            public function editsuratpldone($id)
            {
            $suratpl = SuratPerlengkapan::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/pl/editpldone', compact('suratpl'));
            }

            public function updatesuratpl(Request $request, $id){
                // Validasi data yang diterima dari formulir
                $validatedData = $request->validate([
                    'status' => 'required',
                    'surat' => 'required',
                    'tanggal' => 'required|date',
                    'nama' => 'required',
                    'perihal' => 'required',
                    'tujuan' => 'required',
                    'jenis_surat' => 'required',
                    'keterangan' => 'required',
                    'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                    'fasilitatif' => 'required', // Validasi untuk substantif
                    'kota' => 'required', // Validasi untuk kota
                ]);
            
                // Ambil nomor surat terakhir dari database
                $lastSuratNumber = SuratPerlengkapan::max('no_surat');
            
                // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                if (!$lastSuratNumber) {
                    $lastSuratNumber = '001';
                } else {
                    // Ambil angka dari nomor surat terakhir dan tambahkan 1
                    $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                    // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                    $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                }
            
                // Generate nomor surat baru
                $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
            
                // Cari surat pengawasan pemilu berdasarkan ID
                $suratpl = SuratPerlengkapan::findOrFail($id);
            
                // Perbarui data surat dengan data yang diterima dari formulir
                $suratpl->update([
                    'status' => 'waiting', // Set the status to 'waiting' initially
                    'surat' => $request->surat,
                    'tanggal' => $request->tanggal,
                    'nama' => $request->nama,
                    'perihal' => $request->perihal,
                    'tujuan' => $request->tujuan,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'no_surat' => $no_surat, // Gunakan nomor surat baru
                ]);
                if ($request->hasFile('file_surat')) {
                    $file = $request->file('file_surat');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
            
                    // Simpan nama file surat dalam database
                    $suratpl->file_surat = $fileName;
                    $suratpl->status = 'done'; // Ubah status menjadi 'done'
                    $suratpl->save();
                }
                //dd($suratot);
            
                // Save the updated model
                $suratpl->save();
            
                // Redirect ke halaman yang sesuai setelah pembaruan
                return redirect()->route('indexAntrianpl')->with('success', 'Surat berhasil diperbarui.');
                }

                public function updatepldone(Request $request, $id)
            {
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'status' => 'required',
                'surat' => 'required',
                'tanggal' => 'required|date',
                'nama' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'jenis_surat' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                'fasilitatif' => 'required', // Validasi untuk substantif
                'kota' => 'required', // Validasi untuk kota
                'nomor_surat' => 'required',
            ]);
        
        
            // Cari surat pengawasan pemilu berdasarkan ID
            $suratpl = SuratPerlengkapan::findOrFail($id);
        
            // Perbarui data surat dengan data yang diterima dari formulir
            $suratpl->update([
                'status' => $request->status,
                'surat' => $request->surat,
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'jenis_surat' => $request->jenis_surat,
                'keterangan' => $request->keterangan,
                'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
            ]);
        
            // Jika ada file surat yang diunggah, simpan file tersebut
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
        
                // Simpan nama file surat dalam database
                $suratpl->file_surat = $fileName;
                $suratpl->status = 'done'; // Ubah status menjadi 'done'
                $suratpl->save();
            }
            $suratpl->save();
            //dd($suratps);
            // Redirect ke halaman yang sesuai setelah pembaruan
            return redirect()->route('indexAntrianpl')->with('success', 'Surat berhasil diperbarui.');
            }
            
            public function indexAntrianhk()
            {
            $surathk = SuratHukum::where('status', 'waiting')
                                                            ->paginate(5);
            $surathkdone = SuratHukum::where('status', 'done')
                                                            ->paginate(5);
            $surathkqueue = SuratHukum::where('status', 'queue')
                                                            ->paginate(5);
            return view('pages/admin/hk/showhk', compact('surathk','surathkdone','surathkqueue'));
            }
    
            public function editsurathk($id)
            {
            $surathk = SuratHukum::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/hk/edithk', compact('surathk'));
            }
    
            public function editsurathkdone($id)
            {
            $surathk = SuratHukum::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/hk/edithkdone', compact('surathk'));
            }
            public function updatesurathk(Request $request, $id){
                // Validasi data yang diterima dari formulir
                $validatedData = $request->validate([
                    'status' => 'required',
                    'surat' => 'required',
                    'tanggal' => 'required|date',
                    'nama' => 'required',
                    'perihal' => 'required',
                    'tujuan' => 'required',
                    'jenis_surat' => 'required',
                    'keterangan' => 'required',
                    'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                    'fasilitatif' => 'required', // Validasi untuk substantif
                    'kota' => 'required', // Validasi untuk kota
                ]);
            
                // Ambil nomor surat terakhir dari database
                $lastSuratNumber = SuratHukum::max('no_surat');
            
                // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                if (!$lastSuratNumber) {
                    $lastSuratNumber = '001';
                } else {
                    // Ambil angka dari nomor surat terakhir dan tambahkan 1
                    $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                    // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                    $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                }
            
                // Generate nomor surat baru
                $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
            
                // Cari surat pengawasan pemilu berdasarkan ID
                $surathk = SuratHukum::findOrFail($id);
            
                // Perbarui data surat dengan data yang diterima dari formulir
                $surathk->update([
                    'status' => 'waiting', // Set the status to 'waiting' initially
                    'surat' => $request->surat,
                    'tanggal' => $request->tanggal,
                    'nama' => $request->nama,
                    'perihal' => $request->perihal,
                    'tujuan' => $request->tujuan,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'no_surat' => $no_surat, // Gunakan nomor surat baru
                ]);
                if ($request->hasFile('file_surat')) {
                    $file = $request->file('file_surat');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
            
                    // Simpan nama file surat dalam database
                    $surathk->file_surat = $fileName;
                    $surathk->status = 'done'; // Ubah status menjadi 'done'
                    $surathk->save();
                }
                //dd($suratot);
            
                // Save the updated model
                $surathk->save();
            
                // Redirect ke halaman yang sesuai setelah pembaruan
                return redirect()->route('indexAntrianhk')->with('success', 'Surat berhasil diperbarui.');
                }

                public function updatehkdone(Request $request, $id)
            {
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'status' => 'required',
                'surat' => 'required',
                'tanggal' => 'required|date',
                'nama' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'jenis_surat' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                'fasilitatif' => 'required', // Validasi untuk substantif
                'kota' => 'required', // Validasi untuk kota
                'nomor_surat' => 'required',
            ]);
        
        
            // Cari surat pengawasan pemilu berdasarkan ID
            $surathk = SuratHukum::findOrFail($id);
        
            // Perbarui data surat dengan data yang diterima dari formulir
            $surathk->update([
                'status' => $request->status,
                'surat' => $request->surat,
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'perihal' => $request->perihal,
                'tujuan' => $request->tujuan,
                'jenis_surat' => $request->jenis_surat,
                'keterangan' => $request->keterangan,
                'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
            ]);
        
            // Jika ada file surat yang diunggah, simpan file tersebut
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
        
                // Simpan nama file surat dalam database
                $surathk->file_surat = $fileName;
                $surathk->status = 'done'; // Ubah status menjadi 'done'
                $surathk->save();
            }
            $surathk->save();
            //dd($suratps);
            // Redirect ke halaman yang sesuai setelah pembaruan
            return redirect()->route('indexAntrianhk')->with('success', 'Surat berhasil diperbarui.');
            }

            public function indexAntrianhm()
            {
            $surathm = SuratHubunganMasyarakat::where('status', 'waiting')
                                                            ->paginate(5);
            $surathmdone = SuratHubunganMasyarakat::where('status', 'done')
                                                            ->paginate(5);
            $surathmqueue = SuratHubunganMasyarakat::where('status', 'queue')
                                                            ->paginate(5);
            return view('pages/admin/hm/showhm', compact('surathm','surathmdone','surathmqueue'));
            }
    
            public function editsurathm($id)
            {
            $surathm = SuratHubunganMasyarakat::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/hm/edithm', compact('surathm'));
            }
    
            public function editsurathmdone($id)
            {
            $surathm = SuratHubunganMasyarakat::findOrFail($id);
            // Tampilkan halaman edit surat
            return view('pages/admin/hm/edithmdone', compact('surathm'));
            }

            public function updatesurathm(Request $request, $id){
                // Validasi data yang diterima dari formulir
                $validatedData = $request->validate([
                    'status' => 'required',
                    'surat' => 'required',
                    'tanggal' => 'required|date',
                    'nama' => 'required',
                    'perihal' => 'required',
                    'tujuan' => 'required',
                    'jenis_surat' => 'required',
                    'keterangan' => 'required',
                    'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                    'fasilitatif' => 'required', // Validasi untuk substantif
                    'kota' => 'required', // Validasi untuk kota
                ]);
            
                // Ambil nomor surat terakhir dari database
                $lastSuratNumber = SuratHubunganMasyarakat::max('no_surat');
            
                // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                if (!$lastSuratNumber) {
                    $lastSuratNumber = '001';
                } else {
                    // Ambil angka dari nomor surat terakhir dan tambahkan 1
                    $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                    // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                    $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                }
            
                // Generate nomor surat baru
                $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
            
                // Cari surat pengawasan pemilu berdasarkan ID
                $surathm = SuratHubunganMasyarakat::findOrFail($id);
            
                // Perbarui data surat dengan data yang diterima dari formulir
                $surathm->update([
                    'status' => 'waiting', // Set the status to 'waiting' initially
                    'surat' => $request->surat,
                    'tanggal' => $request->tanggal,
                    'nama' => $request->nama,
                    'perihal' => $request->perihal,
                    'tujuan' => $request->tujuan,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'no_surat' => $no_surat, // Gunakan nomor surat baru
                ]);
                if ($request->hasFile('file_surat')) {
                    $file = $request->file('file_surat');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
            
                    // Simpan nama file surat dalam database
                    $surathm->file_surat = $fileName;
                    $surathm->status = 'done'; // Ubah status menjadi 'done'
                    $surathm->save();
                }
                //dd($suratot);
            
                // Save the updated model
                $surathm->save();
            
                // Redirect ke halaman yang sesuai setelah pembaruan
                return redirect()->route('indexAntrianhm')->with('success', 'Surat berhasil diperbarui.');
                }

            public function updatehmdone(Request $request, $id)
                {
                // Validasi data yang diterima dari formulir
                $validatedData = $request->validate([
                    'status' => 'required',
                    'surat' => 'required',
                    'tanggal' => 'required|date',
                    'nama' => 'required',
                    'perihal' => 'required',
                    'tujuan' => 'required',
                    'jenis_surat' => 'required',
                    'keterangan' => 'required',
                    'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                    'fasilitatif' => 'required', // Validasi untuk substantif
                    'kota' => 'required', // Validasi untuk kota
                    'nomor_surat' => 'required',
                ]);
            
            
                // Cari surat pengawasan pemilu berdasarkan ID
                $surathm = SuratHubunganMasyarakat::findOrFail($id);
            
                // Perbarui data surat dengan data yang diterima dari formulir
                $surathm->update([
                    'status' => $request->status,
                    'surat' => $request->surat,
                    'tanggal' => $request->tanggal,
                    'nama' => $request->nama,
                    'perihal' => $request->perihal,
                    'tujuan' => $request->tujuan,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
                ]);
            
                // Jika ada file surat yang diunggah, simpan file tersebut
                if ($request->hasFile('file_surat')) {
                    $file = $request->file('file_surat');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
            
                    // Simpan nama file surat dalam database
                    $surathm->file_surat = $fileName;
                    $surathm->status = 'done'; // Ubah status menjadi 'done'
                    $surathm->save();
                }
                $surathm->save();
                //dd($suratps);
                // Redirect ke halaman yang sesuai setelah pembaruan
                return redirect()->route('indexAntrianhm')->with('success', 'Surat berhasil diperbarui.');
                }

                public function indexAntriankp()
                {
                $suratkp = SuratKepegawaian::where('status', 'waiting')
                                                                ->paginate(5);
                $suratkpdone = SuratKepegawaian::where('status', 'done')
                                                                ->paginate(5);
                $suratkpqueue = SuratKepegawaian::where('status', 'queue')
                                                                ->paginate(5);
                return view('pages/admin/kp/showkp', compact('suratkp','suratkpdone','suratkpqueue'));
                }
        
                public function editsuratkp($id)
                {
                $suratkp = SuratKepegawaian::findOrFail($id);
                // Tampilkan halaman edit surat
                return view('pages/admin/kp/editkp', compact('suratkp'));
                }
        
                public function editsuratkpdone($id)
                {
                $suratkp = SuratKepegawaian::findOrFail($id);
                // Tampilkan halaman edit surat
                return view('pages/admin/kp/editkpdone', compact('suratkp'));
                }
                public function updatesuratkp(Request $request, $id){
                    // Validasi data yang diterima dari formulir
                    $validatedData = $request->validate([
                        'status' => 'required',
                        'surat' => 'required',
                        'tanggal' => 'required|date',
                        'nama' => 'required',
                        'perihal' => 'required',
                        'tujuan' => 'required',
                        'jenis_surat' => 'required',
                        'keterangan' => 'required',
                        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                        'fasilitatif' => 'required', // Validasi untuk substantif
                        'kota' => 'required', // Validasi untuk kota
                    ]);
                
                    // Ambil nomor surat terakhir dari database
                    $lastSuratNumber = SuratKepegawaian::max('no_surat');
                
                    // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                    if (!$lastSuratNumber) {
                        $lastSuratNumber = '001';
                    } else {
                        // Ambil angka dari nomor surat terakhir dan tambahkan 1
                        $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                        // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                        $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                    }
                
                    // Generate nomor surat baru
                    $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
                
                    // Cari surat pengawasan pemilu berdasarkan ID
                    $suratkp = SuratKepegawaian::findOrFail($id);
                
                    // Perbarui data surat dengan data yang diterima dari formulir
                    $suratkp->update([
                        'status' => 'waiting', // Set the status to 'waiting' initially
                        'surat' => $request->surat,
                        'tanggal' => $request->tanggal,
                        'nama' => $request->nama,
                        'perihal' => $request->perihal,
                        'tujuan' => $request->tujuan,
                        'jenis_surat' => $request->jenis_surat,
                        'keterangan' => $request->keterangan,
                        'no_surat' => $no_surat, // Gunakan nomor surat baru
                    ]);
                    if ($request->hasFile('file_surat')) {
                        $file = $request->file('file_surat');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                
                        // Simpan nama file surat dalam database
                        $suratkp->file_surat = $fileName;
                        $suratkp->status = 'done'; // Ubah status menjadi 'done'
                        $suratkp->save();
                    }
                    //dd($suratot);
                
                    // Save the updated model
                    $suratkp->save();
                
                    // Redirect ke halaman yang sesuai setelah pembaruan
                    return redirect()->route('indexAntriankp')->with('success', 'Surat berhasil diperbarui.');
                    }

                    public function updatekpdone(Request $request, $id)
                    {
                    // Validasi data yang diterima dari formulir
                    $validatedData = $request->validate([
                        'status' => 'required',
                        'surat' => 'required',
                        'tanggal' => 'required|date',
                        'nama' => 'required',
                        'perihal' => 'required',
                        'tujuan' => 'required',
                        'jenis_surat' => 'required',
                        'keterangan' => 'required',
                        'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                        'fasilitatif' => 'required', // Validasi untuk substantif
                        'kota' => 'required', // Validasi untuk kota
                        'nomor_surat' => 'required',
                    ]);
                
                
                    // Cari surat pengawasan pemilu berdasarkan ID
                    $suratkp = SuratKepegawaian::findOrFail($id);
                
                    // Perbarui data surat dengan data yang diterima dari formulir
                    $suratkp->update([
                        'status' => $request->status,
                        'surat' => $request->surat,
                        'tanggal' => $request->tanggal,
                        'nama' => $request->nama,
                        'perihal' => $request->perihal,
                        'tujuan' => $request->tujuan,
                        'jenis_surat' => $request->jenis_surat,
                        'keterangan' => $request->keterangan,
                        'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
                    ]);
                
                    // Jika ada file surat yang diunggah, simpan file tersebut
                    if ($request->hasFile('file_surat')) {
                        $file = $request->file('file_surat');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                
                        // Simpan nama file surat dalam database
                        $suratkp->file_surat = $fileName;
                        $suratkp->status = 'done'; // Ubah status menjadi 'done'
                        $suratkp->save();
                    }
                    $suratkp->save();
                    //dd($suratps);
                    // Redirect ke halaman yang sesuai setelah pembaruan
                    return redirect()->route('indexAntriankp')->with('success', 'Surat berhasil diperbarui.');
                    }

                    public function indexAntrianrt()
                    {
                    $suratrt = SuratKetatausahaanDanKerumahtangaan::where('status', 'waiting')
                                                                    ->paginate(5);
                    $suratrtdone = SuratKetatausahaanDanKerumahtangaan::where('status', 'done')
                                                                    ->paginate(5);
                    $suratrtqueue = SuratKetatausahaanDanKerumahtangaan::where('status', 'queue')
                                                                    ->paginate(5);
                    return view('pages/admin/rt/showrt', compact('suratrt','suratrtdone','suratrtqueue'));
                    }
            
                    public function editsuratrt($id)
                    {
                    $suratrt = SuratKetatausahaanDanKerumahtangaan::findOrFail($id);
                    // Tampilkan halaman edit surat
                    return view('pages/admin/rt/editrt', compact('suratrt'));
                    }
            
                    public function editsuratrtdone($id)
                    {
                    $suratrt = SuratKetatausahaanDanKerumahtangaan::findOrFail($id);
                    // Tampilkan halaman edit surat
                    return view('pages/admin/rt/editrtdone', compact('suratrt'));
                    }

                    public function updatesuratrt(Request $request, $id){
                        // Validasi data yang diterima dari formulir
                        $validatedData = $request->validate([
                            'status' => 'required',
                            'surat' => 'required',
                            'tanggal' => 'required|date',
                            'nama' => 'required',
                            'perihal' => 'required',
                            'tujuan' => 'required',
                            'jenis_surat' => 'required',
                            'keterangan' => 'required',
                            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                            'fasilitatif' => 'required', // Validasi untuk substantif
                            'kota' => 'required', // Validasi untuk kota
                        ]);
                    
                        // Ambil nomor surat terakhir dari database
                        $lastSuratNumber = SuratKetatausahaanDanKerumahtangaan::max('no_surat');
                    
                        // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                        if (!$lastSuratNumber) {
                            $lastSuratNumber = '001';
                        } else {
                            // Ambil angka dari nomor surat terakhir dan tambahkan 1
                            $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                            // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                            $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                        }
                    
                        // Generate nomor surat baru
                        $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
                    
                        // Cari surat pengawasan pemilu berdasarkan ID
                        $suratrt = SuratKetatausahaanDanKerumahtangaan::findOrFail($id);
                    
                        // Perbarui data surat dengan data yang diterima dari formulir
                        $suratrt->update([
                            'status' => 'waiting', // Set the status to 'waiting' initially
                            'surat' => $request->surat,
                            'tanggal' => $request->tanggal,
                            'nama' => $request->nama,
                            'perihal' => $request->perihal,
                            'tujuan' => $request->tujuan,
                            'jenis_surat' => $request->jenis_surat,
                            'keterangan' => $request->keterangan,
                            'no_surat' => $no_surat, // Gunakan nomor surat baru
                        ]);
                        if ($request->hasFile('file_surat')) {
                            $file = $request->file('file_surat');
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                    
                            // Simpan nama file surat dalam database
                            $suratrt->file_surat = $fileName;
                            $suratrt->status = 'done'; // Ubah status menjadi 'done'
                            $suratrt->save();
                        }
                        //dd($suratot);
                    
                        // Save the updated model
                        $suratrt->save();
                    
                        // Redirect ke halaman yang sesuai setelah pembaruan
                        return redirect()->route('indexAntrianrt')->with('success', 'Surat berhasil diperbarui.');
                        }

                        public function updatertdone(Request $request, $id)
                        {
                        // Validasi data yang diterima dari formulir
                        $validatedData = $request->validate([
                            'status' => 'required',
                            'surat' => 'required',
                            'tanggal' => 'required|date',
                            'nama' => 'required',
                            'perihal' => 'required',
                            'tujuan' => 'required',
                            'jenis_surat' => 'required',
                            'keterangan' => 'required',
                            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                            'fasilitatif' => 'required', // Validasi untuk substantif
                            'kota' => 'required', // Validasi untuk kota
                            'nomor_surat' => 'required',
                        ]);
                    
                    
                        // Cari surat pengawasan pemilu berdasarkan ID
                        $suratrt = SuratKetatausahaanDanKerumahtangaan::findOrFail($id);
                    
                        // Perbarui data surat dengan data yang diterima dari formulir
                        $suratrt->update([
                            'status' => $request->status,
                            'surat' => $request->surat,
                            'tanggal' => $request->tanggal,
                            'nama' => $request->nama,
                            'perihal' => $request->perihal,
                            'tujuan' => $request->tujuan,
                            'jenis_surat' => $request->jenis_surat,
                            'keterangan' => $request->keterangan,
                            'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
                        ]);
                    
                        // Jika ada file surat yang diunggah, simpan file tersebut
                        if ($request->hasFile('file_surat')) {
                            $file = $request->file('file_surat');
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                    
                            // Simpan nama file surat dalam database
                            $suratrt->file_surat = $fileName;
                            $suratrt->status = 'done'; // Ubah status menjadi 'done'
                            $suratrt->save();
                        }
                        $suratrt->save();
                        //dd($suratps);
                        // Redirect ke halaman yang sesuai setelah pembaruan
                        return redirect()->route('indexAntrianrt')->with('success', 'Surat berhasil diperbarui.');
                        }

                        public function indexAntrianpw()
                        {
                        $suratpw = SuratPengawasan::where('status', 'waiting')
                                                                        ->paginate(5);
                        $suratpwdone = SuratPengawasan::where('status', 'done')
                                                                        ->paginate(5);
                        $suratpwqueue = SuratPengawasan::where('status', 'queue')
                                                                        ->paginate(5);
                        return view('pages/admin/pw/showpw', compact('suratpw','suratpwdone','suratpwqueue'));
                        }
                
                        public function editsuratpw($id)
                        {
                        $suratpw = SuratPengawasan::findOrFail($id);
                        // Tampilkan halaman edit surat
                        return view('pages/admin/pw/editpw', compact('suratpw'));
                        }
                
                        public function editsuratpwdone($id)
                        {
                        $suratpw = SuratPengawasan::findOrFail($id);
                        // Tampilkan halaman edit surat
                        return view('pages/admin/pw/editpwdone', compact('suratpw'));
                        }

                        public function updatesuratpw(Request $request, $id){
                            // Validasi data yang diterima dari formulir
                            $validatedData = $request->validate([
                                'status' => 'required',
                                'surat' => 'required',
                                'tanggal' => 'required|date',
                                'nama' => 'required',
                                'perihal' => 'required',
                                'tujuan' => 'required',
                                'jenis_surat' => 'required',
                                'keterangan' => 'required',
                                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                                'fasilitatif' => 'required', // Validasi untuk substantif
                                'kota' => 'required', // Validasi untuk kota
                            ]);
                        
                            // Ambil nomor surat terakhir dari database
                            $lastSuratNumber = SuratPengawasan::max('no_surat');
                        
                            // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                            if (!$lastSuratNumber) {
                                $lastSuratNumber = '001';
                            } else {
                                // Ambil angka dari nomor surat terakhir dan tambahkan 1
                                $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                                // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                                $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                            }
                        
                            // Generate nomor surat baru
                            $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
                        
                            // Cari surat pengawasan pemilu berdasarkan ID
                            $suratpw = SuratPengawasan::findOrFail($id);
                        
                            // Perbarui data surat dengan data yang diterima dari formulir
                            $suratpw->update([
                                'status' => 'waiting', // Set the status to 'waiting' initially
                                'surat' => $request->surat,
                                'tanggal' => $request->tanggal,
                                'nama' => $request->nama,
                                'perihal' => $request->perihal,
                                'tujuan' => $request->tujuan,
                                'jenis_surat' => $request->jenis_surat,
                                'keterangan' => $request->keterangan,
                                'no_surat' => $no_surat, // Gunakan nomor surat baru
                            ]);
                            if ($request->hasFile('file_surat')) {
                                $file = $request->file('file_surat');
                                $fileName = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                        
                                // Simpan nama file surat dalam database
                                $suratpw->file_surat = $fileName;
                                $suratpw->status = 'done'; // Ubah status menjadi 'done'
                                $suratpw->save();
                            }
                            //dd($suratot);
                        
                            // Save the updated model
                            $suratpw->save();
                        
                            // Redirect ke halaman yang sesuai setelah pembaruan
                            return redirect()->route('indexAntrianpw')->with('success', 'Surat berhasil diperbarui.');
                            }

                            public function updatepwdone(Request $request, $id)
                            {
                            // Validasi data yang diterima dari formulir
                            $validatedData = $request->validate([
                                'status' => 'required',
                                'surat' => 'required',
                                'tanggal' => 'required|date',
                                'nama' => 'required',
                                'perihal' => 'required',
                                'tujuan' => 'required',
                                'jenis_surat' => 'required',
                                'keterangan' => 'required',
                                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                                'fasilitatif' => 'required', // Validasi untuk substantif
                                'kota' => 'required', // Validasi untuk kota
                                'nomor_surat' => 'required',
                            ]);
                        
                        
                            // Cari surat pengawasan pemilu berdasarkan ID
                            $suratpw = SuratPengawasan::findOrFail($id);
                        
                            // Perbarui data surat dengan data yang diterima dari formulir
                            $suratpw->update([
                                'status' => $request->status,
                                'surat' => $request->surat,
                                'tanggal' => $request->tanggal,
                                'nama' => $request->nama,
                                'perihal' => $request->perihal,
                                'tujuan' => $request->tujuan,
                                'jenis_surat' => $request->jenis_surat,
                                'keterangan' => $request->keterangan,
                                'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
                            ]);
                        
                            // Jika ada file surat yang diunggah, simpan file tersebut
                            if ($request->hasFile('file_surat')) {
                                $file = $request->file('file_surat');
                                $fileName = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                        
                                // Simpan nama file surat dalam database
                                $suratpw->file_surat = $fileName;
                                $suratpw->status = 'done'; // Ubah status menjadi 'done'
                                $suratpw->save();
                            }
                            $suratpw->save();
                            //dd($suratps);
                            // Redirect ke halaman yang sesuai setelah pembaruan
                            return redirect()->route('indexAntrianpw')->with('success', 'Surat berhasil diperbarui.');
                            }

                            public function indexAntrianti()
                            {
                            $suratti = SuratTeknologiInformasi::where('status', 'waiting')
                                                                            ->paginate(5);
                            $surattidone = SuratTeknologiInformasi::where('status', 'done')
                                                                            ->paginate(5);
                            $surattiqueue = SuratTeknologiInformasi::where('status', 'queue')
                                                                            ->paginate(5);
                            return view('pages/admin/ti/showti', compact('suratti','surattidone','surattiqueue'));
                            }
                    
                            public function editsuratti($id)
                            {
                            $suratti = SuratTeknologiInformasi::findOrFail($id);
                            // Tampilkan halaman edit surat
                            return view('pages/admin/ti/editti', compact('suratti'));
                            }
                    
                            public function editsurattidone($id)
                            {
                            $suratti = SuratTeknologiInformasi::findOrFail($id);
                            // Tampilkan halaman edit surat
                            return view('pages/admin/ti/edittidone', compact('suratti'));
                            }

                            public function updatesuratti(Request $request, $id){
                                // Validasi data yang diterima dari formulir
                                $validatedData = $request->validate([
                                    'status' => 'required',
                                    'surat' => 'required',
                                    'tanggal' => 'required|date',
                                    'nama' => 'required',
                                    'perihal' => 'required',
                                    'tujuan' => 'required',
                                    'jenis_surat' => 'required',
                                    'keterangan' => 'required',
                                    'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                                    'fasilitatif' => 'required', // Validasi untuk substantif
                                    'kota' => 'required', // Validasi untuk kota
                                ]);
                            
                                // Ambil nomor surat terakhir dari database
                                $lastSuratNumber = SuratTeknologiInformasi::max('no_surat');
                            
                                // Jika tidak ada nomor surat sebelumnya, gunakan nomor surat awal "001"
                                if (!$lastSuratNumber) {
                                    $lastSuratNumber = '001';
                                } else {
                                    // Ambil angka dari nomor surat terakhir dan tambahkan 1
                                    $lastSuratNumber = intval(substr($lastSuratNumber, 0, 3)) + 1;
                                    // Format nomor surat dengan 3 digit dan tambahkan 0 di depan jika perlu
                                    $lastSuratNumber = sprintf("%03d", $lastSuratNumber);
                                }
                            
                                // Generate nomor surat baru
                                $no_surat = $lastSuratNumber . '/' . $validatedData['fasilitatif'] . '/' . $validatedData['kota'] . '/' . date('m') . '/' . date('Y');
                            
                                // Cari surat pengawasan pemilu berdasarkan ID
                                $suratti = SuratTeknologiInformasi::findOrFail($id);
                            
                                // Perbarui data surat dengan data yang diterima dari formulir
                                $suratti->update([
                                    'status' => 'waiting', // Set the status to 'waiting' initially
                                    'surat' => $request->surat,
                                    'tanggal' => $request->tanggal,
                                    'nama' => $request->nama,
                                    'perihal' => $request->perihal,
                                    'tujuan' => $request->tujuan,
                                    'jenis_surat' => $request->jenis_surat,
                                    'keterangan' => $request->keterangan,
                                    'no_surat' => $no_surat, // Gunakan nomor surat baru
                                ]);
                                if ($request->hasFile('file_surat')) {
                                    $file = $request->file('file_surat');
                                    $fileName = time() . '_' . $file->getClientOriginalName();
                                    $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                            
                                    // Simpan nama file surat dalam database
                                    $suratti->file_surat = $fileName;
                                    $suratti->status = 'done'; // Ubah status menjadi 'done'
                                    $suratti->save();
                                }
                                //dd($suratot);
                            
                                // Save the updated model
                                $suratti->save();
                            
                                // Redirect ke halaman yang sesuai setelah pembaruan
                                return redirect()->route('indexAntrianti')->with('success', 'Surat berhasil diperbarui.');
                                }

                                public function updatetidone(Request $request, $id)
                            {
                            // Validasi data yang diterima dari formulir
                            $validatedData = $request->validate([
                                'status' => 'required',
                                'surat' => 'required',
                                'tanggal' => 'required|date',
                                'nama' => 'required',
                                'perihal' => 'required',
                                'tujuan' => 'required',
                                'jenis_surat' => 'required',
                                'keterangan' => 'required',
                                'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Validasi untuk file surat (opsional)
                                'fasilitatif' => 'required', // Validasi untuk substantif
                                'kota' => 'required', // Validasi untuk kota
                                'nomor_surat' => 'required',
                            ]);
                        
                        
                            // Cari surat pengawasan pemilu berdasarkan ID
                            $suratti = SuratTeknologiInformasi::findOrFail($id);
                        
                            // Perbarui data surat dengan data yang diterima dari formulir
                            $suratti->update([
                                'status' => $request->status,
                                'surat' => $request->surat,
                                'tanggal' => $request->tanggal,
                                'nama' => $request->nama,
                                'perihal' => $request->perihal,
                                'tujuan' => $request->tujuan,
                                'jenis_surat' => $request->jenis_surat,
                                'keterangan' => $request->keterangan,
                                'nomor_surat' => $request->nomor_surat, // Gunakan nomor surat baru
                            ]);
                        
                            // Jika ada file surat yang diunggah, simpan file tersebut
                            if ($request->hasFile('file_surat')) {
                                $file = $request->file('file_surat');
                                $fileName = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $fileName); // Simpan file ke direktori yang diinginkan
                        
                                // Simpan nama file surat dalam database
                                $suratti->file_surat = $fileName;
                                $suratti->status = 'done'; // Ubah status menjadi 'done'
                                $suratti->save();
                            }
                            $suratti->save();
                            //dd($suratps);
                            // Redirect ke halaman yang sesuai setelah pembaruan
                            return redirect()->route('indexAntrianti')->with('success', 'Surat berhasil diperbarui.');
                            }
    
}

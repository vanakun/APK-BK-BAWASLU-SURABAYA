<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\AduanDpdRi;
use App\Models\AduanLog;
use App\Models\CalonDpdRi;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanDpdRiController extends Controller
{
    public function index()
    {
        $aduans = AduanDpdRi::all();
        return view('aduan.index', compact('aduans'));
    }

    public function create()
    {
         // Retrieve the active year
         $activeYear = TahunPemilihanAktif::first();
    
         // Initialize an empty collection for presiden
         $presiden = collect();
     
         // If there is an active year, retrieve the corresponding presiden data
         if ($activeYear) {
            $presiden = CalonDpdRi::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $presiden = collect();
        }
        return view('pages.user.aduan.dpd-ri.create',compact('presiden', 'activeYear'));
    }

    public function store(Request $request)
{
    // Validasi permintaan
    $request->validate([
        'jenis_atribut' => 'required|string|max:255',
        'nama_calon_dpd' => 'required|string|max:255',
        'lokasi_pemasangan' => 'required|string|max:255',
        'nama_jalan' => 'nullable|string|max:255',
       
        'tanggal_laporan' => 'required|date',
        'tanggal_akhir_ditertibkan' => 'required|date',
        'gambar_sebelum' => 'nullable|image|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('gambar_sebelum')) {
        $path = $request->file('gambar_sebelum')->store('uploads', 'public');
        $validatedData['gambar_sebelum'] = basename($path);
    }

    $lokasi_pemasangan = $request->lokasi_pemasangan;
    $userId = Auth::id();

    // Menyimpan data ke database
    $aduan = new AduanDpdRi([
        'jenis_atribut' => $request->jenis_atribut,
            'nama_calon_dpd' => $request->nama_calon_dpd,
            'lokasi_pemasangan' => $lokasi_pemasangan,
            'nama_jalan' => $request->nama_jalan, // Menambahkan nama_jalan ke dalam data aduan
            'tanggal_laporan' => $request->tanggal_laporan,
            'tanggal_akhir_ditertibkan' => $request->tanggal_akhir_ditertibkan,
            'gambar_sebelum' => $path,
            'user_id' => $userId, 
            'tahun_pemilihan_id'=> $request->tahun_pemilihan_id,
    ]);

    $aduan->save();

    AduanLog::create([
        'user_id' => auth()->user()->id,
        'aduan_id' => $aduan->id,
        'aduan_type' => AduanDpdRi::class,  // Tipe aduan, bisa diubah sesuai kebutuhan
    ]);

    return redirect()->route('tenagaahliDashboard')->with('success', 'Aduan berhasil ditambahkan.');
}


    public function show(AduanDpdRi $aduan)
    {
        return view('aduan.show', compact('aduan'));
    }

    public function edit(AduanDpdRi $aduan)
    {
        return view('aduan.edit', compact('aduan'));
    }

    public function update(Request $request, AduanDpdRi $aduan)
    {
        $validatedData = $request->validate([
            'status' => 'required',
            'jenis_atribut' => 'required|string|max:255',
            'nama_calon_dpd' => 'required|string|max:255',
            'lokasi_pemasangan' => 'required|string|max:255',
            'nama_jalan' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'tanggal_akhir_ditertibkan' => 'nullable|date',
            'keterangan' => 'required|string|max:255',
            'tanggal_penertiban' => 'nullable|date',
            'jenis_penertiban' => 'nullable|string|max:255',
            'gambar_sebelum' => 'nullable|image|max:2048',
            'gambar_sesudah' => 'nullable|image|max:2048',
            'user_id' => 'nullable|exists:users,id',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihan,id',
        ]);

        $aduan->update($validatedData);

        return redirect()->route('aduan.index')->with('success', 'Aduan updated successfully.');
    }

    public function destroy(AduanDpdRi $aduan)
    {
        $aduan->delete();
        return redirect()->route('aduan.index')->with('success', 'Aduan deleted successfully.');
    }

    public function indexAntrianDPD()
    {
        $aduandpdqueue = AduanDpdRi::where('status', 'queue')->paginate(10);
        
        $aduandpdproces = AduanDpdRi::where('status', 'proces')->paginate(10);

        $aduandpddone = AduanDpdRi::where('status', 'done')->paginate(10);
        return view('pages.admin.aduan-dpd.index', compact('aduandpddone','aduandpdqueue','aduandpdproces'));
    }

    public function insertqueuedpd($id)
    {
        $aduan = AduanDpdRi::findOrFail($id);
        return view('pages.admin.aduan-dpd.insertqueue', compact('aduan'));
    }

    public function updatequeuedpd(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'jenis_atribut' => 'required',
            'nama_calon_dpd' => 'required',
            'lokasi_pemasangan' => 'required',
            'nama_jalan' => 'required',
            
        ]);
    
        // Ambil data aduan berdasarkan ID
        $aduan = AduanDpdRi::findOrFail($id);
    
        // Update data aduan dengan data yang diterima dari formulir
        $aduan->update([
            'jenis_atribut' => $request->jenis_atribut,
            'nama_calon_dpd' => $request->nama_calon_dpd,
            'lokasi_pemasangan' => $request->lokasi_pemasangan,
            'nama_jalan' => $request->nama_jalan,
            'tanggal_laporan' => $request->tanggal_laporan,
            'tanggal_akhir_ditertibkan' => $request->tanggal_akhir_ditertibkan,
            'keterangan' => $request->keterangan,
            'status' => 'proces', // Mengubah status menjadi "done"
        ]);
    
        // Periksa apakah tanggal penertiban melewati tanggal akhir ditertibkan
    
        //dd($aduan);
        // Simpan perubahan pada data aduan
        $aduan->save();
    
        // Redirect ke halaman terkait atau sesuai kebutuhan
        return redirect()->route('indexAntriandpd');
    }

    public function editaduandpd($id)
    {
        $aduan = AduanDpdRi::findOrFail($id);
        return view('pages.admin.aduan-dpd.edit', compact('aduan'));
    }

    public function updateAduandpd(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'jenis_atribut' => 'required',
            'nama_calon_dpd' => 'required',
            'lokasi_pemasangan' => 'required',
            'nama_jalan' => 'required',
            'tanggal_penertiban' => 'required',
            'jenis_penertiban' => 'required',
        ]);
    
        // Ambil data aduan berdasarkan ID
        $aduan = AduanDpdRi::findOrFail($id);
    
        // Update data aduan dengan data yang diterima dari formulir
        $aduan->update([
            'jenis_atribut' => $request->jenis_atribut,
            'nama_calon_dpd' => $request->nama_calon_dpd,
            'lokasi_pemasangan' => $request->lokasi_pemasangan,
            'nama_jalan' => $request->nama_jalan,
            'tanggal_laporan' => $request->tanggal_laporan,
            'tanggal_akhir_ditertibkan' => $request->tanggal_akhir_ditertibkan,
            'keterangan' => $request->keterangan,
            'tanggal_penertiban' => $request->tanggal_penertiban,
            'jenis_penertiban' => $request->jenis_penertiban,
            'status' => 'done', // Mengubah status menjadi "done"
        ]);
    
        // Periksa apakah tanggal penertiban melewati tanggal akhir ditertibkan
        if ($request->tanggal_penertiban > $request->tanggal_akhir_ditertibkan) {
            // Jika ya, ubah keterangan menjadi "terlambat"
            $aduan->keterangan = 'terlambat';
        } 
    
        if ($request->tanggal_penertiban <= $request->tanggal_akhir_ditertibkan) {
            // Jika tidak, ubah status menjadi "done"
            $aduan->keterangan = 'sudah di tertibkan';
        }
        // Cek apakah gambar sebelum diunggah
        if ($request->hasFile('gambar_sebelum')) {
            // Simpan gambar sebelum yang baru diunggah
            $gambarSebelumPath = $request->file('gambar_sebelum')->store('uploads', 'public');
            // Update path gambar sebelum pada data aduan
            $aduan->gambar_sebelum = $gambarSebelumPath;
        }
    
        // Cek apakah gambar sesudah diunggah
        if ($request->hasFile('gambar_sesudah')) {
            // Simpan gambar sesudah yang baru diunggah
            $gambarSesudahPath = $request->file('gambar_sesudah')->store('uploads', 'public');
            // Update path gambar sesudah pada data aduan
            $aduan->gambar_sesudah = $gambarSesudahPath;
        }
    
        //dd($aduan);
        // Simpan perubahan pada data aduan
        $aduan->save();
    
        // Redirect ke halaman terkait atau sesuai kebutuhan
        return redirect()->route('indexAntriandpd');
    }

    public function cetak(Request $request)
    {
        $tahunPemilihan = $request->input('tahun_pemilihan_id');
        $aduans = AduanDpdRi::where('tahun_pemilihan_id', $tahunPemilihan)->get();
        return view('pages.admin.aduan-dpd.cetakpdf', compact('aduans', 'tahunPemilihan'));
    }

    
   
}
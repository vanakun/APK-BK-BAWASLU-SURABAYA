<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\PresidenWakilPresidenController;
use App\Http\Controllers\Controller;
use App\Models\AduanLog;
use App\Models\AduanPresidenWakilPresiden;
use App\Models\PresidenWakilPresiden;
use App\Models\TahunPemilihanAktif;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AduanPresidenWakilPresidenController extends Controller
{
    public function index()
    {
        $aduan = AduanPresidenWakilPresiden::paginate(10);
        return view('admin.aduan_presiden_wakil_presiden.index', compact('aduan'));
    }

    public function indexAntrianPresidenwakil()
    {
        $aduanPresidenWakilqueue = AduanPresidenWakilPresiden::where('status', 'queue')->paginate(10);
        
        $aduanPresidenWakilproces = AduanPresidenWakilPresiden::where('status', 'proces')->paginate(10);


        $aduanPresidenWakildone = AduanPresidenWakilPresiden::where('status', 'done')->paginate(10);
        return view('pages.admin.aduan-presiden-wakil.indexadmin', compact('aduanPresidenWakildone','aduanPresidenWakilqueue','aduanPresidenWakilproces'));
    }

    public function editaduanpresidenwakil($id)
    {
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
        return view('pages.admin.aduan-presiden-wakil.editadmin', compact('aduan'));
    }

    public function insertqueuePresidenWakil($id)
    {
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
        return view('pages.admin.aduan-presiden-wakil.insertqueue', compact('aduan'));
    }

    public function updatepresidenwakil(Request $request, $id)
    {
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
        $aduan->update($request->all());

        return redirect()->route('aduanPresidenWakilPresiden.index')->with('success', 'Aduan updated successfully');
    }

    public function updateAduanPresidenWakil(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'jenis_atribut' => 'required',
            'nama_calon' => 'required',
            'lokasi_pemasangan' => 'required',
            'nama_jalan' => 'required',
            'tanggal_penertiban' => 'required',
            'jenis_penertiban' => 'required',
        ]);
    
        // Ambil data aduan berdasarkan ID
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
    
        // Update data aduan dengan data yang diterima dari formulir
        $aduan->update([
            'jenis_atribut' => $request->jenis_atribut,
            'nama_calon' => $request->nama_calon,
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
        return redirect()->route('indexAntrianPresidenwakil');
    }
    
    public function updatequeuePresidenWakil(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'jenis_atribut' => 'required',
            'nama_calon' => 'required',
            'lokasi_pemasangan' => 'required',
            'nama_jalan' => 'required',
            
        ]);
    
        // Ambil data aduan berdasarkan ID
        $aduan = AduanPresidenWakilPresiden::findOrFail($id);
    
        // Update data aduan dengan data yang diterima dari formulir
        $aduan->update([
            'jenis_atribut' => $request->jenis_atribut,
            'nama_calon' => $request->nama_calon,
            'lokasi_pemasangan' => $request->lokasi_pemasangan,
            'nama_jalan' => $request->nama_jalan,
            'tanggal_laporan' => $request->tanggal_laporan,
            'tanggal_akhir_ditertibkan' => $request->tanggal_akhir_ditertibkan,
            'keterangan' => $request->keterangan,
            'tanggal_penertiban' => $request->tanggal_penertiban,
            'jenis_penertiban' => $request->jenis_penertiban,
            'status' => 'proces', // Mengubah status menjadi "done"
        ]);
    
        // Periksa apakah tanggal penertiban melewati tanggal akhir ditertibkan
    
        //dd($aduan);
        // Simpan perubahan pada data aduan
        $aduan->save();
    
        // Redirect ke halaman terkait atau sesuai kebutuhan
        return redirect()->route('indexAntrianPresidenwakil');
    }
    


    public function create()
    {
        // Retrieve the active year
        $activeYear = TahunPemilihanAktif::first();
    
        // Initialize an empty collection for presiden
        $presiden = collect();
    
        // If there is an active year, retrieve the corresponding presiden data
        if ($activeYear) {
            $presiden = PresidenWakilPresiden::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $presiden = collect();
        }
    
        return view('pages.user.aduan.presiden-wakil.create', compact('presiden', 'activeYear'));
    }
    

    

    public function store(Request $request)
{
    // Validasi permintaan
    $request->validate([
        'jenis_atribut' => 'required',
        'nama_calon' => 'required',
        'lokasi_pemasangan' => 'required',
        'tanggal_laporan' => 'required|date',
        'tanggal_akhir_ditertibkan' => 'required|date',
        'gambar_sebelum' => 'nullable|file|image',
        'nama_jalan' => 'nullable', // Menambahkan validasi untuk nama_jalan
    ]);

    // Tangkap nilai lokasi_pemasangan dari request
    $lokasi_pemasangan = $request->lokasi_pemasangan;

    // Tangkap user_id dari objek pengguna saat ini
    $userId = Auth::id();

    // Handle file upload
    if ($request->hasFile('gambar_sebelum')) {
        $file = $request->file('gambar_sebelum');
        $path = $file->store('uploads', 'public');
    } else {
        $path = null;
    }

    // Buat instansiasi AduanPresidenWakilPresiden
    $aduan = new AduanPresidenWakilPresiden([
        'jenis_atribut' => $request->jenis_atribut,
        'nama_calon' => $request->nama_calon,
        'lokasi_pemasangan' => $lokasi_pemasangan,
        'nama_jalan' => $request->nama_jalan, // Menambahkan nama_jalan ke dalam data aduan
        'tanggal_laporan' => $request->tanggal_laporan,
        'tanggal_akhir_ditertibkan' => $request->tanggal_akhir_ditertibkan,
        'gambar_sebelum' => $path,
        'user_id' => $userId, 
        'tahun_pemilihan_id'=> $request->tahun_pemilihan_id,
    ]);

    // Simpan instansiasi ke database
    $aduan->save();

    // Buat log aduan setelah aduan disimpan ke database
    AduanLog::create([
        'user_id' => auth()->user()->id,
        'aduan_id' => $aduan->id,
        'aduan_type' => AduanPresidenWakilPresiden::class,  // Tipe aduan, bisa diubah sesuai kebutuhan
    ]);

    return redirect()->route('tenagaahliDashboard')->with('success', 'Aduan created successfully.');
}

    
    

    

    public function show(AduanPresidenWakilPresiden $aduanPresidenWakilPresiden)
    {
        return view('admin.aduan_presiden_wakil_presiden.show', compact('aduanPresidenWakilPresiden'));
    }

    public function edit(AduanPresidenWakilPresiden $aduanPresidenWakilPresiden)
    {
        return view('admin.aduan_presiden_wakil_presiden.edit', compact('aduanPresidenWakilPresiden'));
    }

    public function update(Request $request, AduanPresidenWakilPresiden $aduanPresidenWakilPresiden)
    {
        $request->validate([
            'status' => 'required',
            'jenis_atribut' => 'required',
            'jenis_pemilihan' => 'required',
            'nama_calon' => 'required',
            'lokasi_pemasangan' => 'required',
            'tanggal_laporan' => 'required|date',
            'tanggal_akhir_ditertibkan' => 'nullable|date',
            'keterangan' => 'required',
            'tanggal_penertiban' => 'nullable|date',
            'jenis_penertiban' => 'nullable|string',
            'gambar_sebelum' => 'nullable|string',
            'gambar_sesudah' => 'nullable|string',
        ]);

        $aduanPresidenWakilPresiden->update($request->all());

        return redirect()->route('aduan_presiden_wakil_presiden.index')
            ->with('success', 'Aduan updated successfully.');
    }

    public function destroy(AduanPresidenWakilPresiden $aduanPresidenWakilPresiden)
    {
        $aduanPresidenWakilPresiden->delete();

        return redirect()->route('aduan_presiden_wakil_presiden.index')
            ->with('success', 'Aduan deleted successfully.');
    }

    public function cetak(Request $request)
    {
        $tahunPemilihan = $request->input('tahun_pemilihan_id');
        $aduans = AduanPresidenWakilPresiden::where('tahun_pemilihan_id', $tahunPemilihan)->get();
        return view('pages.admin.aduan-presiden-wakil.cetakpdf', compact('aduans', 'tahunPemilihan'));
    }
}


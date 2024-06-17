<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\AduanDprdKabupaten;
use App\Models\AduanLog;
use App\Models\CalonDprdKota;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanDprdKabupatenController extends Controller
{
    public function index()
    {
        $aduans = AduanDprdKabupaten::all();
        return view('aduan_dprd_kabupaten.index', compact('aduans'));
    }

    public function create()
    {
         // Retrieve the active year
         $activeYear = TahunPemilihanAktif::first();
    
         // Initialize an empty collection for presiden
         $presiden = collect();
     
         // If there is an active year, retrieve the corresponding presiden data
         if ($activeYear) {
            $presiden = CalonDprdKota::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $presiden = collect();
        }
        $calonPartai = CalonDprdKota::with('partai')->get();
        //dd($calonPartai);
        return view('pages.user.aduan.dprd-kabupaten.create',compact('calonPartai','presiden', 'activeYear'));
    }

    public function store(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'jenis_atribut' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nama_partai' => 'required|string|max:255',
            'dapil' => 'required|string|max:255',
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
        $aduan = new AduanDprdKabupaten([
            'jenis_atribut' => $request->jenis_atribut,
                'nama' => $request->nama,
                'lokasi_pemasangan' => $lokasi_pemasangan,
                'nama_partai' => $request->nama_partai,
                'dapil' => $request->dapil,
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
            'aduan_type' => AduanDprdKabupaten::class,  // Tipe aduan, bisa diubah sesuai kebutuhan
        ]);
    
        return redirect()->route('tenagaahliDashboard')->with('success', 'Aduan berhasil ditambahkan.');
    }

    public function show(AduanDprdKabupaten $aduanDprdKabupaten)
    {
        return view('aduan_dprd_kabupaten.show', compact('aduanDprdKabupaten'));
    }

    public function edit(AduanDprdKabupaten $aduanDprdKabupaten)
    {
        return view('aduan_dprd_kabupaten.edit', compact('aduanDprdKabupaten'));
    }

    public function update(Request $request, AduanDprdKabupaten $aduanDprdKabupaten)
    {
        $request->validate([
            'status' => 'required|in:queue,proces,done',
            'jenis_atribut' => 'required|string',
            'jenis_pemilihan' => 'required|string',
            'nama' => 'required|string',
            'nama_partai' => 'required|string',
            'dapil' => 'required|string',
            'lokasi_pemasangan' => 'required|string',
            'nama_jalan' => 'nullable|string',
            'tanggal_laporan' => 'required|date',
            'tanggal_akhir_ditertibkan' => 'nullable|date',
            'keterangan' => 'required|in:belum di tertibkan,terlambat,sudah di tertibkan',
            'tanggal_penertiban' => 'nullable|date',
            'jenis_penertiban' => 'nullable|string',
            'gambar_sebelum' => 'nullable|string',
            'gambar_sesudah' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        $aduanDprdKabupaten->update($request->all());
        return redirect()->route('aduan-dprd-kabupaten.index')->with('success', 'Aduan updated successfully.');
    }

    public function destroy(AduanDprdKabupaten $aduanDprdKabupaten)
    {
        $aduanDprdKabupaten->delete();
        return redirect()->route('aduan-dprd-kabupaten.index')->with('success', 'Aduan deleted successfully.');
    }

    public function indexAntrianDprdKabupaten()
    {
        $aduandprdkabupatenqueue = AduanDprdKabupaten::where('status', 'queue')->paginate(10);
        
        $aduandprdkabupatenproces = AduanDprdKabupaten::where('status', 'proces')->paginate(10);

        $aduandprdkabupatendone = AduanDprdKabupaten::where('status', 'done')->paginate(10);
        return view('pages.admin.aduan-dprd-kabupaten.index', compact('aduandprdkabupatendone','aduandprdkabupatenqueue','aduandprdkabupatenproces'));
    }

    public function insertqueuedprdkabupaten($id)
    {
        $aduan = AduanDprdKabupaten::findOrFail($id);
        return view('pages.admin.aduan-dprd-kabupaten.insertqueue', compact('aduan'));
    }

    public function updatequeuedprdkabupaten(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'jenis_atribut' => 'required',
            'nama' => 'required',
            'nama_partai' => 'required',
            'lokasi_pemasangan' => 'required',
            'nama_jalan' => 'required',
            'dapil' => 'required',
            
        ]);
    
        // Ambil data aduan berdasarkan ID
        $aduan = AduanDprdKabupaten::findOrFail($id);
    
        // Update data aduan dengan data yang diterima dari formulir
        $aduan->update([
            'jenis_atribut' => $request->jenis_atribut,
            'nama' => $request->nama,
            'nama_partai' =>  $request->nama_partai,
            'dapil' => $request->dapil,
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
        return redirect()->route('indexAntrianDprdKabupaten');
        }
        public function editaduandprdkabupaten($id)
        {
        $aduan = AduanDprdKabupaten::findOrFail($id);
        return view('pages.admin.aduan-dprd-kabupaten.edit', compact('aduan'));
        }

        public function updateAduandprdkabupaten(Request $request, $id)
        {
            // Validasi data yang diterima dari formulir
            $validatedData = $request->validate([
                'jenis_atribut' => 'required',
                'nama' => 'required',
                'nama_partai' => 'required',
                'dapil' => 'required',
                'lokasi_pemasangan' => 'required',
                'nama_jalan' => 'required',
                'tanggal_penertiban' => 'required',
                'jenis_penertiban' => 'required',
            ]);
        
            // Ambil data aduan berdasarkan ID
            $aduan = AduanDprdKabupaten::findOrFail($id);
        
            // Update data aduan dengan data yang diterima dari formulir
            $aduan->update([
                'jenis_atribut' => $request->jenis_atribut,
                'nama' => $request->nama,
                'nama_partai' =>  $request->nama_partai,
                'dapil' =>  $request->dapil,
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
            return redirect()->route('indexAntrianDprdKabupaten');
        }

        public function cetak(Request $request)
    {
        $tahunPemilihan = $request->input('tahun_pemilihan_id');
        $aduans = AduanDprdKabupaten::where('tahun_pemilihan_id', $tahunPemilihan)->get();
        return view('pages.admin.aduan-dprd-kabupaten.cetakpdf', compact('aduans', 'tahunPemilihan'));
    }
    
}
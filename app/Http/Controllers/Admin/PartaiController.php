<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Partai;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;

class PartaiController extends Controller
{
    public function indexpartai(Request $request)
{
    $partai = Partai::query();
    $tahunPemilihans = TahunPemilihan::all();
    $tahunSelected = $request->query('tahun');
    
    if ($tahunSelected) {
        $partai->where('tahun_pemilihan_id', $tahunSelected);
    }
    
    $partai = $partai->paginate(5);

    // Append the selected year to pagination links
    $partai->appends(['tahun' => $tahunSelected]);
    
    return view('pages/admin/setting-pemilihan/partai/showpartai', compact('partai', 'tahunPemilihans', 'tahunSelected'));
}


    

    public function createpartai()
    {
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/partai/createpartai', compact('tahunPemilihans'));
    }

    public function storepartai(Request $request)
    {
        $validatedData= $request->validate([
                'nama_partai' => 'required|string|max:255',
                'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        $partai = Partai::create($validatedData);

        return redirect()->route('indexpartai');                
    }

    public function editpartai($id)
    {
        $partai = Partai::findOrFail($id);

        return view('pages/admin/setting-pemilihan/partai/editpartai', compact('partai'));
    }
    public function updatepartai(Request $request, $id)
    {
        // Validasi data yang dikirim dari formulir
        $validatedData = $request->validate([
            'nama_partai' => 'required|string|max:255',
        ]);

        // Temukan partai berdasarkan ID yang diberikan
        $partai = Partai::findOrFail($id);

        // Perbarui nama partai dengan data yang divalidasi
        $partai->nama_partai = $validatedData['nama_partai'];
        
        // Simpan perubahan ke database
        $partai->save();

        // Redirect ke halaman yang sesuai dengan pesan sukses
        return redirect()->route('indexpartai')->with('success', 'Partai berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Temukan partai berdasarkan ID yang diberikan
        $partai = Partai::findOrFail($id);

        // Hapus partai
        $partai->delete();

        // Redirect ke halaman yang sesuai dengan pesan sukses
        return redirect()->route('indexpartai')->with('success', 'Partai berhasil dihapus.');
    }
}

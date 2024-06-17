<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CalonDprRi;
use App\Models\Partai;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;

class CalonDprRiController extends Controller
{
    public function indexDprRi(Request $request)
    {
        $calons = CalonDprRi::query();
        $partais = Partai::all();
        $tahunPemilihans = TahunPemilihan::all();
        $tahunSelected = $request->query('tahun');
    
    if ($tahunSelected) {
        $calons->where('tahun_pemilihan_id', $tahunSelected);
    }
    $calons = $calons->paginate(5);

    $calons->appends(['tahun' => $tahunSelected]);

        //dd($calons);
        return view('pages/admin/setting-pemilihan/dpr-ri/show', compact('partais','calons','tahunPemilihans', 'tahunSelected'));
    }

    public function createDprRi()
    {
        $partais = Partai::all();
        $activeYear = TahunPemilihanAktif::first();

        if ($activeYear) {
            $partais = Partai::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $partais = collect();
        }
        $tahunPemilihans = TahunPemilihan::all();
       // dd($tahunPemilihans);
        return view('pages/admin/setting-pemilihan/dpr-ri/create', compact('partais', 'activeYear','tahunPemilihans'));
    }

    public function StoreDprRi(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'partai_id' => 'required|exists:partais,id',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);
//dd($validatedData);
        // Buat entitas CalonDprRi baru berdasarkan data yang divalidasi
        CalonDprRi::create($validatedData);

        // Redirect kembali ke halaman indeks dengan pesan sukses
        return redirect()->route('indexDprRi')->with('success', 'Calon DPR RI berhasil ditambahkan.');
    }

    public function editDprRI($id)
    {
        $calonDprRi = CalonDprRi::findOrFail($id);
        $partais = Partai::all();
        $activeYear = TahunPemilihanAktif::first();

        if ($activeYear) {
            $partais = Partai::whereHas('tahunPemilihan', function($query) use ($activeYear) {
                $query->where('tahun_pemilihan', $activeYear->tahun_pemilihan_aktif);
            })->get();
        } else {
            $partais = collect();
        }
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/dpr-ri/edit', compact('calonDprRi','partais', 'activeYear','tahunPemilihans'));
    }

    public function destroy($id)
    {
        $calonDprRi = CalonDprRi::findOrFail($id);
        $calonDprRi->delete();

        return redirect()->route('indexDprRi')
                         ->with('success','Calon DPR RI deleted successfully.');
    }

    public function updateDprRi(Request $request, $id)
{
    // Validasi data yang diterima dari formulir
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'partai_id' => 'required|exists:partais,id',
        'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
    ]);

    // Temukan entitas CalonDprRi berdasarkan ID
    $calonDprRi = CalonDprRi::findOrFail($id);

    // Perbarui data calonDprRi dengan data yang divalidasi
    $calonDprRi->update($validatedData);

    // Redirect kembali ke halaman indeks dengan pesan sukses
    return redirect()->route('indexDprRi')->with('success', 'Calon DPR RI berhasil diperbarui.');
}


}

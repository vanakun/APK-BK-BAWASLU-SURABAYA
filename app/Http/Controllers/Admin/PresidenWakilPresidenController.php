<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AduanLog;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;
use App\Models\PresidenWakilPresiden;

class PresidenWakilPresidenController extends Controller
{
    public function indexPresiden(Request $request)
{
    $presidenWakilPresiden = PresidenWakilPresiden::query();
    $tahunPemilihans = TahunPemilihan::all();
    $tahunSelected = $request->query('tahun');
    
    if ($tahunSelected) {
        $presidenWakilPresiden->where('tahun_pemilihan_id', $tahunSelected);
    }

    $presidenWakilPresiden = $presidenWakilPresiden->paginate(5);

    $presidenWakilPresiden->appends(['tahun' => $tahunSelected]);

    return view('pages/admin/setting-pemilihan/presiden/showpresiden', compact('presidenWakilPresiden', 'tahunPemilihans', 'tahunSelected'));
}


    public function createPresiden()
    {
        $tahunPemilihans = TahunPemilihan::all();
      
        return view('pages/admin/setting-pemilihan/presiden/createpresiden',compact('tahunPemilihans'));
    }

    public function storePresiden(Request $request)
    {
        $validatedData = $request->validate([
            'nama_presiden' => 'required|string|max:255',
            'nama_wakil' => 'required|string|max:255',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);
    
        // Buat data Presiden dan Wakil Presiden
        $presiden = new PresidenWakilPresiden();
        $presiden->nama_presiden = $validatedData['nama_presiden'];
        $presiden->nama_wakil = $validatedData['nama_wakil'];
        $presiden->tahun_pemilihan_id = $validatedData['tahun_pemilihan_id'];
        $presiden->save();
    
    
        return redirect()->route('indexPresiden')
                         ->with('success', 'Presiden dan Wakil Presiden berhasil ditambahkan.');
    }
    

    public function editPresiden($id)
{
    $presidenWakilPresiden = PresidenWakilPresiden::findOrFail($id);
    return view('pages/admin/setting-pemilihan/presiden/editpresiden', compact('presidenWakilPresiden'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_presiden' => 'required|string|max:255',
            'nama_wakil' => 'required|string|max:255',
        ]);

        $presidenWakilPresiden = PresidenWakilPresiden::findOrFail($id);
        $presidenWakilPresiden->update($request->all());

        return redirect()->route('indexPresiden')
                         ->with('success', 'Presiden dan Wakil Presiden berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $presidenWakilPresiden = PresidenWakilPresiden::findOrFail($id);
        $presidenWakilPresiden->delete();

        return redirect()->route('indexPresiden')
                         ->with('success', 'Presiden dan Wakil Presiden berhasil dihapus.');
    }
}

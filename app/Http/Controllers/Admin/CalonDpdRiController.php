<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CalonDpdRi;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;

class CalonDpdRiController extends Controller
{
    public function index(Request $request)
    {
        $tahunPemilihans = TahunPemilihan::all();
        $tahunSelected = $request->query('tahun');
    
        $calonDpdRis = CalonDpdRi::query();
    
        if ($tahunSelected) {
            $calonDpdRis->where('tahun_pemilihan_id', $tahunSelected);
        }
    
        $calonDpdRis = $calonDpdRis->paginate(5);
    
        // Appends query string parameters to pagination links
        $calonDpdRis->appends(['tahun' => $tahunSelected]);
    
        return view('pages/admin/setting-pemilihan/dpd-ri/index', compact('calonDpdRis', 'tahunPemilihans', 'tahunSelected'));
    }
    

    public function create()
    {
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/dpd-ri/create', compact('tahunPemilihans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_calon_dpd' => 'required',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        CalonDpdRi::create($request->all());

        return redirect()->route('calon_dpd_ri.index')->with('success', 'Calon DPD RI created successfully.');
    }

   

    public function edit($id)
    {
        $calonDpdRi = CalonDpdRi::findOrFail($id);
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/dpd-ri/edit', compact('calonDpdRi', 'tahunPemilihans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_calon_dpd' => 'required',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        $calonDpdRi = CalonDpdRi::findOrFail($id);
        $calonDpdRi->update($request->all());

        return redirect()->route('calon_dpd_ri.index')->with('success', 'Calon DPD RI updated successfully.');
    }

    public function destroy($id)
    {
        $calonDpdRi = CalonDpdRi::findOrFail($id);
        $calonDpdRi->delete();

        return redirect()->route('calon_dpd_ri.index')->with('success', 'Calon DPD RI deleted successfully.');
    }
}

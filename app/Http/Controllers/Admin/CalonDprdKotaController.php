<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonDprdKota;
use App\Models\Partai;
use App\Models\TahunPemilihan;
use Illuminate\Http\Request;

class CalonDprdKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $calonDprdKotas = CalonDprdKota::query(); // Use query() method on the CalonDprdProvinsi model
        $partais = Partai::all();
        $tahunPemilihans = TahunPemilihan::all();
        $tahunSelected = $request->query('tahun');
    
        if ($tahunSelected) {
            $calonDprdKotas->where('tahun_pemilihan_id', $tahunSelected);
        }
        $calonDprdKotas = $calonDprdKotas->paginate(5);
    
        $calonDprdKotas->appends(['tahun' => $tahunSelected]);

        
        return view('pages/admin/setting-pemilihan/dprd-kota/index', compact('partais','calonDprdKotas','tahunPemilihans', 'tahunSelected'));
    }
    
    public function create()
    {
        $partais = Partai::all();
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/dprd-kota/create', compact('partais', 'tahunPemilihans'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_calon_dprd_kota' => 'required',
            'partai_id' => 'required',
            'tahun_pemilihan_id' => 'required',
            'dapil' => 'nullable',
        ]);
    
        CalonDprdKota::create($request->all());
    
        return redirect()->route('calon-dprd-kota.index')
                        ->with('success','Calon DPRD Kota created successfully.');
    }
    
    public function show(CalonDprdKota $calonDprdKota)
    {
        return view('calon_dprd_kota.show',compact('calonDprdKota'));
    }
    
    public function edit(CalonDprdKota $calonDprdKota)
    {
        return view('admin.calon_dprd_kota.edit',compact('calonDprdKota'));
    }
    
    public function update(Request $request, CalonDprdKota $calonDprdKota)
    {
        $request->validate([
            'nama_calon_dprd_kota' => 'required',
            'partai_id' => 'required',
            'tahun_pemilihan_id' => 'required',
            'dapil' => 'nullable',
        ]);
    
        $calonDprdKota->update($request->all());
    
        return redirect()->route('calon-dprd-kota.index')
                        ->with('success','Calon DPRD Kota updated successfully');
    }
    
    public function destroy(CalonDprdKota $calonDprdKota)
    {
        $calonDprdKota->delete();
    
        return redirect()->route('calon-dprd-kota.index')
                        ->with('success','Calon DPRD Kota deleted successfully');
    }
    
}

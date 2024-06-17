<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CalonDprdProvinsi;
use App\Models\Partai;
use App\Models\TahunPemilihan;
use App\Models\TahunPemilihanAktif;
use Illuminate\Http\Request;

class CalonDprdProvinsiController extends Controller
{

    public function index(Request $request)
    {
        $calonDprdProvinsis = CalonDprdProvinsi::query(); // Use query() method on the CalonDprdProvinsi model
        $partais = Partai::all();
        $tahunPemilihans = TahunPemilihan::all();
        $tahunSelected = $request->query('tahun');
    
        if ($tahunSelected) {
            $calonDprdProvinsis->where('tahun_pemilihan_id', $tahunSelected);
        }
        $calonDprdProvinsis = $calonDprdProvinsis->paginate(5);
    
        $calonDprdProvinsis->appends(['tahun' => $tahunSelected]);
    
        return view('pages/admin/setting-pemilihan/dprd-provinsi/index', compact('partais','calonDprdProvinsis','tahunPemilihans', 'tahunSelected'));
    }
    

    public function create()
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
        return view('pages/admin/setting-pemilihan/dprd-provinsi/create', compact('partais', 'activeYear','tahunPemilihans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_calon_dprd' => 'required',
            'partai_id' => 'required|exists:partais,id',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        CalonDprdProvinsi::create($request->all());

        return redirect()->route('calon_dprd_provinsi.index')->with('success', 'Calon DPRD Provinsi created successfully.');
    }

    public function show($id)
    {
        $calonDprdProvinsi = CalonDprdProvinsi::with('partai', 'tahunPemilihan')->findOrFail($id);
        return view('calon_dprd_provinsi.show', compact('calonDprdProvinsi'));
    }

    public function edit($id)
    {
        $calonDprdProvinsi = CalonDprdProvinsi::findOrFail($id);
        $partais = Partai::all();
        $tahunPemilihans = TahunPemilihan::all();
        return view('pages/admin/setting-pemilihan/dprd-provinsi/edit', compact('calonDprdProvinsi', 'partais', 'tahunPemilihans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_calon_dprd' => 'required',
            'partai_id' => 'required|exists:partais,id',
            'tahun_pemilihan_id' => 'required|exists:tahun_pemilihans,id',
        ]);

        $calonDprdProvinsi = CalonDprdProvinsi::findOrFail($id);
        $calonDprdProvinsi->update($request->all());

        return redirect()->route('calon_dprd_provinsi.index')->with('success', 'Calon DPRD Provinsi updated successfully.');
    }

    public function destroy($id)
    {
        $calonDprdProvinsi = CalonDprdProvinsi::findOrFail($id);
        $calonDprdProvinsi->delete();

        return redirect()->route('calon_dprd_provinsi.index')->with('success', 'Calon DPRD Provinsi deleted successfully.');
    }
}

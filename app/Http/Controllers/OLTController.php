<?php

namespace App\Http\Controllers;

use App\Models\OLT;
use Illuminate\Http\Request;

class OLTController extends Controller
{
    public function index(){
        $olts = OLT::where('unique_id', auth()->user()->unique_id)->get();
        return view('Dashboard.OLT.index', compact('olts'));
    }
    public function tambaholt(Request $req){
        $ipolt = $req->input('ipolt');
        $site = $req->input('site');
       
        $unique_id = auth()->user()->unique_id;

        try {
            // Assuming Mikrotik::create() method exists
            $data = OLT::create([
                'ipolt' => $ipolt,
                'site' => $site,
               
                'unique_id' => $unique_id
            ]);

            session()->flash('success', "OLT Site ".$site." Berhasil Di Tambahkan");
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data: ' . $e->getMessage(),
            ]);
        }
    }
    public function aksesOLT(Request $request)
    {
        $ipolt = $request->query('ipolt');
        return view('Dashboard.OLT.olt-akses', compact('ipolt'));
    }
    public function update(Request $request)
    {
      // Validasi input
    $validatedData = $request->validate([
        'id' => 'required|exists:olt,id', // Memastikan ID ada di tabel 'olts'
        'ipolt' => 'required|ip', // Memvalidasi bahwa ipolt adalah alamat IP yang valid
        'site' => 'required|string|max:255', // Memvalidasi bahwa site adalah string dan maksimal 255 karakter
    ]);
    dd($validatedData);
    // Mencari data OLT berdasarkan ID
    $olt = OLT::findOrFail($validatedData['id']);

    // Memperbarui data OLT dengan data baru yang valid
    $olt->ipolt = $validatedData['ipolt'];
    $olt->site = $validatedData['site'];
    $olt->save(); // Simpan perubahan ke database

    // Redirect ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Data OLT berhasil diperbarui!');
    }
}

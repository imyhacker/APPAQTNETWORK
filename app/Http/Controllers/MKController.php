<?php

namespace App\Http\Controllers;

use App\Models\Mikrotik;
use RouterOS\Query;
use RouterOS\Client;
use Illuminate\Http\Request;

class MKController extends Controller
{
    public function index(){

        $mikrotik = Mikrotik::all();
        return view('Dashboard.MIKROTIK.index', compact('mikrotik'));
    }
    public function tambahmikrotik(Request $req){
        $ipmikrotik = $req->input('ipmikrotik');
        $site = $req->input('site');
        $username = $req->input('username');
        $password = $req->input('password');
        $unique_id = auth()->user()->unique_id;

        try {
            // Assuming Mikrotik::create() method exists
            $data = Mikrotik::create([
                'ipmikrotik' => $ipmikrotik,
                'site' => $site,
                'username' => $username,
                'password' => $password,
                'unique_id' => $unique_id
            ]);

            session()->flash('success', "Mikrotik Site ".$site." Berhasil Di Tambahkan");
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data: ' . $e->getMessage(),
            ]);
        }
    }
    public function aksesMikrotik(Request $request)
{
    $ipmikrotik = $request->query('ipmikrotik');
    $username = $request->query('username');
    $password = $request->query('password');

    try {
        // Example of accessing the MikroTik router using an API or SSH
        $connection = new Client([
            'host' => $ipmikrotik,
            'user' => $username,
            'pass' => $password,
        ]);

        
        // If connection is successful, you can perform additional actions here

        session()->flash('success', 'Mikrotik Terhubung');
        return redirect()->back();
    } catch (\Exception $e) {
        session()->flash('error', 'Failed to connect to MikroTik router: ' . $e->getMessage());
        return redirect()->back();
    }
}
public function edit($id)
    {
        $mikrotik = Mikrotik::find($id);
        if (!$mikrotik) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($mikrotik);
    }
 public function update(Request $request, $id)
    {
        $request->validate([
            'ipmikrotik' => 'required|ip',
            'site' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $mikrotik = Mikrotik::find($id);
        if ($mikrotik) {
            $mikrotik->ipmikrotik = $request->input('ipmikrotik');
            $mikrotik->site = $request->input('site');
            $mikrotik->username = $request->input('username');
            $mikrotik->password = $request->input('password');
            $mikrotik->save();

            return redirect()->back()->with('success', 'MikroTik updated successfully.');
        }

        return redirect()->back()->with('error', 'MikroTik not found.');
    }
    public function destroy($id)
    {
        $mikrotik = Mikrotik::find($id);
        if ($mikrotik) {
            $mikrotik->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }
}

<?php

namespace App\Http\Controllers;

use RouterOS\Query;
use RouterOS\Client;
use App\Models\Mikrotik;
use Illuminate\Http\Request;

class IPController extends Controller
{
    public function nighbore(){
        $data = Mikrotik::where('unique_id', auth()->user()->unique_id)->get();
        return view('Dashboard/IP/nighbore', compact('data'));
    }
    public function aksesnightbore(Request $request)
    {
        $ipmikrotik = $request->query('ipmikrotik');

    // Cek apakah IP Mikrotik valid di database
    $mikrotik = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
    
    if (!$mikrotik) {
        return redirect()->back()->with('error', 'Mikrotik dengan IP tersebut tidak ditemukan.');
    }

    // Ambil username dan password dari database (atau hardcode jika diperlukan)
    $username = $mikrotik->username; // Asumsi ada field username
    $password = $mikrotik->password; // Asumsi ada field password

    // Konfigurasi koneksi MikroTik
    $config = [
        'host' => $ipmikrotik,
        'user' => $username,
        'pass' => $password,
        'port' => 8714
    ];

    try {
        // Membuat koneksi dengan MikroTik
        $client = new Client($config);

        // Query untuk mendapatkan neighbor dari MikroTik
        $query = (new Query('/ip/neighbor/print')); // Menggunakan neighbor command
        $response = $client->query($query)->read();
        //dd($response);
        // Jika neighbor ditemukan, arahkan ke view dan tampilkan hasil
       return view('Dashboard.IP.aksesnighbore', compact('response'));
    } catch (\Exception $e) {
        // Jika ada error saat koneksi ke MikroTik
        return redirect()->back()->with('error', 'Error connecting to MikroTik: ' . $e->getMessage());
    }

    }
    
}

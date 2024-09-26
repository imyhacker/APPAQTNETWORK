<?php

namespace App\Http\Controllers;

use App\Models\VPN;
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

      
         $datavpn = VPN::where('ipaddress', $mikrotik->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();

        //dd($datavpn);
         if (!$mikrotik) {
             return redirect()->back()->with('error', 'Mikrotik dengan IP tersebut tidak ditemukan.');
        }

    // Ambil username dan password dari database (atau hardcode jika diperlukan)
        $username = $mikrotik->username; // Asumsi ada field username
        $password = $mikrotik->password; // Asumsi ada field password

    // Konfigurasi koneksi MikroTik
        $config = [
        'host' => 'id-1.aqtnetwork.my.id:'.$datavpn->portapi,
        'user' => $username,
        'pass' => $password,
       // 'port' => 8714
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
    public function aksessecret(Request $request) {
        $ipmikrotik = $request->query('ipmikrotik');
        
        // Cek apakah IP Mikrotik valid di database
        $mikrotik = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
        
        if (!$mikrotik) {
            return redirect()->back()->with('error', 'Mikrotik dengan IP tersebut tidak ditemukan.');
        }
        
        // Ambil data VPN berdasarkan IP dan user unik
        $datavpn = VPN::where('ipaddress', $mikrotik->ipmikrotik)
            ->where('unique_id', auth()->user()->unique_id)
            ->first();
        
        if (!$datavpn) {
            return redirect()->back()->with('error', 'Data VPN tidak ditemukan untuk IP ini.');
        }
    
        // Ambil username dan password dari database
        $username = $mikrotik->username;
        $password = $mikrotik->password;
    
        // Konfigurasi koneksi MikroTik
        $config = [
            'host' => 'id-1.aqtnetwork.my.id:' . $datavpn->portapi,
            'user' => $username,
            'pass' => $password,
        ];
    
        // Inisialisasi koneksi ke MikroTik menggunakan RouterOS-PHP
        try {
            // Membuat koneksi dengan MikroTik
            $client = new \RouterOS\Client([
                'host' => $config['host'],
                'user' => $config['user'],
                'pass' => $config['pass'],
                'port' => $datavpn->portapi,
            ]);
    
            // Kirim perintah untuk mengambil PPP secrets
            $query = new \RouterOS\Query('/ppp/secret/print');
            $secrets = $client->query($query)->read();
    
            // Mengirim data secrets ke view
            return view('Dashboard.IP.aksessecret', compact('secrets'));
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke MikroTik: ' . $e->getMessage());
        }
    }
    
    
}

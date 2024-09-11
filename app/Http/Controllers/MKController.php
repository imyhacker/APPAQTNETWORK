<?php

namespace App\Http\Controllers;

use App\Models\Mikrotik;
use App\Models\VPN;
use RouterOS\Query;
use RouterOS\Client;
use Illuminate\Http\Request;

class MKController extends Controller
{
    public function index(){

        $mikrotik = Mikrotik::where('unique_id', auth()->user()->unique_id)->get();
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

    //  DATA DASAR MIKROTIK
    public function aksesMikrotik(Request $request)
{
   
    $ipmikrotik = $request->query('ipmikrotik');
    $username = $request->query('username');
    $password = $request->query('password');

    $dataport = VPN::where('ipaddress', $ipmikrotik)->first();

    if(is_null($dataport)) {
        // Handle case when there is no data for the IP address in the database
        try {
            // Attempt to connect using default MikroTik IP without port information
            $connection = new Client([
                'host' => $ipmikrotik,
                'user' => $username,
                'pass' => $password,
            ]);
            
            // If connection is successful
            session()->flash('success', 'Mikrotik Terhubung');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to connect to MikroTik router : ' . $e->getMessage());
            return redirect()->back();
        }
    } else {
        // Case where database entry exists for the IP
        if(is_null($dataport->portapi) == false){
            try {
                // Connect with port information from the database
                $connection = new Client([
                    'host' => 'id-1.aqtnetwork.my.id:'.$dataport->portapi,
                    'user' => $username,
                    'pass' => $password,
                ]);
    
                // If connection is successful
                session()->flash('success', 'Mikrotik Terhubung');
                return redirect()->back();
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to connect to MikroTik router :  ' . $e->getMessage());
                return redirect()->back();
            }
        } else {
            try {
                // Connect using the IP without port information
                $connection = new Client([
                    'host' => $ipmikrotik,
                    'user' => $username,
                    'pass' => $password,
                ]);
    
                // If connection is successful
                session()->flash('success', 'Mikrotik Terhubung tanpa port dari database');
                return redirect()->back();
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to connect to MikroTik router: ' . $e->getMessage());
                return redirect()->back();
            }
        }
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
    public function masukmikrotik(Request $request)
    {
    // Ambil data MikroTik dari database berdasarkan parameter 'ipmikrotik'
    $ipmikrotik = $request->input('ipmikrotik');
    $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
    
    // Cek apakah data MikroTik ditemukan
    if (!$data) {
        return redirect()->back()->with('error', 'MikroTik data not found.');
    }
    
    $username = $data->username; // Ambil username dari database
    $password = $data->password; // Ambil password dari database
    $site = $data->site;

    // Cek data VPN berdasarkan IP address yang diberikan
    $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->first();
    
    // Set 'portweb' dari input request atau data VPN (jika ada)
    $portweb = $request->input('portweb') ?? ($datavpn->portweb ?? null);
    // Set 'portapi' dari data VPN jika tersedia
    $portapi = $datavpn->portapi ?? null;

    // Membangun konfigurasi koneksi berdasarkan data yang ada
    if (is_null($portapi)) {
        // Jika 'portapi' tidak ditemukan, gunakan IP publik dan port default
        return redirect()->back()->with('error', 'Untuk Masuk Ke Mikrotik Harus Melalui Jaringan VPN Yang Kami Sediakan');

    } else {
        // Jika data VPN ditemukan, gunakan 'portapi' dari VPN
        $config = [
            'host' => 'id-1.aqtnetwork.my.id:' . $portapi, // Menggunakan domain VPN dan port API dari data VPN
            'user' => $username,
            'pass' => $password,
        ];

        // Sertakan 'portweb' jika ada
        if ($portweb) {
            $config['port'] = $portweb;
        }
    }

    try {
        // Koneksi ke MikroTik menggunakan konfigurasi yang telah dibuat
        $client = new Client($config);
        $query = (new Query('/ppp/active/print'));
        $response = $client->query($query)->read();
        
        // Set variabel session untuk menandai bahwa koneksi berhasil
        session([
            'mikrotik_connected' => true, 
            'ipmikrotik' => $ipmikrotik, 
            'portapi' => $portapi
        ]);

        // Hapus session 'session_disconnected' jika ada
        session()->forget('session_disconnected');

        // Arahkan ke halaman dashboardmikrotik setelah berhasil terkoneksi
        return redirect()->route('dashboardmikrotik', ['ipmikrotik' => $ipmikrotik]);
    } catch (\Exception $e) {
        // Jika terjadi error saat koneksi, hapus session dan tampilkan pesan error
        session()->forget('mikrotik_connected');
        session(['session_disconnected' => true]);

        return redirect()->back()->with('error', 'Error connecting to MikroTik: ' . $e->getMessage());
    }
    }

    
    public function keluarmikrotik(Request $request)
    {
        // Clear MikroTik session variables
        $request->session()->forget(['mikrotik_connected', 'session_disconnected']);
    
        // Redirect to login or another page
        return redirect()->route('datamikrotik')->with('success', 'Berhasil Logout');
    }

    
    /////////////////////////////
    public function dashboardmikrotik(Request $request)
    {
        $ipmikrotik = $request->input('ipmikrotik');
        
        // Ambil data MikroTik berdasarkan IP
        $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
        $totalvpn = VPN::where('unique_id', auth()->user()->unique_id)->count();
        $totalmikrotik = Mikrotik::where('unique_id', auth()->user()->unique_id)->count();
        $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
        $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
        
        // Set 'portweb' dari input request atau data VPN (jika ada)
        $portweb = $request->input('portweb') ?? ($datavpn->portweb ?? null);
        // Set 'portapi' dari data VPN jika tersedia
        $portapi = $datavpn->portapi ?? null;

        $config = [
            'host' => 'id-1.aqtnetwork.my.id:' . $portapi, // Menggunakan domain VPN dan port API dari data VPN
            'user' => $data->username,
            'pass' => $data->password,
        ];



        $client = new Client($config);

        // Query untuk mendapatkan data secret di PPP
        $query = (new Query('/ppp/secret/print'));
        $response = $client->query($query)->read();
        
        $totaluser = count($response);

        $query2 = (new Query('/ppp/active/print'));
        $response2 = $client->query($query2)->read();
        
        $totalactive = count($response2);

        if (!$data) {
            return redirect()->back()->with('error', 'MikroTik data not found.');
       }

       
   // Ambil informasi lain yang dibutuhkan untuk ditampilkan di dashboard
         $site = $data->site;
         $username = $data->username;
   
   // Tampilkan dashboard dengan data yang relevan
         return view('Dashboard.MIKROTIK.dashboardmikrotik', compact('ipmikrotik', 'site', 'username', 'totalvpn', 'totalmikrotik', 'totaluser', 'totalactive'));
    }
    


    public function getCpuLoad($ipmikrotik, Request $request)
    {
        // Ambil data MikroTik berdasarkan IP
        $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
        $totalvpn = VPN::where('unique_id', auth()->user()->unique_id)->count();
        $totalmikrotik = Mikrotik::where('unique_id', auth()->user()->unique_id)->count();
        $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
        
        // Set 'portweb' dari input request atau data VPN (jika ada)
        $portweb = $request->input('portweb') ?? ($datavpn->portweb ?? null);
        // Set 'portapi' dari data VPN jika tersedia
        $portapi = $datavpn->portapi ?? null;
    
        try {
            // Membuat koneksi ke MikroTik API menggunakan IP dari parameter URL
            $client = new Client([
                'host' => 'id-1.aqtnetwork.my.id:' . $portapi, // Menggunakan domain VPN dan port API dari data VPN
            'user' => $data->username,
            'pass' => $data->password,
            ]);
    
            // Query untuk mengambil CPU dari MikroTik
            $queryCPU = (new Query('/system/resource/print'));
            $responseCPU = $client->query($queryCPU)->read();
    
            // Memeriksa dan mengambil data dari response
            if (!empty($responseCPU)) {
                $cpuLoad = isset($responseCPU[0]['cpu-load']) ? $responseCPU[0]['cpu-load'] . '%' : 'N/A';
    
                // Mengirim data sebagai JSON
                return response()->json(['cpuLoad' => $cpuLoad]);
            }
    
            return response()->json(['cpuLoad' => 'N/A']);
        } catch (\Exception $e) {
            return response()->json(['cpuLoad' => 'Error']);
        }
    }
    
    public function getCurrentTime($ipmikrotik, Request $request)
    {


        $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
        $totalvpn = VPN::where('unique_id', auth()->user()->unique_id)->count();
        $totalmikrotik = Mikrotik::where('unique_id', auth()->user()->unique_id)->count();
        $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
        
        // Set 'portweb' dari input request atau data VPN (jika ada)
        $portweb = $request->input('portweb') ?? ($datavpn->portweb ?? null);
        // Set 'portapi' dari data VPN jika tersedia
        $portapi = $datavpn->portapi ?? null;
        try {
            // Membuat koneksi ke MikroTik API menggunakan IP dari parameter URL
            $client = new Client([
                'host' => 'id-1.aqtnetwork.my.id:' . $portapi, // Menggunakan domain VPN dan port API dari data VPN
            'user' => $data->username,
            'pass' => $data->password,
            ]);
            // Query untuk mengambil waktu dari MikroTik
            $queryDateTime = (new Query('/system/clock/print'));
            $responseDateTime = $client->query($queryDateTime)->read();
    
            // Memeriksa dan mengambil data dari response
            if (!empty($responseDateTime)) {
                $date = isset($responseDateTime[0]['date']) ? $responseDateTime[0]['date'] : 'N/A';
                $time = isset($responseDateTime[0]['time']) ? $responseDateTime[0]['time'] : 'N/A';
    
                // Mengirim data sebagai JSON
                return response()->json(['date' => $date, 'time' => $time]);
            }
    
            return response()->json(['date' => 'N/A', 'time' => 'N/A']);
        } catch (\Exception $e) {
            return response()->json(['date' => 'Error', 'time' => 'Error']);
        }
    }
    






    public function getActiveConnection(Request $request)
    {

        $data = Mikrotik::where('ipmikrotik', $request->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
    
        // Cek apakah data MikroTik ditemukan
        if (!$data) {
            return redirect()->back()->with('error', 'MikroTik data not found.');
        }
       // dd($data);
        $username = $data->username; // Ambil username dari database
        $password = $data->password; // Ambil password dari database
        $site = $data->site;
    
        // Cek data VPN berdasarkan IP address yang diberikan
        $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->where('unique_id', auth()->user()->unique_id)->first();
        
        // Set 'portweb' dari input request atau data VPN (jika ada)
        $portweb = $request->input('portweb') ?? ($datavpn->portweb ?? null);
        // Set 'portapi' dari data VPN jika tersedia
        $portapi = $datavpn->portapi ?? null;
        //dd($portapi);
        //dd($portapi);
        // Membangun konfigurasi koneksi berdasarkan data yang ada
       
            // Jika data VPN ditemukan, gunakan 'portapi' dari VPN
            $config = [
                'host' => 'id-1.aqtnetwork.my.id:' . $portapi, // Menggunakan domain VPN dan port API dari data VPN
                'user' => $username,
                'pass' => $password,
            ];
    
        try {
            // Koneksi ke MikroTik menggunakan konfigurasi yang telah dibuat
            $client = new Client($config);
            $query = (new Query('/ppp/active/print'));
            $response = $client->query($query)->read();
            
            //dd($response);
          
            //dd($query);
            return view('Dashboard.MIKROTIK.active-connection', ['ipmikrotik' => $data->pmikrotik, 'response' => $response, 'portweb' => $portweb, 'portapi' => $portapi]);
            // Arahkan ke halaman dashboardmikrotik setelah berhasil terkoneksi
           // return redirect()->route('dashboardmikrotik', ['ipmikrotik' => $ipmikrotik]);
        } catch (\Exception $e) {
            // Jika terjadi error saat koneksi, hapus session dan tampilkan pesan error
           
            //dd($e->getMessage());
           return redirect()->back()->with('error', 'Error connecting to MikroTik: ' . $e->getMessage());
        }








        



        // ///// GENERATE
        // // Ambil parameter 'ipmikrotik' dari query string
        // $ipmikrotik = $request->query('ipmikrotik');

        // // Pastikan parameter 'ipmikrotik' ada
        // if (!$ipmikrotik) {
        //     return redirect()->back()->with('error', 'IP MikroTik tidak ditemukan.');
        // }

        // // Lanjutkan logika Anda, misalnya mengambil active connection dari MikroTik
        // // Sesuaikan dengan kebutuhan Anda
        // // Contoh: Mengambil data dari MikroTik API atau memproses logika lain

        // return view('Dashboard.MIKROTIK.active-connection', compact('ipmikrotik'));
    }
    public function addFirewallRule(Request $request)
    {
        $request->validate([
            'ipaddr' => 'required',
            'port' => 'required',
            'ipmikrotik' => 'required',
        ]);
    
        $ipAddress = $request->input('ipaddr');
        $port = $request->input('port');
        $ipMikrotik = $request->input('ipmikrotik');
    
        // Ambil data MikroTik berdasarkan IP
        $data = Mikrotik::where('ipmikrotik', $request->ipmikrotik)->first();
        
        // Cek apakah data MikroTik ditemukan
        if (!$data) {
            return redirect()->back()->with('error', 'MikroTik data not found.');
        }
    
        $username = $data->username;
        $password = $data->password;
        $site = $data->site;
    
        // Ambil data VPN terkait berdasarkan IP MikroTik
        $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->first();
    
        // Cek apakah data VPN ditemukan
        if (!$datavpn) {
            return redirect()->back()->with('error', 'VPN data not found.');
        }
    
        // Set 'portapi' dan 'portweb' dari data VPN
        $portapi = $datavpn->portapi ?? '8728'; // Default '8728' jika 'portapi' tidak ditemukan
        $portweb = $datavpn->portweb ?? '80'; // Default '80' jika 'portweb' tidak ditemukan
    
        try {
            // Konfigurasi client MikroTik API
            $config = [
                'host' => 'id-1.aqtnetwork.my.id:'.$portapi,
                'user' => $username,
                'pass' => $password,
            ];
    
            $client = new Client($config);
    
            // Periksa apakah ada aturan firewall NAT dengan port tertentu
            $query = (new Query('/ip/firewall/nat/print'))
                ->where('dst-port', $portweb);
            $existingRules = $client->query($query)->read();
    
            if (!empty($existingRules)) {
                // Update aturan NAT yang sudah ada
                $id = $existingRules[0]['.id'];
                $updateQuery = (new Query('/ip/firewall/nat/set'))
                    ->equal('.id', $id)
                    ->equal('dst-port', $portweb)
                    ->equal('to-addresses', $ipAddress)
                    ->equal('to-ports', $port);
    
                $client->query($updateQuery)->read();
    
            } else {
                // Tambahkan aturan NAT baru
                $addQuery = (new Query('/ip/firewall/nat/add'))
                    ->equal('chain', 'dstnat')
                    ->equal('protocol', 'tcp')
                    ->equal('dst-port', $portweb)
                    ->equal('action', 'dst-nat')
                    ->equal('to-addresses', $ipAddress)
                    ->equal('to-ports', $port)
                    ->equal('comment', 'Remote-web');
    
                $client->query($addQuery)->read();
            }
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function restartmodem(Request $request)
    {
        // Validate request data
        $request->validate([
            'ipaddr' => 'required|ip',
            'port' => 'required|numeric',
            'ipmikrotik' => 'required|ip',
        ]);
    
        $ipAddress = $request->input('ipaddr');
        $port = $request->input('port');
        $ipMikrotik = $request->input('ipmikrotik');
     // Ambil data MikroTik berdasarkan IP
     $data = Mikrotik::where('ipmikrotik', $request->ipmikrotik)->first();
        
     // Cek apakah data MikroTik ditemukan
     if (!$data) {
         return redirect()->back()->with('error', 'MikroTik data not found.');
     }
 
     $username = $data->username;
     $password = $data->password;
     $site = $data->site;
 
     // Ambil data VPN terkait berdasarkan IP MikroTik
     $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->first();
 
     // Cek apakah data VPN ditemukan
     if (!$datavpn) {
         return redirect()->back()->with('error', 'VPN data not found.');
     }
 
     // Set 'portapi' dan 'portweb' dari data VPN
     $portapi = $datavpn->portapi ?? '8728'; // Default '8728' jika 'portapi' tidak ditemukan
     $portweb = $datavpn->portweb ?? '80'; // Default '80' jika 'portw
        try {
            // MikroTik API client configuration
            $config = [
                'host' => 'id-1.aqtnetwork.my.id:'.$portapi,
                'user' => $username,
                'pass' => $password,
                'port' => 8728
            ];
    
            $client = new Client($config);
    
            // Get the list of active PPPoE connections
            $query = new Query('/ppp/active/print');
            $query->where('address', $ipAddress);
    
            $pppActiveConnections = $client->query($query)->read();
    
            if (count($pppActiveConnections) > 0) {
                $pppId = $pppActiveConnections[0]['.id'];
    
                // Remove the PPP active connection
                $removeQuery = new Query('/ppp/active/remove');
                $removeQuery->equal('.id', $pppId);
    
                $result = $client->query($removeQuery)->read();
    
                if (!isset($result['!trap'])) {
                    return response()->json(['success' => true, 'message' => 'PPPoE connection removed successfully.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to remove PPPoE connection: ' . $result['!trap'][0]['message']]);
                }
            } else {
                return response()->json(['success' => false, 'message' => "PPPoE connection with IP address '$ipAddress' not found."]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }   
}

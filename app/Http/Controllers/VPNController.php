<?php

namespace App\Http\Controllers;

use App\Models\VPN;
use RouterOS\Query;
use RouterOS\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class VPNController extends Controller
{
    public function index() {

        $user = auth()->user();
        
        $uniqueId = $user->unique_id;

        $data = VPN::where('unique_id', $uniqueId)->get(); 
        //dd($data);
        return view('Dashboard.VPN.index', compact('data'));
    }
    public function uploadvpn(Request $req){
        try {
            // Konfigurasi koneksi ke MikroTik
            $client = new Client([
                'host' => 'id-1.aqtnetwork.my.id',  // Alamat IP MikroTik
                'user' => 'admin',          // Username MikroTik
                'pass' => 'bakpao1922',       // Password MikroTik
            ]);
        
            // Data dari request
            $namaakun = $req->input('namaakun');
            $username = $req->input('username');
            $password = $req->input('password');
            $akuncomment = "AQT_" . $namaakun;
        
            // Mengambil semua PPP secrets untuk memeriksa nama pengguna yang sudah ada
            $queryAllSecrets = new Query('/ppp/secret/print');
            $response = $client->query($queryAllSecrets)->read();
        
            // Debugging: Tampilkan respon dari query
            \Log::info('Response from /ppp/secret/print:', $response);
        
            // Cek apakah nama pengguna sudah ada
            $existingUsernames = array_column($response, 'name');
            $originalUsername = $username;
            $increment = 1;
        
            while (in_array($username, $existingUsernames)) {
                // Tambahkan angka increment jika username sudah ada
                $username = $originalUsername . $increment;
                $increment++;
            }
        
            // Oktet yang tetap
            $firstOctet = '172';
            $secondOctet = 160;
        
            // Ambil daftar thirdOctet yang sudah digunakan
            $usedThirdOctets = array_map(function ($secret) {
                return explode('.', $secret['local-address'])[2];
            }, $response);
        
            // Tentukan thirdOctet yang baru
            $thirdOctetBase = 11;
            $thirdOctet = $thirdOctetBase;
            while (in_array($thirdOctet, $usedThirdOctets)) {
                $thirdOctet++;
                if ($thirdOctet > 254) {
                    throw new \Exception("No available third octet for IP addresses.");
                }
            }
        
            // Tentukan fourthOctet untuk lokal dan remote
            $existingCount = count($response);
            $fourthOctetLocal = 1 + ($existingCount % 255);
            $fourthOctetRemote = 10 + ($existingCount % 255); // Ubah sesuai kebutuhan
        
            // Generate IP addresses
            $localIp = "$firstOctet.$secondOctet.$thirdOctet.$fourthOctetLocal";
            $remoteIp = "$firstOctet.$secondOctet.$thirdOctet.$fourthOctetRemote";
        
            // Membuat query untuk menambahkan PPP secret
            $query = new Query('/ppp/secret/add');
            $query->equal('name', $username) // Menggunakan username yang sudah di-update
                  ->equal('password', $password)
                  ->equal('comment', $akuncomment)
                  ->equal('profile', 'IP-Tunnel-VPN')
                  ->equal('local-address', $localIp)
                  ->equal('remote-address', $remoteIp);
        
            // Eksekusi query
            $response = $client->query($query)->read();
        
            // Cek respon dari MikroTik
            if (isset($response['!trap'])) {
                // Terjadi kesalahan
                return response()->json(['error' => $response['!trap'][0]['message']], 400);
            } else {
                // Berhasil menambahkan PPP secret
                $unique = auth()->user();
                VPN::create([
                    'unique_id' => $unique->unique_id,
                    'namaakun' => $namaakun,
                    'username' => $username,
                    'password' => $password,
                    'ipaddress' => $localIp, // Storing local IP address
                ]);
        
                // Fetch existing NAT rules
                $queryAllNAT = new Query('/ip/firewall/nat/print');
                $natResponse = $client->query($queryAllNAT)->read();
                
                // Debugging: Tampilkan respon dari NAT query
                \Log::info('Response from /ip/firewall/nat/print:', $natResponse);
        
                // Cek jika response NAT tidak kosong dan ambil port yang digunakan
                $usedPorts = [];
                foreach ($natResponse as $natRule) {
                    if (isset($natRule['dst-port'])) {
                        $usedPorts[] = $natRule['dst-port'];
                    }
                }
        
                // Fetch API service port from MikroTik
                $queryAPIService = new Query('/ip/service/print');
                $apiResponse = $client->query($queryAPIService)->read();
                
                // Debugging: Tampilkan respon dari API service query
                \Log::info('Response from /ip/service/print:', $apiResponse);
        
                // Find the API port
                $apiPort = null;
                foreach ($apiResponse as $service) {
                    if (isset($service['name']) && $service['name'] == 'api') {
                        $apiPort = $service['port'];
                        break;
                    }
                }
        
                if ($apiPort === null) {
                    throw new \Exception("API service port not found.");
                }
        
                // Generate destination port starting from 1000
                $dstPort = 1000;
                while (in_array($dstPort, $usedPorts)) {
                    $dstPort++;
                    // Ensure the port does not exceed a reasonable range
                    if ($dstPort > 65535) {
                        throw new \Exception("No available destination port.");
                    }
                }
        
                // Create first NAT rule
                $natQuery1 = new Query('/ip/firewall/nat/add');
                $natQuery1->equal('chain', 'dstnat')
                          ->equal('protocol', 'tcp')
                          ->equal('dst-port', $dstPort)
                          ->equal('dst-address-list', 'ip-public')
                          ->equal('action', 'dst-nat')
                          ->equal('to-addresses', $remoteIp)
                          ->equal('to-ports', $apiPort) // Set to-ports to the fetched API port
                          ->equal('comment', $akuncomment . '_API');
        
                $natResponse1 = $client->query($natQuery1)->read();
        
                // Check response from MikroTik
                if (isset($natResponse1['!trap'])) {
                    return response()->json(['error' => $natResponse1['!trap'][0]['message']], 400);
                }
        
                // Increment the destination port by 10 for the second NAT rule
                $dstPort2 = $dstPort + 10;
        
                // Create second NAT rule with incremented port
                $natQuery2 = new Query('/ip/firewall/nat/add');
                $natQuery2->equal('chain', 'dstnat')
                          ->equal('protocol', 'tcp')
                          ->equal('dst-port', $dstPort2)
                          ->equal('dst-address-list', 'ip-public')
                          ->equal('action', 'dst-nat')
                          ->equal('to-addresses', $remoteIp)
                          ->equal('to-ports', $dstPort2) // Set to-ports to the fetched API port
                          ->equal('comment', $akuncomment . '_WEB');
        
                $natResponse2 = $client->query($natQuery2)->read();
        
                // Check response from MikroTik
                if (isset($natResponse2['!trap'])) {
                    return response()->json(['error' => $natResponse2['!trap'][0]['message']], 400);
                } else {
                    return response()->json([
                        'message' => "PPP Secret for '$username' has been added successfully with local IP $localIp and remote IP $remoteIp. NAT rules created with destination ports $dstPort and $dstPort2."
                    ]);
                }
            }
        
        } catch (ClientException $e) {
            return response()->json(['error' => "Failed to connect to MikroTik: " . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => "An error occurred: " . $e->getMessage()], 500);
        }
        
    }
}

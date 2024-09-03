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

    public function masukmikrotik(Request $request)
{

    // Retrieve MikroTik data from the database based on the 'ipmikrotik' parameter
    $ipmikrotik = $request->input('ipmikrotik');
    $portweb = $request->input('portweb');
    $data = Mikrotik::where('ipmikrotik', $ipmikrotik)->first();
    $datavpn = VPN::where('ipaddress', $data->ipmikrotik)->first();
    if (!$data) {
        return redirect()->back()->with('error', 'MikroTik data not found.');
    }
    if(!$data){
        return redirect()->back()->with('error', 'Portweb data not found.');

    }
    $username = $data->username; // Retrieve username from the database
    $password = $data->password; // Retrieve password from the database
    $portweb   = $datavpn->portweb;
    
    $config = [
        'host' => $ipmikrotik,
        'user' => $username,
        'pass' => $password,
        'port' => 8728
    ];

    try {
        $client = new Client($config);
        $query = (new Query('/ppp/active/print'));
        $response = $client->query($query)->read();

        // Pass response to the view
        return view('Dashboard.MIKROTIK.masukmikrotik', compact('response', 'portweb'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error connecting to MikroTik: ' . $e->getMessage());
    }
}
public function addFirewallRule(Request $request)
    {
        $request->validate([
            'ipaddr' => 'required|ip',
            'port' => 'required|numeric',
            'ipmikrotik' => 'required|ip',
        ]);

        $ipAddress = $request->input('ipaddr');
        $port = $request->input('port');
        $ipMikrotik = $request->input('ipmikrotik');

        try {
            // MikroTik API client configuration
            $config = [
                'host' => $ipMikrotik,
                'user' => 'admin', // Replace with your MikroTik username
                'pass' => 'ADMINSERVER', // Replace with your MikroTik password
                'port' => 8728
            ];

            $client = new Client($config);

            // Check for existing firewall NAT rules with the comment "Remote-web"
            $query = (new Query('/ip/firewall/nat/print'))
                ->where('comment', 'Remote-web');
            $existingRules = $client->query($query)->read();

            if (!empty($existingRules)) {
                // Update the existing NAT rule
                $id = $existingRules[0]['.id'];
                $updateQuery = (new Query('/ip/firewall/nat/set'))
                    ->equal('.id', $id)
                    ->equal('to-addresses', $ipAddress)
                    ->equal('to-ports', $port);

                $client->query($updateQuery)->read();

            } else {
                // Add a new NAT rule
                $addQuery = (new Query('/ip/firewall/nat/add'))
                    ->equal('chain', 'dstnat')
                    ->equal('protocol', 'tcp')
                    ->equal('dst-port', $port)
                    ->equal('action', 'dst-nat')
                    ->equal('to-addresses', $ipAddress)
                    ->equal('to-ports', '80')
                    ->equal('comment', 'Remote-web');

                $client->query($addQuery)->read();
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}

<x-dcore.head />
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <x-dcore.nav />
        <x-dcore.sidebar />
        <x-dcore.modal />

        <div class="main-content">
            <section class="section">
              
                <!-- MAIN CONTENT -->
                <div class="row">
                    <!-- Pemberitahuan Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="font-size: 20px;"> <i class="fas fa-info-circle"></i> Pemberitahuan</h4>
                            </div>
                            <div class="card-body">
                                <p style="font-size: 20px;">Pada halam ini berfungsi sebagai halaman nighbore mikrotik, dari Mikrotik yang sudah terdaftar di halaman <a href="{{ route('datamikrotik') }}">Data Mikrotik</a></p>
                                <hr>
                                <p class="mb-0" style="font-size: 20px;">Jika Router MikroTik anda tidak mempunyai IP Public, silahkan buat account <a href="{{ route('datavpn') }}">vpn</a> pada form yang sudah di siapkan. Gratis tanpa ada biaya tambahan dan boleh lebih dari satu.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form to Add VPN -->
                  
                    <!-- Data VPN Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Mikrotik</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="mikrotikTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IP VPN Mikrotik</th>
                                                <th>Site</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->ipmikrotik }}</td>
                                                <td>{{ $item->site }}</td>
                                                <td>
                                                    <a href="{{ route('aksesnightbore', ['ipmikrotik' => $item->ipmikrotik]) }}" class="btn btn-primary"><i class="fas fa-bolt"></i> Akses Nighbore</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Edit MikroTik Modal -->
              
                <!-- END MAIN CONTENT -->
            </section>
        </div>
      
        <x-dcore.footer />
    </div>
</div>
<x-dcore.script />

<script>
    $(document).ready(function() {
      $('#mikrotikTable').DataTable();
    });
  </script>
@if (session('success'))
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: '{{ session('success') }}',
                      showConfirmButton: true
                  });
              </script>
          @elseif (session('error'))
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: '{{ session('error') }}',
                      showConfirmButton: true
                  });
              </script>
          @endif
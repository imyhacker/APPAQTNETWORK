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
                              <p style="font-size: 20px;">VPN digunakan untuk menghubungkan Router MikroTik anda dengan Router kami melalui jaringan internet/public. 
                                Radius server kami tidak dapat meneruskan paket request dari router anda jika router anda tidak mempunyai IP Public atau tidak dalam satu jaringan. Setelah router MikroTik anda terhubung 
                                dengan router kami, otomatis radius server akan merespond paket request anda melalui IP Private dari VPN.
                            </p>
                            <hr>
                            <p class="mb-0" style="font-size: 20px;">Jika Router MikroTik anda tidak mempunyai IP Public, silahkan buat account vpn pada form yang sudah di siapkan. Gratis tanpa ada biaya tambahan dan boleh lebih dari satu.</p>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Form to Add VPN -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah VPN</h4>
                            </div>
                            <div class="card-body">
                                <form id="yourFormId" action="{{ route('tambahmikrotik') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="namaAkun">IP VPN / IP Public </label>
                                        <input type="text" class="form-control" placeholder="172.160.x.x" name="ipmikrotik" id="namaAkunInput">
                                    </div>
                                    <div class="form-group">
                                        <label for="namaAkun">Site / Nama Mikrotik</label>
                                        <input type="text" class="form-control" placeholder="Site Indramayu" name="site" id="site">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" name="username">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Tambah Mikrotik">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Data VPN Section -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Mikrotik</h4>
                            </div>
                            <div class="card-body">
                               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MAIN CONTENT -->
            </section>
        </div>

        <x-dcore.footer />
    </div>
</div>
<x-dcore.script />
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Example of handling the response from your Laravel controller
    fetch('/your-endpoint', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            ipmikrotik: document.querySelector('#ipmikrotik').value,
            username: document.querySelector('#username').value,
            password: document.querySelector('#password').value,
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
            });
        } else if (data.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
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

          
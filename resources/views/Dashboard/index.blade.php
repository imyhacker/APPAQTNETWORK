<x-dcore.head />
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <x-dcore.nav />
      <x-dcore.sidebar />
      <div class="main-content">
        <section class="section">
        {{-- <x-dcore.card /> --}}

        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                
                <div class="card-body text-center">
                  
                  <h3>Selamat Datang Di AMMIK AQT Network V.0.1 !</h3>
                </div>
              </div>
              
            </div>
            


            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h6>Tombol Akses Cepat</h6>
                </div>
                <div class="card-body text-center">
                  <div class="row">
                    <div class="col-md-4 mt-2">
                      <a href="{{route('datavpn')}}" class="btn btn-primary btn-block">Data VPN</a>
                    </div>
                    <div class="col-md-4 mt-2">
                      <a href="{{route('datamikrotik')}}" class="btn btn-primary btn-block">Data Mikrotik</a>
                    </div>
                    <div class="col-md-4 mt-2">
                      <a href="{{route('dataolt')}}" class="btn btn-primary btn-block">Data OLT</a>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            
          </div>
        <!-- END OF CENTER CONTENT -->
 

        </section>
         <!-- Bootstrap Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Welcome Back!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You have successfully logged in. Enjoy your session!</p>
                <p>Selamat Datang Di Aplikasi Management Mikrotik ( AMMIK ) AQT Network !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
      </div>
      <x-dcore.footer />
    </div>
  </div>
<x-dcore.script />

<script>
  // Fungsi untuk menampilkan modal
  function showModal() {
      var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
      loginModal.show();
  }

  // Cek jika sessionStorage untuk modal belum diset
  if (!sessionStorage.getItem('modalShown')) {
      // Jika modal belum ditampilkan, tampilkan modal
      showModal();
      // Set item di sessionStorage agar tidak muncul lagi pada sesi yang sama
      sessionStorage.setItem('modalShown', 'true');
  }

  // Hapus item di sessionStorage saat logout (contoh simulasi)
  document.getElementById('logout-form')?.addEventListener('click', function() {
      sessionStorage.removeItem('modalShown');
  });
</script>

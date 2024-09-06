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
                  
                  <h3>Selamat Datang Di Aplikasi Management Mikrotik ( AMMIK ) AQT Network V.0.1 !</h3>
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
    
      </div>
      <x-dcore.footer />
    </div>
  </div>
<x-dcore.script />

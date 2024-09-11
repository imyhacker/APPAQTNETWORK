<x-dcore.head />
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <x-dcore.nav />
      <x-dcore.sidebar />
      
      <div class="main-content">
        <section class="section">
        {{-- <x-dcore.card /> --}}
        <div class="row">
           
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-server"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total VPN</h4>
                </div>
                <div class="card-body">
                  {{ $totalvpn }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-server"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total MikroTik</h4>
                </div>
                <div class="card-body">
                  {{ $totalmikrotik }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Client</h4>
                </div>
                <div class="card-body">
                  {{ $totaluser }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-bolt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>User Active</h4>
                </div>
                <div class="card-body">
                  {{ $totalactive }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                
                <div class="card-body text-center">
                  
                  <h3>Selamat Datang Di Mikrotik Site {{$site ?? '-'}}</h3>
                </div>
              </div>
              
            </div>
        
          </div>
        <!-- END OF CENTER CONTENT -->
        <form action="{{ route('keluarmikrotik') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>


        </section>
    
      </div>
      <x-dcore.footer />
    </div>
  </div>
<x-dcore.script />

<x-dcore.head />
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <x-dcore.nav />
      <x-dcore.sidebar />
      <div class="main-content">
        <section class="section">

        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Pemberitahuan</h4>
                  </div>
                  <div class="card-body">
                    
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah VPN</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{route('uploadvpn')}}" method="post">
                        @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama Akun</label>
                        <input type="text" class="form-control" placeholder="Nama Akun" name="namaakun">
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">User</label>
                        <input type="text" class="form-control" placeholder="Username" name="username">
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                      </div>

                      <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Buat VPN">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <h4>Data VPN</h4>
                </div>
                <div class="card-body">
                    @if($data->isEmpty())
                    <p>No data found for your unique ID.</p>
                @else
                    <table id="vpnTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>IP Address</th>
                                <th>Skrip Mikrotik</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->namaakun }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->password }}</td>
                                    <td>{{ $item->ipaddress }}</td>
                                    <td>
                                       
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fas fa-info"></i> Info
                                              </button>
                                         
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
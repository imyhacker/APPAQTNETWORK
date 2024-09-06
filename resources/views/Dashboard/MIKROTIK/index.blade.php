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
                                <p style="font-size: 20px;">Pada halam ini berfungsi sebagai halaman penambahan mikrotik, ntah itu dari Mikrotik yang sudah terhubung dengan vpn yang telah di buat di halaman <a href="{{ route('datavpn') }}">Data VPN</a> ataupun data mikrotik anda yang sudah memiliki IP Public sendiri</p>
                                <hr>
                                <p class="mb-0" style="font-size: 20px;">Jika Router MikroTik anda tidak mempunyai IP Public, silahkan buat account <a href="{{ route('datavpn') }}">vpn</a> pada form yang sudah di siapkan. Gratis tanpa ada biaya tambahan dan boleh lebih dari satu.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form to Add VPN -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Mikrotik</h4>
                            </div>
                            <div class="card-body">
                                <form id="yourFormId" action="{{ route('tambahmikrotik') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="ipmikrotik">IP VPN / IP Public</label>
                                        <input type="text" class="form-control" placeholder="172.160.x.x" name="ipmikrotik" id="namaAkunInput">
                                    </div>
                                    <div class="form-group">
                                        <label for="site">Site / Nama Mikrotik</label>
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
                                <div class="table-responsive">
                                    <table id="mikrotikTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IP Mikrotik</th>
                                                <th>Site</th>
                                                <th>Username</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach($mikrotik as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->ipmikrotik }}</td>
                                                <td>{{ $item->site }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('aksesmikrotik', [
                                                                'ipmikrotik' => $item->ipmikrotik,
                                                                'username' => $item->username,
                                                                'password' => $item->password
                                                            ]) }}"><i class="fas fa-bolt"></i> Cek Akses</a>
                                                           <a class="dropdown-item" href="{{ route('masukmikrotik', [
                                                            'ipmikrotik' => $item->ipmikrotik,
                                                            'portweb' => $item->portweb
                                                        ]) }}"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                                                            <a class="dropdown-item editMikrotik" href="javascript:void(0)" data-id="{{ $item->id }}"><i class="fas fa-edit"></i> Edit</a>
                                                            <a class="dropdown-item deleteMikrotik" href="javascript:void(0)" data-id="{{ $item->id }}"><i class="fas fa-trash"></i> Hapus</a>
                                                        </div>
                                                    </div>
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
        <div class="modal fade" id="editMikrotikModal" tabindex="-1" role="dialog" aria-labelledby="editMikrotikModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMikrotikModalLabel">Edit MikroTik</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editMikrotikForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="edit_ipmikrotik">IP VPN / IP Public</label>
                                <input type="text" class="form-control" id="edit_ipmikrotik" name="ipmikrotik" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_site">Site / Nama Mikrotik</label>
                                <input type="text" class="form-control" id="edit_site" name="site" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_username">Username</label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_password">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Mikrotik</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-dcore.footer />
    </div>
</div>
<x-dcore.script />

<script>
  $(document).ready(function() {
    $('#mikrotikTable').DataTable();

    // Handle Edit
    $('.editMikrotik').click(function() {
        var id = $(this).data('id');
        $.get('{{ route('mikrotik.edit', '') }}/' + id, function(data) {
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }
            $('#editMikrotikModal').modal('show');
            $('#editMikrotikForm').attr('action', '{{ url("/home/datamikrotik/") }}/' + id + '/update');
            $('#edit_ipmikrotik').val(data.ipmikrotik);
            $('#edit_site').val(data.site);
            $('#edit_username').val(data.username);
            $('#edit_password').val(data.password);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error', 'Gagal memuat data: ' + textStatus, 'error');
        });
    });

    // Handle Delete
    $('.deleteMikrotik').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('mikrotik.delete', '') }}/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('Dihapus!', 'Data Mikrotik telah dihapus.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', 'Data Mikrotik gagal dihapus.', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data: ' + textStatus, 'error');
                    }
                });
            }
        });
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
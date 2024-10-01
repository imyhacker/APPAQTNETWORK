<x-dcore.head />
<div id="app">
  <div class="main-wrapper main-wrapper-1">
    <div class="navbar-bg"></div>

    <x-dcore.nav />
    <x-dcore.sidebar />

    <div class="main-content">
      <section class="section">

        <!-- MAIN CONTENT -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="myTable2" class="table table-striped table-bordered table-sm" style="font-size: 12px;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Interface</th>
                        <th>MAC Address</th>
                        <th>MTU</th>
                        <th>Type</th>
                        <th>TX Rate</th>
                        <th>RX Rate</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php 
                            $no = 1; 
                        @endphp
                        @foreach ($interface as $d)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $d['name'] ?? 'N/A' }}</td>
                            <td>{{ $d['mac-address'] ?? 'N/A' }}</td>
                            <td>{{ $d['mtu'] ?? 'N/A' }}</td>
                            <td>{{ $d['type'] ?? 'N/A' }}</td>
                            <td>{{ $d['tx-rate'] ?? 'N/A' }}</td>
                            <td>{{ $d['rx-rate'] ?? 'N/A' }}</td>
                            <td>{{ $d['running'] ? 'Running' : 'Stopped' }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END OF MAIN CONTENT -->

      </section>
    </div>
    <x-dcore.footer />
  </div>
</div>
<x-dcore.script />
<script>
     // Initialize DataTable with custom settings for smaller font and responsive display
     var table = $('#myTable2').DataTable({
            
            responsive: true,
            pageLength: 10, // Number of rows per page
            autoWidth: false, // Disable automatic column width adjustment
            columnDefs: [
                { targets: "_all", className: "text-center" } // Center align all columns
            ]
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

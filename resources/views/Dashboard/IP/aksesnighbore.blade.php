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
                  <table id="myTable2" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>IFACE</th>
                        <th>MAC</th>
                        <th>Platform</th>
                        <th>Uptime</th>
                        <th>Identity</th>
                        <th>Address</th>
                        <th>Board</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                        @php 
                            use Carbon\Carbon;    
                            $no = 1; 
                            
                        @endphp
                        @foreach ($response as $res => $d)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$d['.id']}}</td>
                            <td>{{$d['interface']}}</td>
                            <td>{{$d['mac-address']}}</td>

                            <td>{{$d['platform']}}</td>
                            <td>{{ $d['uptime'] ?? "N/A"}}</td>
                            <td>{{$d['identity' ?? 'N/A']}}</td>
                            <td>{{$d['address'] ?? 'N/A'}}</td>
                            <td>{{$d['board'] ?? "N/A"}}</td>
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
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#myTable2').DataTable({
            // Define any DataTable options here
        });

        // Function to reload table data
        function reloadTable() {
            table.draw(); // Redraw the table to refresh its content
        }

        // Set interval to reload table data every 1 minute (60000 milliseconds)
        setInterval(reloadTable, 10000); // 60000 milliseconds = 1 minute

        // Optionally, call reloadTable once to load initial data
        reloadTable();
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

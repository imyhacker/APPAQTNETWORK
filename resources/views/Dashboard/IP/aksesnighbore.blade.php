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
        // Initialize DataTable with custom settings for smaller font and responsive display
        var table = $('#myTable2').DataTable({
            paging: true,
            responsive: true,
            pageLength: 10, // Number of rows per page
            autoWidth: false, // Disable automatic column width adjustment
            columnDefs: [
                { targets: "_all", className: "text-center" } // Center align all columns
            ]
        });

        // Function to reload table data while maintaining the current page
        function reloadTable() {
            var currentPage = table.page.info().page; // Get the current page number
            table.ajax.reload(null, false); // Reload table without resetting pagination
            table.page(currentPage).draw(false); // Redraw table and stay on the same page
        }

        // Set interval to reload table data every 10 seconds
        setInterval(reloadTable, 10000); // 10000 milliseconds = 10 seconds

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

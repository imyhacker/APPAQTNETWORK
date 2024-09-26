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
                                <th>Name</th>
                                <th>Service</th>
                                <th>Profile</th>
                                <th>Remote Address</th>
                                <th>Comment</th>
                                <th>Disabled</th>
                                <th>Last Logged Out</th> <!-- New Column -->
                              </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $no = 1; 
                                @endphp
                                @foreach ($secrets as $d)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d['name'] ?? 'N/A' }}</td>
                                    <td>{{ $d['service'] ?? 'N/A' }}</td>
                                    <td>{{ $d['profile'] ?? 'N/A' }}</td>
                                    <td>{{ $d['remote-address'] ?? 'N/A' }}</td>
                                    <td>{{ $d['comment'] ?? 'N/A' }}</td>
                                    <td>{{ $d['disabled'] ? 'Yes' : 'No' }}</td>
                                    <td>
                                        @if(isset($d['last_logged_out']))
                                            {{ \Carbon\Carbon::parse($d['last_logged_out'])->format('Y-m-d H:i:s') }}
                                        @else
                                            N/A
                                        @endif
                                    </td> <!-- New Data Field -->
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
        $('#myTable2').DataTable({
            "pageLength": 10, // Default number of rows per page
            "lengthMenu": [10, 25, 50, 75, 100], // Options for rows per page
            "order": [[0, 'asc']], // Default sorting on the first column
        });
    });
</script>

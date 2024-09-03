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
                  <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Action</th>
                        <th>Type</th>
                        <th>Address</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $no = 1; @endphp
                      @foreach ($response as $data => $d)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $d['.id'] }}</td>
                          <td>{{ $d['name'] }}</td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $d['.id'] }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $d['.id'] }}">
                                <a class="dropdown-item remote-modem" href="#" data-ip="{{ $d['address'] }}" data-port="{{ $portweb }}">Remote Modem</a>
                                <a class="dropdown-item restart-btn" href="">Restart Koneksi</a>
                                <a class="dropdown-item copy-btn" href="#">Copy IP Address</a>
                              </div>
                            </div>
                          </td>
                          <td>{{ $d['service'] }}</td>
                          <td id="text-to-copy">{{ $d['address'] }}</td>
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

<!-- Remote Modem Modal -->
<div class="modal fade" id="RemoteModem" tabindex="-1" role="dialog" aria-labelledby="RemoteModemLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="RemoteModemLabel">Remote Modem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="remoteModemForm" action="">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="ipAddress">IP Address</label>
            <input type="text" class="form-control" id="remote-ip-address" name="ipaddr" placeholder="127.x.x.x" readonly="true">
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">PORT</label>
            <select class="form-control" id="toport" name="toport">
              <option disabled selected value>- PILIH PORT -</option>
              <option value="443">443</option>
              <option value="80">80</option>
              <option value="8080">8080</option>
            </select>
            <small class="mini-text">Modem : 80, Tenda : 80</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<x-dcore.script />
<script>
  $(document).ready(function() {
      // Initialize DataTable with responsive design
      $('#myTable').DataTable({
          responsive: true
      });
  
      // Function to get query parameter from URL
      function getQueryParam(param) {
          let urlParams = new URLSearchParams(window.location.search);
          return urlParams.get(param);
      }
  
      // Get the ipMikrotik parameter from the URL
      let ipMikrotik = getQueryParam('ipmikrotik');
  
      // Handle click event on the "remote-modem" buttons
      $('.remote-modem').on('click', function(event) {
          event.preventDefault(); // Prevent default link behavior
  
          var ipAddress = $(this).data('ip'); // Get IP address from the data attribute
          var dataPort = $(this).data('port'); // Get data-port value from the data attribute
  
          // Set the IP address and port in the modal
          $('#remote-ip-address').val(ipAddress);
          $('#toport').val(dataPort);
          $('#RemoteModem').modal('show'); // Show the modal
      });
  
      // Handle form submission for adding/updating firewall rule
      $('#remoteModemForm').on('submit', function(event) {
          event.preventDefault(); // Prevent default form submission
  
          var ipAddress = $('#remote-ip-address').val();
          var toPort = $('#toport').val();
          var dataPort = $('.remote-modem').data('port'); // Get data-port from the clicked button
  
          if (toPort) {
              $.ajax({
                  url: '{{ route("addFirewallRule") }}', // Laravel route to handle the request
                  type: 'POST',
                  data: {
                      ipaddr: ipAddress,
                      port: toPort,
                      ipmikrotik: ipMikrotik,
                      _token: '{{ csrf_token() }}' // Include CSRF token
                  },
                  success: function(response) {
                      if (response.success) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Success',
                              text: 'Firewall rule added or updated successfully!',
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  // Open a new tab with the constructed URL using data-port
                                  var newTabUrl = `http://id-1.aqtnetwork.my.id:${dataPort}`;
                                  window.open(newTabUrl, '_blank');
                              }
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: 'Failed to add firewall rule: ' + response.error,
                          });
                      }
                      $('#RemoteModem').modal('hide'); // Hide the modal
                  },
                  error: function(xhr) {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'An error occurred while adding the firewall rule.',
                      });
                      console.log('Error Details:', xhr.responseText);
                  }
              });
          } else {
              Swal.fire({
                  icon: 'warning',
                  title: 'Warning',
                  text: 'Please select a port.',
              });
          }
      });
  });
  </script>
  
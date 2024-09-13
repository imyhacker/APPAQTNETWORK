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
                          <td>{{ $d['name'] }}</td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $d['.id'] }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $d['.id'] }}">
                                <a class="dropdown-item remote-modem" href="#" data-ip="{{ $d['address'] }}" data-port="{{ $portweb }}"><i class="fas fa-bolt"></i> Remote Modem</a>
                                <a class="dropdown-item restart-modem" href="#" data-ip="{{ $d['address'] }}" data-port="{{ $portweb }}"><i class="fas fa-sync-alt"></i> Restart Modem</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#trafficModal" 
                                data-ipmikrotik="{{ $ipmikrotik }}" data-name="{{ $d['name'] }}">
                                <i class="fas fa-eye"></i> Pantau Traffik
                             </a>
                                <a class="dropdown-item copy-btn" href="#"><i class="fas fa-copy"></i> Copy IP Address</a>
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



<div class="modal fade" id="trafficModal" tabindex="-1" role="dialog" aria-labelledby="trafficModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="trafficModalLabel">Traffic Monitoring</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p id="trafficInfo">Loading...</p>
              <canvas id="trafficChart" width="400" height="200"></canvas>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
<x-dcore.script />
{{-- <script>
  $(document).ready(function() {
    // Initialize DataTable with responsive design
    var table = $('#myTable').DataTable({
      responsive: true
    });

    // Function to get query parameter from URL
    function getQueryParam(param) {
      let urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    // Get the ipMikrotik parameter from the URL
    let ipMikrotik = getQueryParam('ipmikrotik');

    // Handle click event on the "remote-modem" buttons using event delegation
    $('#myTable').on('click', '.remote-modem', function(event) {
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
                  var dataPort = $('#toport').val(); // Use the port from the form
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

    // Handle click event on the "restart-modem" buttons using event delegation
    $('#myTable').on('click', '.restart-modem', function(event) {
      event.preventDefault(); // Prevent default link behavior

      var ipAddress = $(this).data('ip'); // Get IP address from the data attribute
      var dataPort = $(this).data('port'); // Get data-port value from the data attribute

      // Show confirmation dialog
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to restart the modem connection?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restart it!',
        cancelButtonText: 'No, cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Perform the restart action
          $.ajax({
            url: '', // Laravel route to handle the restart
            type: 'POST',
            data: {
              ipaddr: ipAddress,
              port: dataPort,
              ipmikrotik: ipMikrotik,
              _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Modem restarted successfully!',
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to restart modem: ' + response.error,
                });
              }
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while restarting the modem.',
              });
              console.log('Error Details:', xhr.responseText);
            }
          });
        }
      });
    });

    // Copy IP address to clipboard using event delegation
    $('#myTable').on('click', '.copy-btn', function() {
      var textToCopy = $(this).closest('tr').find('#text-to-copy').text();
      navigator.clipboard.writeText(textToCopy).then(function() {
        Swal.fire({
          icon: 'success',
          title: 'Copied!',
          text: 'IP Address copied to clipboard.',
        });
      }, function(err) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to copy IP Address.',
        });
      });
    });
  });
</script> --}}

<script>
  $(document).ready(function() {
    // Initialize DataTable with responsive design
    var table = $('#myTable').DataTable({
      responsive: true
    });

    // Function to get query parameter from URL
    function getQueryParam(param) {
      let urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    // Get the ipMikrotik parameter from the URL
    let ipMikrotik = getQueryParam('ipmikrotik');

    // Variable to store data-port from the .remote-modem button
    var currentDataPort;

    // Handle click event on the "remote-modem" buttons using event delegation
    $('#myTable').on('click', '.remote-modem', function(event) {
      event.preventDefault(); // Prevent default link behavior

      var ipAddress = $(this).data('ip'); // Get IP address from the data attribute
      currentDataPort = $(this).data('port'); // Store data-port value from the data attribute

      // Set the IP address in the modal
      $('#remote-ip-address').val(ipAddress);
      $('#toport').val(currentDataPort);
      $('#RemoteModem').modal('show'); // Show the modal
    });

    // Handle form submission for adding/updating firewall rule
    $('#remoteModemForm').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission

      var ipAddress = $('#remote-ip-address').val();
      var toPort = $('#toport').val();

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
              var newTabUrl = `http://id-1.aqtnetwork.my.id:${currentDataPort}`; // Use currentDataPort

              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Firewall rule added or updated successfully!',
              }).then((result) => {
                if (result.isConfirmed) {
                  // Open a new tab with the constructed URL
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

    // Handle click event on the "restart-modem" buttons using event delegation
    $('#myTable').on('click', '.restart-modem', function(event) {
      event.preventDefault(); // Prevent default link behavior

      var ipAddress = $(this).data('ip'); // Get IP address from the data attribute
      var dataPort = $(this).data('port'); // Get data-port value from the data attribute

      // Show confirmation dialog
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to restart the modem connection?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restart it!',
        cancelButtonText: 'No, cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Perform the restart action
          $.ajax({
            url: '{{route("restartmodem")}}', // Laravel route to handle the restart
            type: 'POST',
            data: {
              ipaddr: ipAddress,
              port: dataPort,
              ipmikrotik: ipMikrotik,
              _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Modem restarted successfully!',
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to restart modem: ' + response.error,
                });
              }
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while restarting the modem.',
              });
              console.log('Error Details:', xhr.responseText);
            }
          });
        }
      });
    });

    // Copy IP address to clipboard using event delegation
    $('#myTable').on('click', '.copy-btn', function() {
      var textToCopy = $(this).closest('tr').find('#text-to-copy').text();
      navigator.clipboard.writeText(textToCopy).then(function() {
        Swal.fire({
          icon: 'success',
          title: 'Copied!',
          text: 'IP Address copied to clipboard.',
        });
      }, function(err) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to copy IP Address.',
        });
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
      var trafficChart; // Declare chart variable outside the event handler
      var lastRxBytes = 0; // Variable to store the last received bytes
      var lastTxBytes = 0; // Variable to store the last transmitted bytes
  
      function initializeChart() {
          var ctx = document.getElementById('trafficChart').getContext('2d');
          trafficChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: [], // Initially empty labels
                  datasets: [
                      {
                          label: 'Received Traffic (Mbps)',
                          data: [],
                          backgroundColor: 'rgba(75, 192, 192, 0.2)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1,
                          fill: false
                      },
                      {
                          label: 'Transmitted Traffic (Mbps)',
                          data: [],
                          backgroundColor: 'rgba(153, 102, 255, 0.2)',
                          borderColor: 'rgba(153, 102, 255, 1)',
                          borderWidth: 1,
                          fill: false
                      }
                  ]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true,
                          title: {
                              display: true,
                              text: 'Traffic (Mbps)'
                          }
                      },
                      x: {
                          title: {
                              display: true,
                              text: 'Time'
                          }
                      }
                  }
              }
          });
      }
  
      function fetchTrafficData(interfaceName, ipmikrotik) {
          $.ajax({
              url: '{{ route('mikrotik.traffic') }}', // Adjust the URL according to your route
              method: 'GET',
              data: { interface: interfaceName, ipmikrotik: ipmikrotik },
              success: function(response) {
                  if (response.error) {
                      $('#trafficInfo').text(response.error);
                      return;
                  }
  
                  var rxBytes = response.traffic.rx || 0;
                  var txBytes = response.traffic.tx || 0;
  
                  // Calculate traffic rates in Mbps
                  var rxMbps = ((rxBytes - lastRxBytes) * 8 / 1000000).toFixed(2);
                  var txMbps = ((txBytes - lastTxBytes) * 8 / 1000000).toFixed(2);
  
                  // Update last known values
                  lastRxBytes = rxBytes;
                  lastTxBytes = txBytes;
  
                  var now = new Date().toLocaleTimeString();
  
                  if (trafficChart.data.labels.length > 20) {
                      trafficChart.data.labels.shift();
                      trafficChart.data.datasets[0].data.shift();
                      trafficChart.data.datasets[1].data.shift();
                  }
  
                  trafficChart.data.labels.push(now);
                  trafficChart.data.datasets[0].data.push(Math.max(parseFloat(rxMbps), 0));
                  trafficChart.data.datasets[1].data.push(Math.max(parseFloat(txMbps), 0));
  
                  trafficChart.update();
  
                  $('#trafficInfo').html(
                      `<p>RX Traffic: ${Math.max(parseFloat(rxMbps), 0)} Mbps</p>
                       <p>TX Traffic: ${Math.max(parseFloat(txMbps), 0)} Mbps</p>`
                  );
              },
              error: function(xhr) {
                  console.error('AJAX Error:', xhr);
              }
          });
      }
  
      $('#trafficModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var ipmikrotik = button.data('ipmikrotik');
          var name = button.data('name');
  
          var modal = $(this);
          modal.find('.modal-title').text('Traffic Monitoring for Interface: ' + name);
  
          // Check if trafficChart exists and destroy it
          if (trafficChart) {
              trafficChart.destroy();
          }
  
          // Initialize chart
          initializeChart();
  
          // Reset lastRxBytes and lastTxBytes for the new interface
          lastRxBytes = 0;
          lastTxBytes = 0;
  
          // Fetch and update traffic data
          function updateTrafficData() {
              fetchTrafficData(name, ipmikrotik);
          }
  
          updateTrafficData(); // Initial fetch
          setInterval(updateTrafficData, 2000); // Poll every 2 seconds
      });
  
      $('#trafficModal').on('hidden.bs.modal', function () {
          if (trafficChart) {
              trafficChart.destroy();
              trafficChart = null; // Clear chart reference
          }
          $('#trafficInfo').empty(); // Clear the traffic info display
      });
  });
  </script>
  
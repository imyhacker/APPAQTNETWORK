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

          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-bolt"></i>
              </div>
              <div class="card-wrap">
               
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" id="cpuLoad"></div>
                    <div class="col-md-12 mb-3">
                      {{$version}}
                    </div>
                  </div>
               </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>DATE</h4>
                </div>
                <div class="card-body">
                  {{ $date }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-bolt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Time</h4>
                </div>
                <div class="card-body" id="currentTime">
                 Loading...
                </div>
              </div>
            </div>
          </div>


        </div>
        <!-- MAIN OF CENTER CONTENT -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                
                <div class="card-body">
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-12 d-flex justify-content-center">
                      <h3>Selamat Datang Di MikroTik {{$site ?? '-'}}</h3>
                    </div>
                    <div class="col-md-12">

                      <form action="{{ route('keluarmikrotik') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">Logout MikroTik</button>
                    </form>
    
                    </div>
                  </div>
                 

                </div>
              </div>
              
            </div>
            <!-- traffic -->
            <div class="col-lg-6">
              <div class="card">
                
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                              <form id="interfaceForm">
                                <div class="form-group">
                                    <label for="interface">Select Interface</label>
                                    <select class="form-control" id="interface" name="interface">
                                        @foreach ($interfaces as $interface)
                                            <option value="{{ $interface }}">{{ $interface }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Input hidden untuk ipmikrotik -->
                                <input type="hidden" id="ipmikrotik" name="ipmikrotik" value="{{ $ipmikrotik }}">
                                <button type="submit" class="btn btn-primary">Get Traffic</button>
                            </form>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>
                </div>
              </div>
              
            </div>
             <!-- Voucher -->
            <div class="col-lg-6">
              <div class="card">
                
                <div class="card-body">
                  Voucher
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
<script>
  function fetchCpuLoad() {
      $.ajax({
          url: '/mikrotik/cpu-load/{{ $ipmikrotik }}',
          method: 'GET',
          success: function(response) {
              $('#cpuLoad').text(response.cpuLoad);
          },
          error: function() {
              $('#cpuLoad').text('Error');
          }
      });
  }

  function fetchCurrentTime() {
      $.ajax({
          url: '/mikrotik/current-time/{{ $ipmikrotik }}',
          method: 'GET',
          success: function(response) {
              $('#currentTime').text(response.time);
          },
          error: function() {
              $('#currentTime').text('Error');
          }
      });
  }

  // Fetch CPU load and current time immediately and then every 5 seconds
  fetchCpuLoad();
  fetchCurrentTime();
  setInterval(fetchCpuLoad, 1000); // Refresh CPU load every 5 seconds
  setInterval(fetchCurrentTime, 1000); // Refresh current time every 5 seconds
</script>
<script>
  $(document).ready(function() {
    let chart = null;
    let pollingInterval = null; // Variable for interval

    $('#interfaceForm').on('submit', function(event) {
        event.preventDefault();
        const selectedInterface = $('#interface').val();
        const ipmikrotik = $('#ipmikrotik').val();

        // Clear any previous polling
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        // Function to fetch traffic data and update chart
        function fetchTrafficData() {
            $.ajax({
                url: '/mikrotik/traffic',
                method: 'GET',
                data: { interface: selectedInterface, ipmikrotik: ipmikrotik },
                success: function(response) {
                    console.log('Response Data:', response); // Debugging

                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    // Update the chart data
                    if (chart) {
                        chart.data.datasets[0].data.push(response.rx); // Update RX data
                        chart.data.datasets[1].data.push(response.tx); // Update TX data

                        // Maintain only the last 20 data points (for example)
                        if (chart.data.datasets[0].data.length > 20) {
                            chart.data.datasets[0].data.shift(); // Remove old RX data
                            chart.data.datasets[1].data.shift(); // Remove old TX data
                        }

                        chart.update(); // Redraw chart
                    }
                },
                error: function(xhr) {
                    console.log('AJAX Error:', xhr); // Debugging
                    alert('Error retrieving traffic data.');
                }
            });
        }

        // Create or update the chart
        const ctx = document.getElementById('trafficChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line', // Use 'line' chart type
            data: {
                labels: [], // Dynamic labels for x-axis (will update automatically)
                datasets: [{
                    label: 'Received Traffic (bytes)', // Label for RX
                    data: [], // Start with empty data for RX
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue
                    borderColor: 'rgba(54, 162, 235, 1)', // Blue for RX line
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                },
                {
                    label: 'Transmitted Traffic (bytes)', // Label for TX
                    data: [], // Start with empty data for TX
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Light red
                    borderColor: 'rgba(255, 99, 132, 1)', // Red for TX line
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Start polling the traffic data every 2 seconds
        pollingInterval = setInterval(fetchTrafficData, 2000);
    });
});
</script>

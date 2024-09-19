<x-dcore.head />
<style>
  /* Add some basic styling */
  #trafficChart {
      width: 100%;
      max-width: 800px;
      margin: auto;
  }
  #trafficInfo {
      text-align: center;
      margin-top: 20px;
  }
</style>
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
                <div class="card-header">
                  <h4>Status</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" id="cpuLoad" style="font-size: 12px;"></div>
                    <div class="col-md-12 mb-3" style="font-size: 12px;">
                    <b> Model : {{$model}} <br>Version : {{$version}}</b>
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
                  <h4>Kinerja</h4>
                </div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-12" style="font-size: 12px;" id="uptime">Loading...</div>
                    <div class="col-md-12 mb-3" style="font-size: 12px;">
                    <b>Tanggal : {{ $date }}</b>
                    </div>
                  </div>
                 
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
                  <h4>Hotspot</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" style="font-size: 12px;">Jml. VCR : {{$ttuser}}</div>
                    <div class="col-md-12 mb-3" style="font-size: 12px;">
                    <b>Active : {{ $activeUserCount }}</b>
                    </div>
                  </div>
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
                       
                            <form id="interfaceForm">
    <div class="form-group">
        <label for="interface">Select Interface</label>
        <select class="form-control" id="interface" name="interface">
            @foreach ($interfaces as $interface)
                <option value="{{ $interface }}">{{ $interface }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">

    <!-- Input hidden untuk ipmikrotik -->
    <input type="hidden" id="ipmikrotik" name="ipmikrotik" value="{{ $ipmikrotik }}">
    <button type="submit" class="btn btn-primary">Get Traffic</button>
    </div>

</form>

                    </div>
                    <div class="col-lg-12">
                      
                        <canvas id="trafficChart"></canvas>
                        <div id="trafficInfo">
                          <p>Trafik Download: <span id="currentRx">0</span></p>
                          <p>Trafik Upload : <span id="currentTx">0</span></p>
                      </div>
                    </div>
                    <div class="col-lg-12">
                    <small class="mt-2">*Data Dalam Bentuk Mpbs <br>Jika Berganti Ethernet Tunggu 20 Detik Maka Data Grafik Akan Berganti Ke Ethernet Yang Di Pilih</small>
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
<!-- <script>
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
</script> -->
<script>
  function fetchUptime() {
    $.ajax({
        url: '/mikrotik/uptime/{{ $ipmikrotik }}',
        method: 'GET',
        success: function(response) {
            if (response.error) {
                $('#uptime').text('Uptime: Error');
            } else {
                $('#uptime').text('Uptime: ' + response.uptime);
            }
        },
        error: function() {
            $('#uptime').text('Uptime: Error');
        }
    });
  }

  // Fetch uptime immediately and then every 5 minutes
  fetchUptime();
  setInterval(fetchUptime, 300000); // Refresh uptime every 5 minutes (300000 milliseconds)
</script>
<script>
 $(document).ready(function() {
    let chart = null;
    let pollingInterval = null;
    let dataPoints = 20;

    $('#interfaceForm').on('submit', function(event) {
        event.preventDefault();
        const selectedInterface = $('#interface').val();
        const ipmikrotik = $('#ipmikrotik').val();

        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        if (chart) {
            chart.destroy();
            chart = null;
        }

        const initialLabels = Array(dataPoints).fill('').map((_, i) => i + 1);
        const initialData = Array(dataPoints).fill(0);

        const ctx = document.getElementById('trafficChart').getContext('2d');
        
        // Gradients for a smooth and modern look
        const gradientRx = ctx.createLinearGradient(0, 0, 0, 400);
        gradientRx.addColorStop(0, 'rgba(54, 162, 235, 0.5)');
        gradientRx.addColorStop(1, 'rgba(54, 162, 235, 0.1)');

        const gradientTx = ctx.createLinearGradient(0, 0, 0, 400);
        gradientTx.addColorStop(0, 'rgba(255, 99, 132, 0.5)');
        gradientTx.addColorStop(1, 'rgba(255, 99, 132, 0.1)');

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: initialLabels,
                datasets: [
                    {
                        label: 'Trafik Download (Mbps)',
                        data: initialData.slice(),
                        backgroundColor: gradientRx,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        pointRadius: 0,  // Remove points to keep the line smooth
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Trafik Upload (Mbps)',
                        data: initialData.slice(),
                        backgroundColor: gradientTx,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false, // Remove vertical grid lines for cleaner look
                        },
                        ticks: {
                            display: false // Hide x-axis ticks
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.3)', // Lighten the grid lines
                            borderDash: [5, 5], // Dashed lines for a modern look
                        },
                        ticks: {
                            stepSize: 0.5,
                            callback: function(value) {
                                return value + ' Mbps'; // Label y-axis with 'Mbps'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: true, // Change legend style to points
                            font: {
                                size: 12,
                                family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif", // Custom font
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + Math.round(tooltipItem.raw * 100) / 100 + ' Mbps'; // Format with 2 decimal places
                            }
                        }
                    }
                },
                maintainAspectRatio: false, // Allow chart to resize properly
                responsive: true,
                animation: {
                    duration: 800, // Smooth animation when updating
                    easing: 'easeInOutQuart' // Easing for smoother transition
                }
            }
        });

        function fetchTrafficData() {
            $.ajax({
                url: '/mikrotik/traffic',
                method: 'GET',
                data: { interface: selectedInterface, ipmikrotik: ipmikrotik },
                success: function(response) {
                    const rxMbps = (response.rx / 1000000).toFixed(2);
                    const txMbps = (response.tx / 1000000).toFixed(2);

                    if (chart) {
                        const currentTime = new Date().toLocaleTimeString();
                        chart.data.labels.push(currentTime);

                        chart.data.datasets[0].data.push(rxMbps);
                        chart.data.datasets[1].data.push(txMbps);

                        if (chart.data.labels.length > dataPoints) {
                            chart.data.labels.shift();
                            chart.data.datasets[0].data.shift();
                            chart.data.datasets[1].data.shift();
                        }

                        chart.update();
                        $('#currentRx').text(rxMbps + ' Mbps');
                        $('#currentTx').text(txMbps + ' Mbps');
                    }
                },
                error: function(xhr) {
                    alert('Error retrieving traffic data.');
                }
            });
        }

        pollingInterval = setInterval(fetchTrafficData, 1000);
        fetchTrafficData();
    });
});

</script>

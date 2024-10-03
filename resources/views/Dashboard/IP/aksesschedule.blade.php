<x-dcore.head />
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <x-dcore.nav />
        <x-dcore.sidebar />

        <div class="main-content">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="font-size: 12px;" id="myTable2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Start Date</th>
                                                <th>Start Time</th>
                                                <th>Run Count</th>
                                                <th>Duration (Minutes/Hours)</th>
                                                <th>Duration (Hours/Days)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($formattedData as $index => $schedule)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $schedule['name'] }}</td>
                                                    <td>{{ $schedule['start_date'] }}</td>
                                                    <td>{{ $schedule['start_time'] }}</td>
                                                    <td>{{ $schedule['run_count'] }}</td>
                                                    <td>
                                                        @php
                                                            $minutes = $schedule['run_count'] * 20 / 60;
                                                            echo $minutes < 60 ? round($minutes) . ' minutes' : round($minutes / 60) . ' hours';
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hours = $schedule['run_count'] * 20 / 60 / 60;
                                                            echo $hours < 24 ? round($hours) . ' hours' : round($hours / 24) . ' days';
                                                        @endphp
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
            </section>
        </div>

        <x-dcore.footer />
    </div>
</div>

<x-dcore.script />
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#myTable2').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 75, 100],
            "order": [[0, 'asc']],
            "destroy": true, // Allow DataTable to be re-initialized after the table refresh
        });

        // Function to reload the table data via AJAX
        function reloadTable() {
            $.ajax({
                url: "{{ route('aksesschedule') }}?ipmikrotik={{ request()->query('ipmikrotik') }}", // Pass the IP query parameter
                type: 'GET',
                success: function(data) {
                    // Clear existing table content
                    $('#tableBody').html('');

                    // Iterate through new data and populate table
                    $.each(data.formattedData, function(index, schedule) {
                        var minutes = schedule.run_count * 20 / 60;
                        var minutesDisplay = minutes < 60 ? Math.round(minutes) + ' minutes' : Math.round(minutes / 60) + ' hours';

                        var hours = schedule.run_count * 20 / 60 / 60;
                        var hoursDisplay = hours < 24 ? Math.round(hours) + ' hours' : Math.round(hours / 24) + ' days';

                        $('#tableBody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${schedule.name}</td>
                                <td>${schedule.start_date}</td>
                                <td>${schedule.start_time}</td>
                                <td>${schedule.run_count}</td>
                                <td>${minutesDisplay}</td>
                                <td>${hoursDisplay}</td>
                            </tr>
                        `);
                    });

                    // Destroy and reinitialize DataTable to refresh
                    table.destroy();
                    table = $('#myTable2').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [10, 25, 50, 75, 100],
                        "order": [[0, 'asc']],
                        "destroy": true,
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error refreshing data: ", status, error);
                }
            });
        }

        // Automatically reload the table every 20 seconds
        setInterval(reloadTable, 20000); // 20000 milliseconds = 20 seconds

        // Initial call to load data
        reloadTable();
    });
</script>

<style>
    .wide-card {
        width: 100%;
        margin: 0;
        border-radius: 5px; /* Rounded corners */
        overflow: hidden; /* Ensures the content stays within the rounded edges */
    }

    .card-body, .card-header {
        padding: 1rem; /* Optional: Adjust padding */
    }

    /* Adjust padding for smaller screens */
    @media (max-width: 768px) {
        .wide-card .card-body {
            padding: 1rem;
        }

        .wide-card h3 {
            font-size: 1.5rem;
        }

        .wide-card h6 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .wide-card .card-body {
            padding: 0.5rem;
        }

        .wide-card h3 {
            font-size: 1.2rem;
        }
    }

    /* Remove space between columns */
    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .no-gutters > .col, .no-gutters > [class*="col-"] {
        padding-right: 0;
        padding-left: 0;
    }
</style>

<x-dcore.head />
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <x-dcore.nav />
        <x-dcore.sidebar />
        <div class="main-content">
            <section class="section">
                <!-- MAIN OF CENTER CONTENT -->
                <div class="row no-gutters"> <!-- Remove gutter space between columns -->
                    <!-- Welcome Card -->
                    <div class="col-12"> <!-- Full width column -->
                        <div class="card wide-card">
                            <div class="card-body text-center">
                                <h3>Selamat Datang Di Aplikasi Management Mikrotik ( AMMIK ) AQT Network V.0.1 !</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Access Buttons Card -->
                    <div class="col-12"> <!-- Full width column -->
                        <div class="card wide-card">
                            <div class="card-header">
                                <h6>Tombol Akses Cepat</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="row"> <!-- Remove gutter space between buttons -->
                                    <div class="col-md-4 col-12 mt-2">
                                        <a href="{{ route('datavpn') }}" class="btn btn-primary btn-block">Data VPN</a>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <a href="{{ route('datamikrotik') }}" class="btn btn-primary btn-block">Data Mikrotik</a>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <a href="{{ route('dataolt') }}" class="btn btn-primary btn-block">Data OLT</a>
                                    </div>
                                </div>
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{config('app.name')}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/css/style.css">
  <link rel="stylesheet" href="https://demo.getstisla.com/assets/css/components.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
  <style>
    /* Ukuran font dasar lebih kecil */
body {
    font-size: 0.65rem; /* 65% dari ukuran default untuk semua teks */
}

/* Header (h1-h6) */
h1, h2, h3, h4, h5, h6 {
    font-size: 0.65rem; /* Ukuran lebih kecil untuk heading */
}

/* Container */
.container {
    padding-left: 0.75rem; /* Padding kiri lebih kecil */
    padding-right: 0.75rem; /* Padding kanan lebih kecil */
    max-width: 900px; /* Atur lebar maksimum container lebih kecil */
}

/* Row */
.row {
    margin-left: 0; /* Menghilangkan margin negatif */
    margin-right: 0; /* Menghilangkan margin negatif */
}

/* Col */
.col {
    padding-left: 0.25rem; /* Padding kiri kolom lebih kecil */
    padding-right: 0.25rem; /* Padding kanan kolom lebih kecil */
}

/* Navbar */
.navbar {
    padding: 0.5rem 1rem; /* Padding navbar lebih kecil */
    font-size: 0.65rem; /* Ukuran font navbar */
}

.navbar-brand {
    font-size: 0.65rem; /* Ukuran font brand */
}

.nav-link {
    font-size: 0.65rem; /* Ukuran font link */
}

/* Card */
.card {
    padding: 0.5rem; /* Padding lebih kecil */
    margin-bottom: 1rem; /* Jarak bawah kartu lebih kecil */
    font-size: 0.65rem; /* Ukuran font lebih kecil */
}

.card-header {
    font-size: 0.65rem; /* Ukuran font header kartu */
    padding: 0.5rem; /* Padding header lebih kecil */
}

.card-body {
    font-size: 0.65rem; /* Ukuran font body kartu */
    padding: 0.5rem; /* Padding body lebih kecil */
}

.card-footer {
    font-size: 0.65rem; /* Ukuran font footer kartu */
    padding: 0.5rem; /* Padding footer lebih kecil */
}

.card-title {
    font-size: 0.65rem; /* Ukuran font judul kartu lebih kecil */
}

.card-subtitle {
    font-size: 0.65rem; /* Ukuran font subtitle kartu */
}

/* Card Media */
.card-img-top, .card-img-bottom {
    max-width: 100%; /* Membuat gambar di dalam kartu responsif */
    height: auto;
}

/* Card Links */
.card-link {
    font-size: 0.65rem; /* Ukuran font link dalam kartu */
}

/* Tabel */
.table {
    font-size: 0.65rem; /* Ukuran font tabel */
}

.table th, .table td {
    padding: 0.5rem; /* Padding sel tabel lebih kecil */
}

/* Formulir */
.form-control {
    font-size: 0.65rem; /* Ukuran font input formulir */
    padding: 0.25rem 0.5rem; /* Padding input formulir lebih kecil */
    border-radius: 0.25rem; /* Sudut input formulir lebih kecil */
}

.form-group {
    margin-bottom: 0.75rem; /* Jarak bawah grup formulir lebih kecil */
}

.form-label {
    font-size: 0.65rem; /* Ukuran font label formulir */
}

/* Footer */
.footer {
    font-size: 0.65rem; /* Ukuran font footer */
    padding: 0.5rem; /* Padding footer lebih kecil */
}

/* Alerts */
.alert {
    font-size: 0.65rem; /* Ukuran font alert */
    padding: 0.5rem 1rem; /* Padding alert lebih kecil */
}

/* Modal */
.modal-content {
    font-size: 0.65rem; /* Ukuran font modal */
    padding: 1rem; /* Padding modal lebih kecil */
}

/* Tooltip */
.tooltip {
    font-size: 0.65rem; /* Ukuran font tooltip */
}

/* Sidebar */
.sidebar {
    font-size: 0.65rem; /* Ukuran font untuk sidebar */
    padding: 0.75rem; /* Padding dalam sidebar lebih kecil */
    width: 150px; /* Lebar sidebar lebih kecil */
}

.sidebar-header {
    font-size: 0.65rem; /* Ukuran font header sidebar */
    padding: 0.5rem; /* Padding header sidebar lebih kecil */
}

.sidebar-body {
    font-size: 0.65rem; /* Ukuran font body sidebar */
    padding: 0.5rem; /* Padding body sidebar lebih kecil */
}

.sidebar-footer {
    font-size: 0.65rem; /* Ukuran font footer sidebar */
    padding: 0.5rem; /* Padding footer sidebar lebih kecil */
}

/* Sidebar Links */
.sidebar-link {
    font-size: 0.65rem; /* Ukuran font link dalam sidebar */
    padding: 0.25rem 0; /* Padding link sidebar lebih kecil */
}
/* Definisikan animasi gradien bergerak */
@keyframes gradientMove {
    0% {
        background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    }
    25% {
        background: linear-gradient(45deg, #002D72, #6777EF); /* Gradien terbalik */
    }
    50% {
        background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    }
    75% {
        background: linear-gradient(45deg, #002D72, #6777EF); /* Gradien terbalik */
    }
    100% {
        background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    }
}

/* Tombol */
.btn {
    font-size: 0.65rem; /* Ukuran font tombol lebih kecil */
    padding: 0.3rem 0.6rem; /* Padding tombol lebih kecil */
    border-radius: 0.3rem; /* Sudut tombol lebih kecil */
    font-weight: bold; /* Menebalkan teks tombol */
    text-transform: uppercase; /* Membuat teks tombol kapitalisasi */
    letter-spacing: 0.5px; /* Spasi antara huruf */
    position: relative; /* Agar efek bayangan bisa ditempatkan dengan benar */
    overflow: hidden; /* Menyembunyikan elemen yang melampaui batas tombol */
    color: #fff; /* Warna teks tombol */
    border: none; /* Menghilangkan border default */
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien latar belakang */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    transition: all 0.3s ease; /* Transisi halus untuk efek hover */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol dengan ikon */
.btn .fa-trash {
    color: #FF5733; /* Warna merah untuk ikon */
}

/* Tombol dengan ikon saat hover */
.btn:hover .fa-trash {
    color: #FFC107; /* Warna kuning untuk ikon saat hover */
}

/* Tombol Utama */
.btn-primary {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Bayangan tombol lebih halus */
}

/* Tombol Sekunder */
.btn-secondary {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Sukses */
.btn-success {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Bahaya */
.btn-danger {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Peringatan */
.btn-warning {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Info */
.btn-info {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Light */
.btn-light {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Dark */
.btn-dark {
    background: linear-gradient(45deg, #6777EF, #002D72); /* Gradien dari biru muda ke biru tua */
    background-size: 200% 200%; /* Membuat gradien lebih besar dari tombol */
    animation: gradientMove 5s ease infinite; /* Menambahkan animasi gradien bergerak */
}

/* Tombol Link */
.btn-link {
    font-size: 0.65rem; /* Ukuran font tombol link */
    color: #6777EF; /* Warna teks tombol link */
    padding: 0; /* Tanpa padding */
    border-radius: 0; /* Tanpa sudut */
    background: none; /* Tanpa latar belakang */
    text-decoration: underline; /* Garis bawah untuk tombol link */
    transition: color 0.3s ease; /* Transisi halus untuk warna saat hover */
}

/* Tombol dengan ikon saat hover */
.btn:hover {
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.6); /* Bayangan putih saat hover */
}
 /* Menetapkan lebar maksimum untuk tabel */
 #myTable {
            max-width: 100%; /* Tabel mengikuti lebar kontainer */
            width: auto; /* Lebar otomatis berdasarkan konten */
            border-collapse: collapse; /* Menghindari spasi ganda antara border tabel */
            margin: 0 auto; /* Mengatur tabel agar berada di tengah kontainer */
        }

        /* Mengatur padding dan ukuran font untuk header tabel */
        #myTable thead th {
            padding: 0.5rem; /* Padding header tabel */
            font-size: 0.75rem; /* Ukuran font header tabel */
            text-align: left; /* Penataan teks header tabel */
        }

        /* Mengatur padding dan ukuran font untuk sel tabel */
        #myTable tbody td {
            padding: 0.5rem; /* Padding sel tabel */
            font-size: 0.75rem; /* Ukuran font sel tabel */
        }

        /* Mengatur tinggi baris tabel agar tidak terlalu tinggi */
        #myTable tbody tr {
            height: auto; /* Tinggi baris otomatis berdasarkan konten */
        }

        /* Mengatur lebar kolom agar sesuai */
        #myTable th, #myTable td {
            white-space: nowrap; /* Menghindari teks terputus */
            overflow: hidden; /* Menyembunyikan teks yang melebihi batas */
            text-overflow: ellipsis; /* Menambahkan ellipsis jika teks terlalu panjang */
        }

        /* Mengatur lebar tabel pada layar kecil */
        @media (max-width: 768px) {
            #myTable {
                font-size: 0.75rem; /* Ukuran font lebih kecil untuk layar kecil */
            }

            #myTable thead th, #myTable tbody td {
                padding: 0.25rem; /* Padding lebih kecil untuk layar kecil */
            }
        }

        
/* Media Queries untuk ukuran lebih kecil */
@media (max-width: 768px) {
    .sidebar {
        width: 100px; /* Lebar sidebar lebih kecil pada layar kecil */
    }

    body {
        font-size: 0.65rem; /* Ukuran font dasar untuk layar kecil */
    }

    .navbar {
        padding: 0.25rem 0.5rem; /* Padding navbar untuk layar kecil */
    }

    .card {
        padding: 0.25rem; /* Padding kartu untuk layar kecil */
    }

    .form-control {
        font-size: 0.6rem; /* Ukuran font input formulir untuk layar kecil */
        padding: 0.2rem 0.4rem; /* Padding input formulir lebih kecil untuk layar kecil */
    }
}

  </style>
</head>

<body>
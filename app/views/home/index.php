<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <h2>Selamat datang di halaman Library Management!</h2>
            </div>
            <div class="card-footer">
                
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kategori</span>
                        <span class="info-box-number display-4"><?= $data['jumlah_kategori']; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Buku</span>
                        <span class="info-box-number display-4"><?= $data['jumlah_buku']; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mahasiswa</span>
                        <span class="info-box-number display-4"><?= $data['jumlah_mahasiswa']; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Peminjaman</span>
                        <span class="info-box-number display-4"><?= $data['jumlah_peminjaman']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
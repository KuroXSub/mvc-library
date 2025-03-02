<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h2>Selamat datang di halaman Library Management!</h2>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
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
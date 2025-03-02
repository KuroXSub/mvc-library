<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Edit Peminjaman</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center"><?= htmlspecialchars($data['title']); ?></h3>
                    </div>
                    <form role="form" action="<?= base_url; ?>/peminjaman/updatePeminjaman" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                        <input type="hidden" name="id" value="<?= intval($data['peminjaman']['id']); ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <input type="text" class="form-control" value="<?= isset($data['peminjaman']['nama_mahasiswa']) ? htmlspecialchars($data['peminjaman']['nama_mahasiswa']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Judul Buku</label>
                                <input type="text" class="form-control" value="<?= isset($data['peminjaman']['judul_buku']) ? htmlspecialchars($data['peminjaman']['judul_buku']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pinjam</label>
                                <input type="text" class="form-control" value="<?= isset($data['peminjaman']['tanggal_pinjam']) ? htmlspecialchars($data['peminjaman']['tanggal_pinjam']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali" required>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
                            <a href="<?= base_url; ?>/peminjaman" class="btn btn-danger ml-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
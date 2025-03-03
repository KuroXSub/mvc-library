<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Edit Pengembalian</h1>
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
                    <form role="form" action="<?= base_url; ?>/pengembalian/updatePengembalian" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                        <input type="hidden" name="id" value="<?= intval($data['pengembalian']['id']); ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <input type="text" class="form-control" value="<?= isset($data['pengembalian']['nama_mahasiswa']) ? htmlspecialchars($data['pengembalian']['nama_mahasiswa']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Judul Buku</label>
                                <input type="text" class="form-control" value="<?= isset($data['pengembalian']['judul_buku']) ? htmlspecialchars($data['pengembalian']['judul_buku']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pinjam</label>
                                <input type="text" class="form-control" value="<?= isset($data['pengembalian']['tanggal_pinjam']) ? htmlspecialchars($data['pengembalian']['tanggal_pinjam']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kembali</label>
                                <input type="text" class="form-control" value="<?= isset($data['pengembalian']['tanggal_kembali']) ? htmlspecialchars($data['pengembalian']['tanggal_kembali']) : 'Data tidak tersedia'; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Denda</label>
                                <input type="number" class="form-control" name="denda" value="<?= htmlspecialchars($data['pengembalian']['denda']); ?>" required>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Update Denda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
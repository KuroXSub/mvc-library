<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Tambah Peminjaman</h1>
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
                    <form role="form" action="<?= base_url; ?>/peminjaman/simpanPeminjaman" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select class="form-control" name="mahasiswa_id" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    <?php foreach ($data['mahasiswa'] as $mahasiswa) : ?>
                                        <option value="<?= intval($mahasiswa['id']); ?>"><?= htmlspecialchars($mahasiswa['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Buku</label>
                                <select class="form-control" name="buku_id" required>
                                    <option value="">Pilih Buku</option>
                                    <?php foreach ($data['buku'] as $buku) : ?>
                                        <option value="<?= intval($buku['id']); ?>"><?= htmlspecialchars($buku['judul']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url; ?>/peminjaman" class="btn btn-danger ml-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Peminjaman</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= htmlspecialchars($data['title']); ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
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
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
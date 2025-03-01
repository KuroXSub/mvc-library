<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Buku</h1>
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
            <form role="form" action="<?= base_url; ?>/buku/updateBuku" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= intval($data['buku']['id']); ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" placeholder="masukkan judul buku..." name="judul" value="<?= htmlspecialchars($data['buku']['judul']); ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Penulis</label>
                        <input type="text" class="form-control" placeholder="masukkan penulis buku..." name="penulis" value="<?= htmlspecialchars($data['buku']['penulis']); ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="number" class="form-control" placeholder="masukkan tahun buku..." name="tahun_terbit" value="<?= intval($data['buku']['tahun_terbit']); ?>" maxlength="4" min="1901" max="2155" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="kategori_id" required>
                            <option value="">Pilih</option>
                            <?php foreach ($data['kategori'] as $row) : ?>
                                <option value="<?= intval($row['id']); ?>" <?= ($data['buku']['kategori_id'] == $row['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($row['nama_kategori']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" placeholder="masukkan stok buku..." name="stok" value="<?= intval($data['buku']['stok']); ?>" required>
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
<!-- /.content-wrapper -->
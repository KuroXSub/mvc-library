<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center"> <h1>Tambah Buku</h1>
                </div>
            </div>
        </div></section>

    <section class="content">
        <div class="row justify-content-center"> <div class="col-md-8"> <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center"><?= htmlspecialchars($data['title']); ?></h3> </div>
                    <form role="form" action="<?= base_url; ?>/buku/simpanbuku" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" placeholder="masukkan judul buku..." name="judul" maxlength="255" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Penulis</label>
                                <input type="text" class="form-control" placeholder="masukkan penulis buku..." name="penulis" maxlength="100" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="number" class="form-control" placeholder="masukkan tahun buku..." name="tahun_terbit" maxlength="4" min="1901" max="2155" required>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="kategori_id" required>
                                    <option value="">Pilih</option>
                                    <?php foreach ($data['kategori'] as $row) : ?>
                                        <option value="<?= intval($row['id']); ?>"><?= htmlspecialchars($row['nama_kategori']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" class="form-control" placeholder="masukkan stok buku..." name="stok" maxlength="3" required>
                            </div>
                        </div>
                        <div class="card-footer text-center"> <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url; ?>/buku" class="btn btn-danger ml-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Halaman Buku</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <?php Flasher::flash(); ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= htmlspecialchars($data['title']); ?></h3>
                <a href="<?= base_url; ?>/buku/tambah" class="btn float-right btn-xs btn btn-primary">Tambah Buku</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url; ?>/buku/cari" method="post">
                    <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari judul buku..." name="key" autocomplete="off" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari Data</button>
                                    <a class="btn btn-outline-danger" href="<?= base_url; ?>/buku/reset">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = ($data['currentPage'] - 1) * 10 + 1; ?>
                        <?php foreach ($data['buku'] as $row) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= htmlspecialchars($row['penulis']); ?></td>
                                <td><div class="badge badge-warning"><?= htmlspecialchars($row['nama_kategori']); ?></div></td>
                                <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                                <td><?= htmlspecialchars($row['stok']); ?></td>
                                <td>
                                    <a href="<?= base_url; ?>/buku/edit/<?= intval($row['id']); ?>" class="badge badge-info">Edit</a>
                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#hapusModal<?= intval($row['id']); ?>">Hapus</a>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="hapusModal<?= intval($row['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus buku "<?= htmlspecialchars($row['judul']); ?>" oleh "<?= htmlspecialchars($row['penulis']); ?>"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="<?= base_url; ?>/buku/hapus/<?= intval($row['id']); ?>" method="post" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if (isset($data['currentPage']) && $data['currentPage'] > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url; ?>/buku?page=<?= $data['currentPage'] - 1; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($data['totalPages'])) : ?>
                            <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
                                <li class="page-item <?= (isset($data['currentPage']) && $i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?= base_url; ?>/buku?page=<?= $i; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>

                        <?php if (isset($data['currentPage']) && isset($data['totalPages']) && $data['currentPage'] < $data['totalPages']) : ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url; ?>/buku?page=<?= $data['currentPage'] + 1; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Halaman Peminjaman</h1>
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
                <a href="<?= base_url; ?>/peminjaman/tambah" class="btn float-right btn-xs btn btn-primary">Tambah Peminjaman</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url; ?>/peminjaman/cari" method="post">
                    <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari Nama Mahasiswa, Judul Buku, atau Petugas..." name="key" autocomplete="off" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari Data</button>
                                    <a class="btn btn-outline-danger" href="<?= base_url; ?>/peminjaman/reset">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = ($data['currentPage'] - 1) * 10 + 1; ?>
                        <?php foreach ($data['peminjaman'] as $row) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pinjam']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal_kembali'] ?? '-'); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'dipinjam') : ?>
                                        <span class="badge badge-warning">Dipinjam</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'dipinjam') : ?>
                                        <a href="<?= base_url; ?>/peminjaman/edit/<?= intval($row['id']); ?>" class="badge badge-info">Kembalikan</a>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Selesai</span>
                                    <?php endif; ?>
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
                                <a class="page-link" href="<?= base_url; ?>/peminjaman?page=<?= $data['currentPage'] - 1; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($data['totalPages'])) : ?>
                            <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
                                <li class="page-item <?= (isset($data['currentPage']) && $i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?= base_url; ?>/peminjaman?page=<?= $i; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>

                        <?php if (isset($data['currentPage']) && isset($data['totalPages']) && $data['currentPage'] < $data['totalPages']) : ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url; ?>/peminjaman?page=<?= $data['currentPage'] + 1; ?><?= isset($data['key']) ? '&key=' . urlencode($data['key']) : ''; ?>" aria-label="Next">
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
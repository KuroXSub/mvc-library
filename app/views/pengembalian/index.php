<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Halaman Pengembalian</h1>
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
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data['pengembalian'] as $row) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pinjam']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal_kembali']); ?></td>
                                <td><?= 'Rp ' . number_format($row['denda'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="<?= base_url; ?>/pengembalian/edit/<?= intval($row['id']); ?>" class="badge badge-info">Edit Denda</a>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
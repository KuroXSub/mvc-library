<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Mahasiswa</h1>
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
            <form role="form" action="<?= base_url; ?>/mahasiswa/updateMahasiswa" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''; ?>">
                <input type="hidden" name="id" value="<?= intval($data['mahasiswa']['id']); ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" class="form-control" placeholder="Masukkan NIM..." name="nim" value="<?= htmlspecialchars($data['mahasiswa']['nim']); ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama..." name="nama" value="<?= htmlspecialchars($data['mahasiswa']['nama']); ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <input type="text" class="form-control" placeholder="Masukkan jurusan..." name="jurusan" value="<?= htmlspecialchars($data['mahasiswa']['jurusan']); ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" placeholder="Masukkan alamat..." name="alamat" rows="3" required><?= htmlspecialchars($data['mahasiswa']['alamat']); ?></textarea>
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
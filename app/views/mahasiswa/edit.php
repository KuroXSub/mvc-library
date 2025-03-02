<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Edit Mahasiswa</h1>
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
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url; ?>/mahasiswa" class="btn btn-danger ml-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
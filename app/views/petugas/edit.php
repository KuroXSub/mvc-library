<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Petugas</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $data['title']; ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="<?= base_url; ?>/petugas/updatePetugas" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="id" value="<?= $data['petugas']['id']; ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="masukkan nama..." name="nama" value="<?= htmlspecialchars($data['petugas']['nama'], ENT_QUOTES, 'UTF-8'); ?>" autofocus required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="masukkan username..." name="username" value="<?= htmlspecialchars($data['petugas']['username'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                    </div>
                    <blockquote class="quote-warning">Abaikan jika tidak ingin mengganti password.</blockquote>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="masukkan password..." name="password">
                    </div>
                    <div class="form-group">
                        <label>Ulangi Password</label>
                        <input type="password" class="form-control" name="ulangi_password">
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
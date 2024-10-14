<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna</h1>
    </div>

    <?php if (session()->has('message')): ?>
    <div class="alert alert-success">
        <?= session('message') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow ">

        <div class="card-body">
            <form action="/Pengguna/simpanPengguna" method="post">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Nama</label>
                        <input type="text" name="nama" class="form-control" id="validationDefault01"
                            value="<?= old('nama') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault02">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="validationDefault02"
                            value="<?= old('alamat') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Username</label>
                        <input type="text" name="username" class="form-control" id="validationDefault01"
                            value="<?= old('username') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault02">Password</label>
                        <input type="text" name="password" class="form-control" id="validationDefault02" required>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="col-md-4 mb-3">
                        <label for="validationDefault02">Role</label>
                        <select class="form-control" name="role" id="validationDefault02" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="btntambahform">
                        <a class="" href="/Pengguna"><button type="button"
                                class=" btn btn-secondary mb-md-n3 btnformtambah">Batal</button></a>
                        <button type="submit" class=" btn btn-primary mb-md-n3 btnformtambah">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?= $this->endSection(); ?>
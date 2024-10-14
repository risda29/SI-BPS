<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang</h1>
    </div>
    <!-- Notifications -->
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
            <form action="<?= base_url('/Barang/simpanBarang') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal') ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jenis_barang">Jenis Barang</label>
                        <select name="jenis_barang" class="form-control" id="exampleFormControlSelect1" required>
                            <option>Obat</option>
                            <option>Skincare</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="<?= old('nama_barang') ?>"
                            id="nama_barang" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="harga_barang">Harga</label>
                        <input type="text" name="harga_barang" class="form-control" id="harga_barang"
                            value="<?= old('harga_barang') ?>" required>
                    </div>
                </div>
                <div class=" form-row align-items-center">
                    <div class="col-md-4 mb-3">
                        <label for="stok_barang">Stok</label>
                        <input type="number" name="stok_barang" class="form-control" id="stok_barang"
                            value="<?= old('stok_barang') ?>" required>
                    </div>
                    <div class=" btntambahform">
                        <a href="/Barang" class="d-none d-sm-inline-block shadow-sm">
                            <button type="button" class="btn btn-secondary mb-md-n3 btnformtambah">Batal</button>
                        </a>
                        <button type="submit" class="btn btn-primary mb-md-n3 btnformtambah">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>
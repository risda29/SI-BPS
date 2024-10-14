<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Barang</h1>
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
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('/Barang/UbahBarang') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id_barang'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $barang['tanggal'] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jenis_barang">Jenis Barang</label>
                        <select name="jenis_barang" class="form-control" id="jenis_barang" required>
                            <option value="obat" <?= $barang['jenis_barang'] == 'obat' ? 'selected' : '' ?>>Obat</option>
                            <option value="skincare" <?= $barang['jenis_barang'] == 'skincare' ? 'selected' : '' ?>>Skincare</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="<?= $barang['nama_barang'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" class="form-control" id="harga" value="<?= $barang['harga'] ?>" required>
                    </div>
                </div>
                
                <div class="form-row align-items-center">
                    <div class="col-md-4 mb-3">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" value="<?= $barang['stok'] ?>" required>
                    </div>
                    <div class="btntambahform">
                        <a href="/Barang" class="d-none d-sm-inline-block shadow-sm">
                            <button type="button" class="btn btn-secondary mb-md-n3 btnformtambah">Batal</button>
                        </a>
                        <button type="submit" class="btn btn-primary mb-md-n3 btnformtambah">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>

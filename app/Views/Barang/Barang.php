<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang</h1>
        <a href="/TambahBarang" class="d-none d-sm-inline-block btn btn-primary shadow-sm">Tambah</a>
    </div>
    <!-- Notifications -->
    <?php if (session()->has('message')) : ?>
    <div class="alert alert-success">
        <?= session('message') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
    <?php endif; ?>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($barang as $brg) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $brg['tanggal'] ?></td>
                            <td><?= $brg['jenis_barang'] ?></td>
                            <td><?= $brg['nama_barang'] ?></td>
                            <td><?= $brg['harga'] ?></td>
                            <td><?= $brg['stok'] ?></td>
                            <td><?= $brg['username'] ?></td>


                            <td>
                                <div class="btn-group" role="group">
                                    <a href="#" data-toggle="modal" data-target="#hapusbarangmodal"
                                        data-id="<?= $brg['id_barang'] ?>">
                                        <button type="button" class="btn btn-outline-danger btn-sm"><img
                                                class="fotoicontabel" src="icons/delete.svg" alt="Hapus"></button>
                                    </a>

                                    <a href="/UbahBarang<?= $brg['id_barang'] ?>"><button type="button"
                                            class="btn btn-outline-warning btn-sm"><img class="fotoicontabel"
                                                src="icons/edit.svg" alt="Ubah"></button></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="hapusbarangmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Yakin Ingin Menghapus Data Barang ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <form action="/HapusBarang/<?= $brg['id_barang'] ?>" method="get" style="display:inline;">
                    <button type="submit" class="btn btn-primary">Yakin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#hapusbarangmodal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var deleteUrl = '/HapusBarang/' + id;
    var modal = $(this);
    modal.find('#confirm-delete-btn').attr('href', deleteUrl);
});
</script>

<?= $this->endSection(); ?>
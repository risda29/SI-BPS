<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
        <a href="/TambahPengguna" class="d-none d-sm-inline-block btn btn-primary shadow-sm">Tambah</a>
    </div>
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
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Username</th>

                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pengguna as $penggunaa) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $penggunaa['nama'] ?></td>
                            <td><?= $penggunaa['alamat'] ?></td>
                            <td><?= $penggunaa['username'] ?></td>

                            <td><?= $penggunaa['role'] ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/Ubahpengguna<?= $penggunaa['username'] ?>"><button type="button"
                                            class="btn btn-outline-warning btn-sm"><img class="fotoicontabel"
                                                src="icons/edit.svg" alt="Ubah"></button></a>
                                    <a href="#" data-toggle="modal" data-target="#hapuspenggunamodal"
                                        data-id="<?= $penggunaa['username'] ?>"><button type="button"
                                            class="btn btn-outline-danger btn-sm"><img class="fotoicontabel"
                                                src="icons/delete.svg" alt="Hapus"></button></a>

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
<!-- /.container-fluid -->
<div class="modal fade" id="hapuspenggunamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Apakah anda Yakin Ingin Menghapus Data Pengguna ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" id="confirm-delete-btn" href="#">Yakin</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#hapuspenggunamodal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var penggunaId = button.data('id');
        var deleteUrl = '/HapusPengguna/' + penggunaId;
        $('#confirm-delete-btn').attr('href', deleteUrl);
    });
});
</script>
<?= $this->endSection(); ?>
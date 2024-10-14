<!-- Page Content -->
<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <a href="/TambahTransaksi" class="d-none d-sm-inline-block btn btn-primary shadow-sm">Tambah</a>
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
                            <th>Jenis Transaksi</th>
                            <th>Jumlah Barang</th>
                            <th>Harga Total</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($transaksi as $trans) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $trans['tanggal_transaksi'] ?></td>
                            <td><?= $trans['jenis_transaksi'] ?></td>
                            <td><?= $trans['jumlah_barang'] ?></td>
                            <td><?= $trans['harga_total'] ?></td>
                            <td><?= $trans['id_pengguna'] ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                        data-target="#modaltransaksi" data-id="<?= $trans['id_transaksi'] ?>"><img
                                            class="fotoicontabel" src="icons/visibility.svg" alt="Detail"></button>
                                    <a href="#" data-toggle="modal" data-target="#hapustransaksimodal"
                                        data-id="<?= $trans['id_transaksi'] ?>"><button type="button"
                                            class="btn btn-outline-danger btn-sm"><img class="fotoicontabel"
                                                src="icons/delete.svg" alt="Hapus"></button></a>
                                    <a href="/UbahTransaksi<?= $trans['id_transaksi'] ?>"><button type="button"
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

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="modaltransaksi" tabindex="-1" role="dialog" aria-labelledby="modalTransaksiLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTransaksiLabel">Data Detail Transaksi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="card-text">
                    ID Transaksi: <span id="detail-id-transaksi"></span><br>
                    Tanggal: <span id="detail-tanggal"></span><br>
                    Jenis Transaksi: <span id="detail-jenis"></span><br>
                    Jumlah Barang: <span id="detail-jumlah"></span><br>
                    Total Harga: <span id="detail-total"></span><br>
                    Pengguna: <span id="detail-pengguna"></span><br>
                    <br>
                    <strong>Barang:</strong>
                <ul id="detail-barang"></ul>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapustransaksimodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda Yakin Ingin Menghapus Data Transaksi ini?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-primary" id="confirm-delete-btn" href="#">Yakin</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mengatur modal detail transaksi
    $('#modaltransaksi').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var transaksiId = button.data('id');

        $.ajax({
            url: '/Transaksi/Detail/' + transaksiId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#detail-id-transaksi').text(data.transaksi.id_transaksi);
                $('#detail-tanggal').text(data.transaksi.tanggal_transaksi);
                $('#detail-jenis').text(data.transaksi.jenis_transaksi);
                $('#detail-jumlah').text(data.transaksi.jumlah_barang);
                $('#detail-total').text(data.transaksi.harga_total);
                $('#detail-pengguna').text(data.transaksi.id_pengguna);
                $('#detail-barang').empty();

                data.barang.forEach(function(item) {
                    $('#detail-barang').append('<li>' + item.nama_barang +
                        ' (Jumlah: ' + item.jumlah + ', Harga: ' + item.harga +
                        ')</li>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Mengatur modal hapus transaksi
    $('#hapustransaksimodal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var transaksiId = button.data('id');
        var deleteUrl = '/HapusTransaksi/' + transaksiId;
        $('#confirm-delete-btn').attr('href', deleteUrl);
    });
});
</script>
<?= $this->endSection(); ?>
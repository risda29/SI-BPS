<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Transaksi</h1>
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
    <div class="card shadow">
        <div class="card-body">
            <form action="/Transaksi/simpanTransaksi" method="post">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal_transaksi">Tanggal</label>
                        <input type="date" name="tanggal_transaksi" class="form-control" value="<?= date('Y-m-d') ?>"
                            required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jenis_transaksi">Jenis Transaksi</label>
                        <select name="jenis_transaksi" class="form-control" required>
                            <option value="barang_masuk">Barang Masuk</option>
                            <option value="barang_keluar">Barang Keluar</option>
                        </select>
                    </div>
                </div>

                <div id="barang-container">
                    <div class="form-row barang-item">
                        <div class="form-group col-md-2">
                            <label for="id_barang[]">Pilih Barang</label>
                            <select name="id_barang[]" class="form-control" required onchange="updateBarangInfo(this)">
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach($barang as $b): ?>
                                <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga'] ?>"
                                    data-stok="<?= $b['stok'] ?>"><?= $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="harga_barang[]">Harga</label>
                            <input type="text" name="harga_barang[]" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="stok_barang[]">Stok</label>
                            <input type="number" name="stok_barang[]" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="jumlah_barang[]">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang[]" class="form-control" required
                                oninput="calculateTotal(this)">
                            <small class="form-text text-danger stok-warning" style="display: none;">Jumlah melebihi
                                stok!</small>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="harga_total[]">Total Harga</label>
                            <input type="text" name="harga_total[]" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label><br></label>
                            <!-- <input type=" number" name="harga_total[]" class="" readonly> -->

                            <button type="button" class="btn btn-danger form-control btn-remove-barang">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <a href="/Transaksi" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <button type="button" class="btn btn-primary" id="btn-tambah-barang">Tambah Barang</button>
                        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal_transaksi"]').value = today;

    document.getElementById('btn-tambah-barang').addEventListener('click', function() {
        var barangContainer = document.getElementById('barang-container');
        var newBarangItem = barangContainer.children[0].cloneNode(true);
        resetBarangItem(newBarangItem);
        barangContainer.appendChild(newBarangItem);
        updateBarangOptions();
    });

    document.getElementById('barang-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-barang')) {
            e.target.closest('.barang-item').remove();
            updateBarangOptions();
        }
    });

    document.getElementById('barang-container').addEventListener('change', function(e) {
        if (e.target.name === 'id_barang[]') {
            updateBarangInfo(e.target);
        }
    });

    document.getElementById('barang-container').addEventListener('input', function(e) {
        if (e.target.name === 'jumlah_barang[]') {
            calculateTotal(e.target);
        }
    });

    function formatHarga(harga) {
        return harga.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    function updateBarangInfo(select) {
        var selectedOption = select.options[select.selectedIndex];
        var harga = selectedOption.getAttribute('data-harga');
        var stok = selectedOption.getAttribute('data-stok');
        var barangItem = select.closest('.barang-item');
        barangItem.querySelector('input[name="harga_barang[]"]').value = formatHarga(harga);
        barangItem.querySelector('input[name="stok_barang[]"]').value = stok;
        calculateTotal(barangItem.querySelector('input[name="jumlah_barang[]"]'));
        updateBarangOptions();
    }

    function calculateTotal(input) {
        var barangItem = input.closest('.barang-item');
        var harga = barangItem.querySelector('input[name="harga_barang[]"]').value;
        var stok = barangItem.querySelector('input[name="stok_barang[]"]').value;
        var jumlah = input.value;
        var totalHarga = barangItem.querySelector('input[name="harga_total[]"]');
        var stokWarning = barangItem.querySelector('.stok-warning');

        if (parseInt(jumlah) > parseInt(stok)) {
            stokWarning.style.display = 'block';
        } else {
            stokWarning.style.display = 'none';
        }

        if (!isNaN(harga) && !isNaN(jumlah) && harga !== '' && jumlah !== '') {
            var total = parseInt(harga.replace(/\./g, '')) * parseInt(jumlah);
            totalHarga.value = formatHarga(total);
        } else {
            totalHarga.value = '';
        }
    }

    function updateBarangOptions() {
        var selectedBarang = Array.from(document.querySelectorAll('select[name="id_barang[]"]')).map(function(
            select) {
            return select.value;
        });

        document.querySelectorAll('select[name="id_barang[]"]').forEach(function(select) {
            Array.from(select.options).forEach(function(option) {
                if (selectedBarang.includes(option.value) && option.value !== select.value) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            });
        });
    }

    function resetBarangItem(barangItem) {
        barangItem.querySelector('select[name="id_barang[]"]').value = '';
        barangItem.querySelector('input[name="harga_barang[]"]').value = '';
        barangItem.querySelector('input[name="stok_barang[]"]').value = '';
        barangItem.querySelector('input[name="jumlah_barang[]"]').value = '';
        barangItem.querySelector('input[name="harga_total[]"]').value = '';
        barangItem.querySelector('.stok-warning').style.display = 'none';
    }
});
</script>

<?= $this->endSection(); ?>
<?= $this->extend('Layout/index'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Transaksi</h1>
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

    <div class="card shadow">
        <div class="card-body">
            <form action="/Transaksi/UbahTransaksi" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?= $transaksi['id_transaksi'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal_transaksi">Tanggal</label>
                        <input type="date" name="tanggal_transaksi" class="form-control"
                            value="<?= $transaksi['tanggal_transaksi'] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jenis_transaksi">Jenis Transaksi</label>
                        <select name="jenis_transaksi" class="form-control" required>
                            <option value="barang_masuk"
                                <?= $transaksi['jenis_transaksi'] == 'barang_masuk' ? 'selected' : '' ?>>Barang Masuk
                            </option>
                            <option value="barang_keluar"
                                <?= $transaksi['jenis_transaksi'] == 'barang_keluar' ? 'selected' : '' ?>>Barang Keluar
                            </option>
                        </select>
                    </div>
                </div>

                <div id="barang-container">
                    <?php foreach ($detailTransaksi as $detail): ?>
                    <div class="form-row barang-item">
                        <div class="form-group col-md-2">
                            <label for="id_barang[]">Pilih Barang</label>
                            <select name="id_barang[]" class="form-control" required onchange="updateBarangInfo(this)">
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($barang as $b): ?>
                                <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga'] ?>"
                                    data-stok="<?= $b['stok'] ?>"
                                    <?= $b['id_barang'] == $detail['id_barang'] ? 'selected' : '' ?>>
                                    <?= $b['nama_barang'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="harga_barang[]">Harga</label>
                            <input type="number" name="harga_barang[]" class="form-control"
                                value="<?= isset($detail['harga_barang']) ? $detail['harga_barang'] : '' ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="stok_barang[]">Stok</label>
                            <input type="number" name="stok_barang[]" class="form-control"
                                value="<?= isset($detail['stok_barang']) ? $detail['stok_barang'] : '' ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="jumlah_barang[]">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang[]" class="form-control"
                                value="<?= isset($detail['jumlah_barang']) ? $detail['jumlah_barang'] : '' ?>" required
                                oninput="calculateTotal(this)">
                            <small class="form-text text-danger stok-warning" style="display: none;">Jumlah melebihi
                                stok!</small>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="harga_total[]">Total Harga</label>
                            <input type="number" name="harga_total[]" class="form-control"
                                value="<?= isset($detail['harga_total']) ? $detail['harga_total'] : '' ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label><br></label>
                            <button type="button" class="btn form-control btn-danger btn-remove-barang">Hapus</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatHarga(harga) {
        return harga.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).replace(/,/g, '.');
    }

    function updateBarangInfo(select) {
        const selectedOption = select.options[select.selectedIndex];
        const barangItem = select.closest('.barang-item');
        const harga = selectedOption.getAttribute('data-harga') || '';
        const stok = selectedOption.getAttribute('data-stok') || '';

        barangItem.querySelector('input[name="harga_barang[]"]').value = formatHarga(harga);
        barangItem.querySelector('input[name="stok_barang[]"]').value = stok;

        calculateTotal(barangItem.querySelector('input[name="jumlah_barang[]"]'));
    }

    function calculateTotal(input) {
        const barangItem = input.closest('.barang-item');
        const harga = parseFloat(barangItem.querySelector('input[name="harga_barang[]"]').value.replace(/\./g,
            '')) || 0;
        const stok = parseInt(barangItem.querySelector('input[name="stok_barang[]"]').value) || 0;
        const jumlah = parseInt(input.value) || 0;
        const totalHarga = barangItem.querySelector('input[name="harga_total[]"]');
        const stokWarning = barangItem.querySelector('.stok-warning');

        if (jumlah > stok) {
            stokWarning.style.display = 'block';
            totalHarga.value = '';
        } else {
            stokWarning.style.display = 'none';
            totalHarga.value = formatHarga(harga * jumlah);
        }
    }

    function addBarangItem() {
        const container = document.getElementById('barang-container');
        const barangItemTemplate = `
            <div class="form-row barang-item">
                <div class="form-group col-md-2">
                    <label for="id_barang[]">Pilih Barang</label>
                    <select name="id_barang[]" class="form-control" required onchange="updateBarangInfo(this)">
                        <option value="">--Pilih Barang--</option>
                        <?php foreach ($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga'] ?>" data-stok="<?= $b['stok'] ?>">
                                <?= $b['nama_barang'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="harga_barang[]">Harga</label>
                    <input type="text" name="harga_barang[]" class="form-control" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="stok_barang[]">Stok</label>
                    <input type="text" name="stok_barang[]" class="form-control" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="jumlah_barang[]">Jumlah Barang</label>
                    <input type="number" name="jumlah_barang[]" class="form-control" required oninput="calculateTotal(this)">
                    <small class="form-text text-danger stok-warning" style="display: none;">Jumlah melebihi stok!</small>
                </div>
                <div class="form-group col-md-2">
                    <label for="harga_total[]">Total Harga</label>
                    <input type="text" name="harga_total[]" class="form-control" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label><br></label>
                    <button type="button" class="btn btn-danger form-control btn-remove-barang">Hapus</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', barangItemTemplate);

        const select = container.lastElementChild.querySelector('select[name="id_barang[]"]');
        updateBarangInfo(select);
    }

    document.getElementById('btn-tambah-barang').addEventListener('click', addBarangItem);
    document.getElementById('barang-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-barang')) {
            e.target.closest('.barang-item').remove();
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

    document.querySelectorAll('select[name="id_barang[]"]').forEach(function(select) {
        updateBarangInfo(select);
    });

    document.querySelectorAll('input[name="jumlah_barang[]"]').forEach(function(input) {
        input.addEventListener('input', function() {
            calculateTotal(this);
        });
    });
});
</script>

<?= $this->endSection(); ?>
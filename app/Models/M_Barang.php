<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['nama_barang', 'harga', 'jenis_barang', 'stok', 'tanggal', 'username'];

    public function updateStock($id_barang, $jumlah, $jenis_transaksi, $isReverting = false)
{
    $barang = $this->find($id_barang);
    if ($jenis_transaksi == 'barang_masuk') {
        $new_stok = $isReverting ? $barang['stok'] - $jumlah : $barang['stok'] + $jumlah;
    } else {
        $new_stok = $isReverting ? $barang['stok'] + $jumlah : $barang['stok'] - $jumlah;
    }
    if ($new_stok < 0) {
        $new_stok = 0;
    }
    $this->update($id_barang, ['stok' => $new_stok]);
}

    
}
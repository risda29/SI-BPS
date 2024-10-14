<?php 
namespace App\Models;

use CodeIgniter\Model;
class M_Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['jenis_transaksi', 'jumlah_barang', 'harga_total', 'id_pengguna', 'tanggal_transaksi'];
}
?>
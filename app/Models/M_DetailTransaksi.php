<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detailT';
    protected $allowedFields = ['id_transaksi', 'id_barang', 'jumlah_barang', 'harga_total'];
}
?>
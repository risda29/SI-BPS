<?php

namespace App\Controllers;

use App\Models\M_Transaksi;
use App\Models\M_DetailTransaksi;
use App\Models\M_Barang;

class Transaksi extends BaseController
{
    protected $transaksiModel;
    protected $barangModel;
    protected $detailTransaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new M_Transaksi();
        $this->barangModel = new M_Barang();
        $this->detailTransaksiModel = new M_DetailTransaksi();
    }

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->checkLogin();
    }
    public function index()
    {
        $data['transaksi'] = $this->transaksiModel->findAll();
        echo view('transaksi/Transaksi', $data);
    }


    public function detail($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);
        $detailTransaksi = $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->findAll();

        $barangDetails = [];
        foreach ($detailTransaksi as $detail) {
            $barang = $this->barangModel->find($detail['id_barang']);
            $barangDetails[] = [
                'nama_barang' => $barang['nama_barang'],
                'jumlah' => $detail['jumlah_barang'],
                'harga' => $detail['harga_total']
            ];
        }

        $data = [
            'transaksi' => $transaksi,
            'barang' => $barangDetails
        ];

        return $this->response->setJSON($data);
    }

    public function TambahTransaksi()
    {
        $data['barang'] = $this->barangModel->findAll();
        echo view('transaksi/tambahTransaksi', $data);
    }

    public function simpanTransaksi()
    {
        $session = session();
        $id_pengguna = $session->get('username');
        $jenis_transaksi = $this->request->getPost('jenis_transaksi');
        $tanggal_transaksi = $this->request->getPost('tanggal_transaksi');
        $id_barang = $this->request->getPost('id_barang');
        $jumlah_barang = $this->request->getPost('jumlah_barang');
        $harga_total = $this->request->getPost('harga_total');
    
        // Hitung total harga dan jumlah barang
        $total_harga = 0;
        foreach ($harga_total as $harga) {
            $total_harga += floatval(str_replace('.', '', $harga));
        }
    
        // Total harga tetap disimpan sebagai string dengan titik
        $total_harga_string = number_format($total_harga, 0, '', '.');
    
        $total_jumlah_barang = array_sum($jumlah_barang);
    
        $dataTransaksi = [
            'tanggal_transaksi' => $tanggal_transaksi,
            'jenis_transaksi' => $jenis_transaksi,
            'jumlah_barang' => $total_jumlah_barang,
            'harga_total' => $total_harga_string, // Simpan total harga dengan titik
            'id_pengguna' => $id_pengguna
        ];
    
        $this->transaksiModel->insert($dataTransaksi);
        $id_transaksi = $this->transaksiModel->insertID();
    
        foreach ($id_barang as $key => $id) {
            $dataDetail = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $id,
                'jumlah_barang' => $jumlah_barang[$key],
                'harga_total' => $harga_total[$key] // Simpan harga total sebagai string dengan titik
            ];
            $this->detailTransaksiModel->insert($dataDetail);
            $this->barangModel->updateStock($id, $jumlah_barang[$key], $jenis_transaksi);
        }
    
        return redirect()->to('/Transaksi')->with('message', 'Transaksi berhasil ditambahkan');
    }
    


    public function GetTransaksiByID($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);
        $detailTransaksi = $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->findAll();
        $barang = $this->barangModel->findAll();

        $data = [
            'transaksi' => $transaksi,
            'detailTransaksi' => $detailTransaksi,
            'barang' => $barang
        ];

        echo view('transaksi/UbahTransaksi', $data);
    }

    public function UbahTransaksi()
    {
        $id_transaksi = $this->request->getPost('id_transaksi');
        $jenis_transaksi_baru = $this->request->getPost('jenis_transaksi');
        $tanggal_transaksi = $this->request->getPost('tanggal_transaksi');
        $id_barang = $this->request->getPost('id_barang');
        $jumlah_barang = $this->request->getPost('jumlah_barang');
        $harga_total = $this->request->getPost('harga_total');
    
        // Hitung total harga dan jumlah barang
        $total_harga = 0;
        foreach ($harga_total as $harga) {
            $total_harga += floatval(str_replace('.', '', $harga));
        }
        // Total harga tetap disimpan sebagai string dengan titik
        $total_harga_string = number_format($total_harga, 0, '', '.');
    
        // Kalkulasi total jumlah barang
        $total_jumlah_barang = array_sum($jumlah_barang);
    
        // Data transaksi untuk update
        $dataTransaksi = [
            'tanggal_transaksi' => $tanggal_transaksi,
            'jenis_transaksi' => $jenis_transaksi_baru,
            'jumlah_barang' => $total_jumlah_barang,
            'harga_total' => $total_harga_string // Simpan total harga dengan titik
        ];
    
        $transaksi_lama = $this->transaksiModel->find($id_transaksi);
        $detailTransaksiLama = $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->findAll();
    
        if ($transaksi_lama['jenis_transaksi'] != $jenis_transaksi_baru) {
            foreach ($detailTransaksiLama as $detail) {
                $this->barangModel->updateStock($detail['id_barang'], $detail['jumlah_barang'], $transaksi_lama['jenis_transaksi'], true);
            }
        }
    
        $this->transaksiModel->update($id_transaksi, $dataTransaksi);
        $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->delete();
    
        foreach ($id_barang as $key => $id) {
            $dataDetail = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $id,
                'jumlah_barang' => $jumlah_barang[$key],
                'harga_total' => $harga_total[$key] // Simpan harga total sebagai string dengan titik
            ];
            $this->detailTransaksiModel->insert($dataDetail);
            $this->barangModel->updateStock($id, $jumlah_barang[$key], $jenis_transaksi_baru);
        }
    
        return redirect()->to('/Transaksi')->with('message', 'Transaksi berhasil diubah');
    }
    





    public function HapusTransaksi($id_transaksi)
    {
        $detailTransaksi = $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->findAll();
        foreach ($detailTransaksi as $detail) {
            $this->barangModel->updateStock($detail['id_barang'], $detail['jumlah_barang'], 'barang_masuk');
        }
        $this->detailTransaksiModel->where('id_transaksi', $id_transaksi)->delete();
        $this->transaksiModel->delete($id_transaksi);
        return redirect()->to('/Transaksi')->with('message', 'Transaksi berhasil dihapus');
    }
}
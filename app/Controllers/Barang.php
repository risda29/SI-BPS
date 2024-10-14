<?php

namespace App\Controllers;
use App\Models\M_Barang;

class Barang extends BaseController
{
    protected $barangModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->checkLogin();
        $this->barangModel = new M_Barang(); // Add this line
    }

    public function index()
    {
        $data['barang'] = $this->barangModel->findAll();
        echo view('barang/barang', $data);
    }

    public function TambahBarang()
    {
        $data['barang'] = $this->barangModel->findAll();
        echo view('barang/tambahBarang', $data);
    }

    public function simpanBarang()
    {
        $session = session();
        $id_pengguna = $session->get('username');

        if (empty($id_pengguna)) {
            session()->setFlashdata('error', 'Pengguna tidak terautentikasi.');
            return redirect()->to('/login'); 
        }

        $db = \Config\Database::connect();
        $builder = $db->table('pengguna');
        $pengguna = $builder->getWhere(['username' => $id_pengguna])->getFirstRow();

        if (empty($pengguna)) {
            session()->setFlashdata('error', 'Username tidak valid.');
            return redirect()->back()->withInput();
        }

        $nama_barang = $this->request->getPost('nama_barang');
        $tanggal = $this->request->getPost('tanggal');
        $harga = $this->request->getPost('harga_barang');
        $jenis_barang = $this->request->getPost('jenis_barang');
        $stok = $this->request->getPost('stok_barang');

        if (!preg_match('/^[a-zA-Z\s]+$/', $nama_barang)) {
            session()->setFlashdata('error', 'Penulisan nama barang salah.');
            return redirect()->back()->withInput();
        }

        if (!preg_match('/^\d{1,3}(?:\.\d{3})*$/', $harga)) {
            session()->setFlashdata('error', 'Format harga tidak valid.');
            return redirect()->back()->withInput();
        }

        if (strlen($harga) <= 4) {
            session()->setFlashdata('error', 'Format harga tidak valid.');
            return redirect()->back()->withInput();
        }
        $harga_numeric = str_replace('.', '', $harga);

        if ($harga_numeric <= 1000) {
            session()->setFlashdata('error', 'Harga harus lebih dari 1000.');
            return redirect()->back()->withInput();
        }

        $dataBarang = [
            'nama_barang' => $nama_barang,
            'tanggal' => $tanggal,
            'harga' => $harga,
            'jenis_barang' => $jenis_barang,
            'stok' => $stok,
            'username' => $id_pengguna 
        ];

        $this->barangModel->insert($dataBarang);
        return redirect()->to('/Barang')->with('message', 'Barang berhasil ditambahkan');
    }

    public function GetBarangByID($id_barang)
    {
        $barang = $this->barangModel->find($id_barang);

        if (!$barang) {
            session()->setFlashdata('error', 'Barang tidak ditemukan');
            return redirect()->to('/Barang');
        }

        $data = [
            'barang' => $barang
        ];

        return view('barang/UbahBarang', $data);
    }

    public function UbahBarang()
    {
        $id_barang = $this->request->getPost('id_barang');
        $jenis_barang = $this->request->getPost('jenis_barang');
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $harga = $this->request->getPost('harga');
        $stok = $this->request->getPost('stok');

        //FORMAT NAMA
        if (!preg_match('/^[a-zA-Z\s]+$/', $nama_barang)) {
            session()->setFlashdata('error', 'Penulisan nama barang salah.');
            return redirect()->back()->withInput();
        }

        if (!preg_match('/^\d{1,3}(?:\.\d{3})*$/', $harga)) {
            session()->setFlashdata('error', 'Format harga tidak valid.');
            return redirect()->back()->withInput();
        }

        if (strlen($harga) <= 4) {
            session()->setFlashdata('error', 'Format harga tidak valid.');
            return redirect()->back()->withInput();
        }

        $harga_numeric = str_replace('.', '', $harga);

        if ($harga_numeric <= 1000) {
            session()->setFlashdata('error', 'Harga harus lebih dari 1000.');
            return redirect()->back()->withInput();
        }
        
        // Data barang
        $dataBarang = [
            'tanggal' => $tanggal,
            'jenis_barang' => $jenis_barang,
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'stok' => $stok,
        ];

        $this->barangModel->update($id_barang, $dataBarang);

        session()->setFlashdata('message', 'Barang berhasil diubah');
        return redirect()->to('/Barang');
    }

    public function hapusBarang($id)
    {
        if ($this->barangModel->delete($id)) {
            return redirect()->to('/Barang')->with('message', 'Barang berhasil dihapus.');
        } else {
            return redirect()->to('/Barang')->with('error', 'Gagal menghapus barang.');
        }
    }
}
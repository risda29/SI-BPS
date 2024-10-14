<?php

namespace App\Controllers;

use App\Models\M_Pengguna;

class Pengguna extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->checkLogin('admin');
    }

    public function index()
    {
        $penggunaModel = new M_Pengguna();
        $data['pengguna'] = $penggunaModel->findAll();

        echo view('pengguna/Pengguna', $data);
    }

    public function TambahPengguna()
    {
        echo view('pengguna/TambahPengguna');
    }

    public function UbahPengguna()
    {
        echo view('pengguna/UbahPengguna');
    }

    public function SimpanPengguna()
    {
        $penggunaModel = new M_Pengguna();
        $username = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        // Aturan validasi password
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Password harus minimal 8 karakter.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password harus mengandung setidaknya satu huruf besar.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password harus mengandung setidaknya satu huruf kecil.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password harus mengandung setidaknya satu angka.";
        }
        if (!preg_match('/[\W]/', $password)) {
            $errors[] = "Password harus mengandung setidaknya satu karakter khusus.";
        }

        // Jika ada error, kembalikan dengan pesan error
        if (!empty($errors)) {
            return redirect()->back()->with('error', implode('<br>', $errors))->withInput();
        }

        // Jika tidak ada error, hash password dan simpan pengguna
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $penggunaModel->set([
            'username' => $username,
            'nama' => $nama,
            'alamat' => $alamat,
            'password' => $hashedPassword,
            'role' => $role,
        ])->insert();

        return redirect()->to('/Pengguna')->with('message', 'Pengguna berhasil ditambah.');
    }

    public function HapusPengguna($username)
    {
        $penggunaModel = new M_Pengguna();
        $penggunaModel->where('username', $username)->delete();

        return redirect()->to('/Pengguna')->with('message', 'Pengguna berhasil dihapus.');
    }

    public function getPengguna($username)
    {
        $penggunaModel = new M_Pengguna();
        $result = $penggunaModel->find($username);

        $data = [
            'username' => $result['username'],
            'nama' => $result['nama'],
            'alamat' => $result['alamat'],
            'password' => $result['password'],
            'role' => $result['role'],
        ];

        echo view('Pengguna/UbahPengguna', $data);
    }

    public function updatePengguna($username)
    {
        $penggunaModel = new M_Pengguna();
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $role = $this->request->getPost('role');
        $password = $this->request->getPost('password');

        // Array untuk menyimpan data yang akan diupdate
        $dataToUpdate = [
            'nama' => $nama,
            'alamat' => $alamat,
            'role' => $role
        ];

        // Jika password diisi, lakukan validasi
        if (!empty($password)) {
            $errors = [];
            if (strlen($password) < 8) {
                $errors[] = "Password harus minimal 8 karakter.";
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors[] = "Password harus mengandung setidaknya satu huruf besar.";
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors[] = "Password harus mengandung setidaknya satu huruf kecil.";
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Password harus mengandung setidaknya satu angka.";
            }
            if (!preg_match('/[\W]/', $password)) {
                $errors[] = "Password harus mengandung setidaknya satu karakter khusus.";
            }

            // Jika ada error, kembalikan dengan pesan error
            if (!empty($errors)) {
                return redirect()->back()->with('error', implode('<br>', $errors))->withInput();
            }

            // Hash password dan tambahkan ke dalam array dataToUpdate
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $dataToUpdate['password'] = $hashedPassword;
        }

        // Melakukan update pada database
        $penggunaModel->where('username', $username)->set($dataToUpdate)->update();
        return redirect()->to('/Pengguna')->with('message', 'Pengguna berhasil diubah.');
    }
}

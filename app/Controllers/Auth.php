<?php

namespace App\Controllers;

use App\Models\M_Pengguna;

class Auth extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new M_Pengguna();
    }

    public function index()
    {
        if ($this->session->get('logged_in')) {
            if ($this->session->get('role') == 'admin') {
                return redirect()->to('/Barang');
            } else {
                return redirect()->to('/Barang');
            }
        }
        return view('Auth/login');
    }

    public function login()
    {
        if ($this->session->get('logged_in')) {
            if ($this->session->get('role') == 'admin') {
                return redirect()->to('/Barang');
            } else {
                return redirect()->to('/Barang');
            }
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $validationRules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('/')->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->model->checkCredentials($username, $password);

        if ($user) {
            $session = session();
            $session->set('logged_in', true);
            $session->set('username', $user['username']);
            $session->set('role', $user['role']);

            if ($user['role'] == 'admin') {
                return redirect()->to('/Barang');
            } else {
                return redirect()->to('/Barang');
            }
        } else {
            return redirect()->to('/')->withInput()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/')->with('message', 'Anda telah keluar');
    }
}
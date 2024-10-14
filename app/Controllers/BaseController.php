<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;

    protected $helpers = [];
    
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Start session
        $this->session = \Config\Services::session();

        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');
    }

    protected function checkLogin($role = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Anda harus login untuk mengakses halaman ini');
        }

        if ($role !== null && $session->get('role') !== $role) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return true;
    }
}
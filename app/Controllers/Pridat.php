<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PridatZobrazit extends BaseController
{
    public function index()
    {
        echo view('add/pridani');
    }

    public function show(){
        echo view('add/import');
    }
}

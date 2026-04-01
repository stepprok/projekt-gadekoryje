<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Komponenty;
use App\Models\TypKomponent;
use App\Models\Vyrobce;
use CodeIgniter\HTTP\RequestInterface;
use Config\ConfigCau;
use Psr\Log\LoggerInterface;

class typKomponentC extends BaseController
{
    public $typKomponent;
    public $vyrobce;
    public $config;
    public $data;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->typKomponent = new TypKomponent();
        $this->vyrobce = new Vyrobce();

        $this->config = new ConfigCau();
        $this->data["typKomponent"] = $this->typKomponent->findAll();
    }

    public function index()
    {
        echo view('main/kategorie', $this->data);
    }

    public function edit(){
        echo view('add/edit',  $this->data);
    }

    public function add()
    {
        $data = [
            'typKomponent' => $this->request->getPost('násef'),
            'autor' => $this->request->getPost('autor'),
            'url' => strtolower($this->request->getPost('násef'))
        ];

        $this->typKomponent->save($data);

        return redirect()->to(base_url());
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'typKomponent' => $this->request->getPost('násef'),
            'autor' => $this->request->getPost('autor')
        ];

        $this->typKomponent->update($id, $data);

        return redirect()->to(base_url());
    }

    public function delete($id)
    {
        $this->typKomponent->delete($id, true);

        return redirect()->to(base_url());
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TypKomponent;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Pridat extends BaseController
{
    public $data;
    public $typKomponent;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->typKomponent = new TypKomponent();

        $this->data["typKomponent"] =  $this->typKomponent->findAll();
    }
    public function index()
    {
        echo view('add/pridani', $this->data);
    }

    public function show(){
        echo view('add/import', $this->data);
    }

    public function update(){
        $file = $this->request->getFile('csv_file');

        if ($file->isValid() && !$file->hasMoved()){
            $path = $file->getTempName();

            $handle = fopen($path, 'r');

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $this->typKomponent->table('typkomponent')->insert([
                    'typKomponent' => $data[0],
                    'url' => $data[1],
                    'autor' => $data[2]
                ]);
            }

            fclose($handle);

            return redirect()->route(base_url());

        }

        return "falsch";

        return redirect()->route(base_url());
    }
}

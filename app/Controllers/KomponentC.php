<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Komponent;
use App\Models\TypKomponent;
use App\Models\Vyrobce;
use App\Models\nazevParametr;
use CodeIgniter\HTTP\RequestInterface;
use Config\ConfigCau;
use Psr\Log\LoggerInterface;

class KomponentC extends BaseController
{
    public $typKomponent;
    public $vyrobce;
    public $komponent;
    public $config;
    public $nazevparametr;
    public $data;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->typKomponent = new TypKomponent();
        $this->komponent = new Komponent();
        $this->vyrobce = new Vyrobce();
        $this->nazevparametr = new nazevParametr();

        $this->config = new ConfigCau();

        $this->data["typKomponent"] =  $this->typKomponent->findAll();
    }

    public function index($url)
    {
        $id = $this->typKomponent->where('url', $url)->findAll()[0]->idKomponent;

        $this->data += [
            "nadpis" => $this->typKomponent->find($id),
            "komponent" => $this->typKomponent->join('komponent', 'komponent.typKomponent_id = typkomponent.idKomponent', 'left')->where('typKomponent_id', $id)->paginate($this->config->perPage),
            "vyrobce" => $this->vyrobce->findAll(),
            "vse" => $this->komponent->findAll(),
            
            "pager" => $this->typKomponent->pager
        ];

        echo view('main/komponenty', $this->data);
    }

    public function show($id)
    {
        $this->data += [
            "komponent" => $this->typKomponent->join('komponent', 'komponent.typKomponent_id = typkomponent.idKomponent', 'left')->join('parametr', 'parametr.komponent_id = komponent.id', 'left')->select('komponent.id AS komponent_id')->join('nazevparametr', 'nazevparametr.id = parametr.nazevParametr_id', 'left')->join('vyrobce', 'vyrobce.idVyrobce = komponent.vyrobce_id', 'left')->select('komponent.nazev AS komponent_nazev')->select('vyrobce.vyrobce AS vyrobce_nazev')->select('komponent.pic AS komponent_pic')->select('komponent.odkaz AS komponent_url')->select('typKomponent.typKomponent AS typKomponent')->select('parametr.hodnota AS velikost')->where('komponent.id', $id)->findAll(),
            "parametr" => $this->nazevparametr->join('parametr', 'parametr.nazevParametr_id = nazevparametr.id', 'left')->where('komponent_id', $id)->findAll(),
           
        ];

        echo view('main/item', $this->data);
    }

    public function add()
    {
        $data = [
            'nazev'          => $this->request->getPost('násef'),
            'odkaz'          => strtolower($this->request->getPost('odkaz')),
            'vyrobce_id'     => $this->request->getPost('vyrobce_id'),
            'typKomponent_id' => $this->request->getPost('typKomponent_id'),
        ];

        if (empty($data['vyrobce_id']) || empty($data['typKomponent_id'])) {
            return redirect()->back()->with('error', 'Musíte vybrat výrobce i typ komponentu!');
        }

        $this->komponent->insert($data);

        return redirect()->back()->with('success', 'Komponent byl přidán!');
    }
    public function update($id)
    {
        $volbaItem = $this->request->getPost('itemsD');
        return redirect()->to(base_url());
    }
}

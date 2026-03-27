<?php

namespace App\Controllers;

use App\Models\Komponent;
use Dompdf\Dompdf;

class ExportPDF extends BaseController
{
    public function index($id)
    {
        $db = \Config\Database::connect(); //pripojeni k databazi

        //mini join
        $data['komponent'] = $db->table('typkomponent')
            ->join('komponent', 'komponent.typKomponent_id = typkomponent.idKomponent', 'left') //joine komponent
            ->join('parametr', 'parametr.komponent_id = komponent.id', 'left') //parametry
            ->join('nazevparametr', 'nazevparametr.id = parametr.nazevParametr_id', 'left') //nazev parametr
            ->join('vyrobce', 'vyrobce.idVyrobce = komponent.vyrobce_id', 'left') //vyrobce
            ->select('komponent.id AS komponent_id') //prepise koponent.id na komponent_id
            ->select('komponent.nazev AS komponent_nazev') //nazev na komponent_nazev
            ->select('vyrobce.vyrobce AS vyrobce_nazev') //vyrboce na vyrobce_nazev
            ->select('komponent.pic AS komponent_pic') //pic na komponent_pic
            ->select('komponent.odkaz AS komponent_url') //odkaz na komponent_url
            ->select('typKomponent.typKomponent AS typKomponent') //typKomponent na typKomponent
            ->select('parametr.hodnota AS velikost') //hodnota na velikost
            ->where('komponent.id', $id) //vyfiltruje pouze jeden item co chceme
            ->get() //získá
            ->getResult(); //získá odpověď 

            //vytvorime obalku zas s malym joinem
        $data['parametr'] = $db->table('nazevparametr')
            ->join('parametr', 'parametr.nazevParametr_id = nazevparametr.id', 'left')
            ->where('komponent_id', $id)
            ->get()
            ->getResult();

        $html = view('main/item', $data); //ziska stranku html

        $dompdf = new \Dompdf\Dompdf([ //nova knihovna dompdf s fontem DejaVu sans
            'defaultFont' => 'DejaVu Sans'
        ]);
        
        $dompdf->loadHtml($html); //nacte html ktere jsme ziskali nahore
        $dompdf->setPaper('A4', 'portrait'); //nastavi papir A4
        $dompdf->render(); //rendruje
        $dompdf->stream("komponent_$id.pdf", ["Attachment" => true]); //nazev souboru je komponent_id.pdf a stáhne se do počítače
    }
}

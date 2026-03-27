# **Projekt gadekorŸje**

**Spoluodoři: já a jirka**

**PODLE LICENCE ZÁKAZ KOPÍROVÁNÍ JINAK JSOU MI DLUŽNÍ 20 KORUN ČESKÝCH MNĚ**
*výjimka je Niga*


## První stránka:

Zvolit kategorii, upravit název a autora

## Druhá stránka:

Vybrat komponent, přidat ho, stáhnout excel

## Třetí stránka:

Zobrazí všechny parametry, stáhnout pdf

--------------------------

# Jak to funguje

## View

Hlavní stránky jsou ve view ve složce main a každá z nich má dva controllery. Controllery se vždy jmenují dle prvních 3 písmen z jména až na item a přidat a záponou 'Pridani' nebo 'Zobrazit'. Poté jsou vedlejší stránky v ostatních složkách, zatím mám složku 'add' a  v ní mám view pridat.

### První stránka - Kategorie

***1) Controller***

**1.1) KatZobrazit**
```
public function index()
    {
        $data = [
            "typKomponent" => $this->typKomponent->findAll()
        ];

        echo view('main/kategorie', $data);
    }
```

- velice jednoduchý kód
- v data se vytvoří proměnná typKomponent, kde se vypíšou všechny kategorie a pošle se to do main

**1.2) KatPridani**

*a) Metoda add*
```
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
```
- vezme ze stránky pridani.php, neboli z formuláře ve view tyto tři proměnné (typKomponent, autor a url) a uloží to do databáze tabulka typKomponent a redirectne zpět na první stránku

*b) Metoda update*
```
public function update($url)
    {
        $id = $this->typKomponent->select('idKomponent')->where('url', $url)->first()->idKomponent;

        $data = [
            'typKomponent' => $this->request->getPost('násef'),
            'autor' => $this->request->getPost('autor')
        ];

        $this->typKomponent->update($id, $data);

        return redirect()->to(base_url());
    }
```
- parametr id slouží k převedení url segmentu na id (pry je to na prasaka, ale funguje)
- poté zase to vezme z modamu editovat tyto dva údaje (typKomponent a autor) a poté pomocí update() přepíše údaj v tabulce typKomponent a zase redirectne na úvodní stránku

*1.3) Metoda delete*
```
public function delete($id){
        $this->typKomponent->delete($id, true);

        return redirect()->to(base_url());
    }
```

- takze proste pomocí softdelete z moodlu (to je to true tam) smažeme $id a zase redirectne zpět

### Druhá stránka - Komponenty

- není ještě hotové

### Třetí stránka - item

- není ještě hotové

### Ostatní stránka

- není ještě hotové

### Další funkce - stáhnout PDF

- od teho kontroler ExportPDF

```
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
```



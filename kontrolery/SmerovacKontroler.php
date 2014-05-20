<?php

// Router je speciální typ controlleru, který podle URL adresy zavolá
// správný controller a jím vytvořený pohled vloží do šablony stránky

class SmerovacKontroler extends Kontroler {

     private function pomlckyDoVelbloudiNotace($text) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $text)));
    }
    
    protected $kontroler;

    private function parsujURL($url) {
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }

    public function zpracuj($parametry) {
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        if (empty($naparsovanaURL[0])) {
            $this->presmeruj('clanek');
        }
        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';
        if (file_exists('kontrolery/' . $tridaKontroleru . '.php')) {
            $this->kontroler = new $tridaKontroleru;
        } else {
            $this->presmeruj('chyba');
        }
        $this->kontroler->zpracuj($naparsovanaURL);
        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['zpravy'] = $this->vratZpravy();
        $this->pohled = 'rozlozeni';
    }

}

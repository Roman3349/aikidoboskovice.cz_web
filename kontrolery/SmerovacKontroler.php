<?php

// Router je speciální typ kontroleru, který podle URL adresy zavolá
// správný kontroler a jím vytvořený pohled vloží do šablony stránky

class SmerovacKontroler extends Kontroler {

    // Instance kontroleru
    protected $kontroler;

    // Naparsuje URL adresu podle lomítek a vrátí pole parametrů
    private function parsujURL($url) {
        // Naparsuje jednotlivé části URL adresy do asociativního pole
        $naparsovanaURL = parse_url($url);
        // Odstranění počátečního lomítka
        $naparsovanaURL['path'] = ltrim($naparsovanaURL['path'], '/');
        // Odstranění bílých znaků kolem adresy
        $naparsovanaURL['path'] = trim($naparsovanaURL['path']);
        // Rozbití řetězce podle lomítek
        $rozdelenaCesta = explode('/', $naparsovanaURL['path']);
        return $rozdelenaCesta;
    }

    // Naparsování URL adresy a vytvoření příslušného kontroleru
    public function zpracuj($parametry) {
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        empty($naparsovanaURL[0]) ? $this->presmeruj('stranka/uvod') : false;
        // Kontroler je 1. parametr URL
        $tridaKontroleru = str_replace(' ', '', ucwords(str_replace('-', ' ', array_shift($naparsovanaURL)))) . 'Kontroler';
        file_exists('kontrolery/' . $tridaKontroleru . '.php') ? $this->kontroler = new $tridaKontroleru : $this->presmeruj('chyba');
        // Volání kontroleru
        $this->kontroler->zpracuj($naparsovanaURL);
        // Naplnění proměnných pro šablonu	
        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['zpravy'] = $this->vratZpravy();
        // Nastavení hlavní šablonu
        $this->sablona = 'rozlozeni';
    }

}

<?php

// Router je speciální typ kontroleru, který podle URL adresy zavolá
// správný kontroler a jím vytvořený pohled vloží do šablony stránky

class SmerovacKontroler extends Kontroler {

    // Instance controlleru
    protected $kontroler;

    // Metoda převede pomlčkovou variantu kontroleru na název třídy
    private function pomlckyDoVelbloudiNotace($text) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $text)));
    }

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
        if (empty($naparsovanaURL[0])) {
            // Přesměruje uživatele na výpis článků
            $this->presmeruj('stranka/uvod');
        }
        // Kontroler je 1. parametr URL
        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';
        if (file_exists('kontrolery/' . $tridaKontroleru . '.php')) {
            $this->kontroler = new $tridaKontroleru;
        } else {
            // Přesměrování na chybu
            $this->presmeruj('chyba');
        }
        // Volání kontroleru
        $this->kontroler->zpracuj($naparsovanaURL);
        // Naplnění proměnných pro šablonu	
        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['zpravy'] = $this->vratZpravy();
        // Nastavení hlavní šablonu
        $this->pohled = 'rozlozeni';
    }

}

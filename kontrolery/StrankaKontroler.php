<?php

// Kontroler pro výpis stránek

class StrankaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat se stránkami
        $spravceStranek = new SpravceStranek();
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];
        // Je zadána URL stránky ke smazání
        if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
            $this->overUzivatele(true);
            $spravceStranek->odstranStranku($parametry[0]);
            $this->pridejZpravu('Stránka byla úspěšně odstraněna');
            $this->presmeruj('stranka');
            // Je zadána URL stránky k zobrazení
        } else if (!empty($parametry[0])) {
            // Získání článku pomocí URL
            $stranka = $spravceStranek->vratStranku($parametry[0]);
            // Pokud nebyla stránka s danou URL nalezena zoborazí se chyba 404
            if (!$stranka) {
                $this->presmeruj('chyba');
            }
            // Hlavička stránka
            $this->hlavicka = array('titulek' => $stranka['titulek'],);
            // Naplnění proměnných pro šablonu	
            $this->data['titulek'] = $stranka['titulek'];
            $this->data['obsah'] = $stranka['obsah'];
            // Nastavení šablony
            $this->pohled = 'stranka';
            // Není zadáno URL článku, vypíšeme všechny
        } else {
            $stranky = $spravceStranek->vratStranky();
            // Naplnění proměnné pro šablonu
            $this->data['stranky'] = $stranky;
            // Nastavení šablony
            $this->pohled = 'stranky';
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = 'Stránky';
        }
    }

}

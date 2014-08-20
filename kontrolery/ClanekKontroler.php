<?php

// Kontroler pro výpis článků

class ClanekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který nám umožní pracovat s články
        $spravceClanku = new SpravceClanku();
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        // Je uživatel přihlášen
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        // Naplnění proměnné pro šablonu
        $this->data['admin'] = $spravceUzivatelu->vratAdmina($uzivatel['username']);
        ;

        // Je zadána URL článku ke smazání
        if ($parametry[1] == 'odstranit') {
            // Nastavení přístupu pouze pro administrátory
            $this->jeAdmin();
            // Odstranění článku
            $spravceClanku->odstranClanek($parametry[0]);
            $this->pridejZpravu('Článek byl úspěšně odstraněn');
            // Přesměrování na výpis článků
            $this->presmeruj('clanek');
            // Je zadána URL článku k zobrazení
        } else if (!empty($parametry[0])) {
            // Získání článku pomocí URL
            $clanek = $spravceClanku->vratClanek($parametry[0]);
            // Pokud nebyl článek s danou URL nalezen zobrazí se chyba 404
            if (!$clanek) {
                // Přesměrování na chybu
                $this->presmeruj('chyba');
            }
            // Hlavička stránky
            $this->hlavicka = array('titulek' => $clanek['titulek'],);
            // Naplnění proměnných pro šablonu	
            $this->data['titulek'] = $clanek['titulek'];
            $this->data['obsah'] = $clanek['obsah'];
            $this->data['pridano'] = $clanek['pridano'];
            $this->data['pridal'] = $clanek['pridal'];
            $this->data['url'] = $clanek['url'];
            // Nastavení šablony
            $this->pohled = 'clanek';
            // Není zadáno URL článku, vypíšeme všechny
        } else {
            $clanky = $spravceClanku->vratClanky();
            // Naplnění proměnné pro šablonu
            $this->data['clanky'] = $clanky;
            // Nastavení šablony
            $this->pohled = 'clanky';
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = 'Aktuality';
        }
    }

}

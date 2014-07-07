<?php

// Kontroler pro zpracovíní administrace

class AdministraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Přístup mají jen přihlášení uživatelé
        $this->overUzivatele();
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Administrace';
        // Získání dat o přihlášeném uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
            $spravceUzivatelu->odhlas();
            $this->presmeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['username'];
        $this->data['admin'] = $uzivatel['admin'];
        // Nastavení šablony
        $this->pohled = 'administrace';
    }

}

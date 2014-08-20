<?php

// Kontroler pro zpracovíní administrace

class AdministraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Přístup mají jen přihlášení uživatelé
        $this->overUzivatele();
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Administrace';
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        if ($parametry[0] == 'odhlasit') {
            // Odhlaš uživatele
            $spravceUzivatelu->odhlas();
            // Přesměruj na přihlašovací stránku
            $this->presmeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        // Naplnění proměnných pro šablonu	
        $this->data['jmeno'] = $uzivatel['username'];
        $this->data['admin'] = $spravceUzivatelu->vratAdmina($uzivatel['username']);
        // Nastavení šablony
        $this->pohled = 'administrace';
    }

}

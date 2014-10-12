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
        // Vrátí informace o přihlášeném uživateli
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!empty($parametry[0])) {
            switch ($parametry[0]) {
                case 'odhlasit':
                    // Odhlaš uživatele
                    $spravceUzivatelu->odhlas();
                    // Přesměruj na přihlašovací stránku
                    $this->presmeruj('prihlaseni');
                    // Vypíše uživateli zprávu
                    $this->pridejZpravu('Byli jste úspěšně odhlášeni.');
                    break;
                case 'heslo':
                    // Nastavení šablony
                    $this->pohled = 'heslo';
                    // Nastavení hlavičky
                    $this->hlavicka['titulek'] = 'Změna hesla';
                    // Je odeslán formulář
                    if ($_POST) {
                        try {
                            // Změna hesla
                            $spravceUzivatelu->zmenHeslo($uzivatel['jmeno'], $_POST['heslo'], $_POST['nove_heslo'], $_POST['nove_heslo_znovu']);
                            // Odhlásí uživatele
                            $spravceUzivatelu->odhlas();
                            // Vypíše uživateli zprávu
                            $this->pridejZpravu('Vaše heslo bylo úspěšně změněno.');
                        } catch (ChybaUzivatele $chyba) {
                            // Vypíše uživateli chybovou zprávu
                            $this->pridejZpravu($chyba->getMessage());
                        }
                    }
                    break;
                default :
                    // Přesměrování na chybu 404
                    $this->presmeruj('chyba');
            }
        } else {
            // Naplnění proměnných pro šablonu	
            $this->data['jmeno'] = $uzivatel['jmeno'];
            $this->data['admin'] = $spravceUzivatelu->vratAdmina($uzivatel['jmeno']);
            // Nastavení šablony
            $this->pohled = 'administrace';
        }
    }

}

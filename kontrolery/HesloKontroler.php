<?php

// Kontroler pro změnu hesla

class HesloKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Přístup mají jen přihlášení uživatelé
        $this->overUzivatele();
        // Nastavení šablonz
        $this->pohled = 'heslo';
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Změna hesla';
        // Je odeslán formulář
        if ($_POST) {
            try {
                // Vytvoření instance modelu, který nám umožní pracovat s uživateli
                $spravceUzivatelu = new SpravceUzivatelu();
                // Změna hesla
                $spravceUzivatelu->zmenHeslo($spravceUzivatelu->vratUzivatele()['username'], $_POST['heslo'], $_POST['nove_heslo'], $_POST['nove_heslo_znovu']);
                $this->pridejZpravu('Vaše heslo bylo úspěšně změněno.');
            } catch (ChybaUzivatele $chyba) {
                // Vypíše uživateli chybovou zprávu
                $this->pridejZpravu($chyba->getMessage());
            }
        }
    }

}

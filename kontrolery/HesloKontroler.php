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
            $spravceUzivatelu = new SpravceUzivatelu();
            $uzivatel = $spravceUzivatelu->vratUzivatele();
            $spravceUzivatelu->zmenHeslo($uzivatel['username'],$_POST['heslo'], $_POST['nove_heslo'], $_POST['nove_heslo_znovu']);
        }
    }

}

<?php

// Kontroler pro přidání administrátora

class PridejAdminaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->overUzivatele(true);
        // Nastavení šablony
        $this->pohled = 'pridejadmina';
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Přidání administrátora webu';
        // Je odeslán formulář
        if ($_POST) {
            $spravceUzivatelu = new SpravceUzivatelu();
            $spravceUzivatelu->pridejAdmina($_POST['jmeno']);
        }
    }

}

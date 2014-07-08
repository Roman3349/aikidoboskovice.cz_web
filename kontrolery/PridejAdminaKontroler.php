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
            try {
                // Vytvoření instance modelu, který nám umožní pracovat s uživateli
                $spravceUzivatelu = new SpravceUzivatelu();
                // Přidání administrátora
                $spravceUzivatelu->pridejAdmina($_POST['jmeno']);
                // Vypsání zprávy
                $this->pridejZpravu("Administrátor " . $_POST['jmeno'] . " byl úspěšně přidán.");
            } catch (ChybaUzivatele $chyba) {
                // Vypíše uživateli chybovou zprávu
                $this->pridejZpravu($chyba->getMessage());
            }
        }
    }

}

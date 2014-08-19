<?php

// Kontroler pro odebrání administrátora

class OdeberAdminaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->overUzivatele(true);
        // Nastavení šablony
        $this->pohled = 'odeberadmina';
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Odebrání administrátora webu';
        // Je odeslán formulář
        if ($_POST) {
            try {
                // Vytvoření instance modelu, který nám umožní pracovat s uživateli
                $spravceUzivatelu = new SpravceUzivatelu();
                // Odebrání administrátora
                $spravceUzivatelu->odeberAdmina($_POST['jmeno']);
                // Vypsání zprávy
                $this->pridejZpravu("Administrátor " . $_POST['jmeno'] . " byl úspěšně odebrán.");
            } catch (ChybaUzivatele $chyba) {
                // Vypíše uživateli chybovou zprávu
                $this->pridejZpravu($chyba->getMessage());
            }
        }
    }

}

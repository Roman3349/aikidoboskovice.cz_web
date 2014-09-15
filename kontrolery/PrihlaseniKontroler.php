<?php

// Komtroler pro přihlášení

class PrihlaseniKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Vytvoření instance modelu, který  nám pomůže pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        // Vrátí informace o přihlášeném uživateli
        if ($spravceUzivatelu->vratUzivatele()) {
            // Přesměrování do administrace
            $this->presmeruj('administrace');
        }
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Přihlášení';
        // Je odeslán formulář
        if ($_POST) {
            try {
                // Přihlásí uživatele
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                // Vypíše uživateli zprávu
                $this->pridejZpravu('Byl jste úspěšně přihlášen.');
                // Přesměrování do administrace
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                // Vypíše uživateli chybovou zprávu
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'prihlaseni';
    }

}

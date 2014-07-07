<?php

// Komtroler pro přihlášení

class PrihlaseniKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceUzivatelu = new SpravceUzivatelu();
        if ($spravceUzivatelu->vratUzivatele()) {
            $this->presmeruj('administrace');
        }
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Přihlášení';
        // Je odeslán formulář
        if ($_POST) {
            try {
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně přihlášen.');
                // Přesměrování do administrace
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'prihlaseni';
    }

}

<?php

// Kontroler pro registraci uživatelů

class RegistraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Registrace';
        if ($_POST) {
            try {
                // Vytvoření instance modelu
                $spravceUzivatelu = new SpravceUzivatelu();
                // Zaregistruje uživatele
                $spravceUzivatelu->registruj($_POST['jmeno'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                // Přihlásí uživatele
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                // Přesměruje do administrace
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'registrace';
    }

}

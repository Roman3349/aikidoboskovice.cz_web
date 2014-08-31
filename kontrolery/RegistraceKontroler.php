<?php

// Kontroler pro registraci uživatelů

class RegistraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Registrace';
        // Je odeslán formulář
        if ($_POST) {
            try {
                // Vytvoření instance modelu
                $spravceUzivatelu = new SpravceUzivatelu();
                // Zaregistruje uživatele
                $spravceUzivatelu->registruj($_POST['jmeno'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                // Přihlásí uživatele
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                // Vypíše uživateli zprávu
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                // Přesměruje do administrace
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                // Vypíše uživateli chybovou zprávu
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'registrace';
    }

}

<?php

// Kontroler pro vypis profilů

class ProfilKontroler extends Kontroler {

    public function zpracuj($parametry) {

        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        // Nastavení šablony
        $this->pohled = 'profil';

        if (!empty($parametry[0])) {
            $jmeno = $parametry[0];
            // Vrátí údaje uživatele
            $udaje = $spravceUzivatelu->vratUdaje($jmeno);
            if (!$udaje) {
                // Přesměrování na chybu
                $this->presmeruj('chyba');
            }
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = "Profil uživatele " . $udaje['username'] . "";
            // Převedení unixového času na normální
            $unix_time = $udaje['lastlogin'] / 1000;
            $lastlogin = date('j. n. Y, G:i', $unix_time);
            // Naplnění proměnných pro šablonu
            $this->data['jmeno'] = $udaje['username'];
            $this->data['admin'] = $udaje['admin'];
            $this->data['lastlogin'] = $lastlogin;
        } else {
            $this->overUzivatele();
            // Přístup mají jen přihlášení uživatelé
            $uzivatel = $spravceUzivatelu->vratUzivatele();
            // Vrátí údaje uživatele
            $udaje = $spravceUzivatelu->vratUdaje($uzivatel['username']);
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = 'Profil';
            // Převedení unixového času na normální
            $unix_time = $udaje['lastlogin'] / 1000;
            $lastlogin = date('j. n. Y, G:i', $unix_time);
            // Naplnění proměnných pro šablonu
            $this->data['jmeno'] = $udaje['username'];
            $this->data['admin'] = $udaje['admin'];
            $this->data['lastlogin'] = $lastlogin;
        }
    }

}

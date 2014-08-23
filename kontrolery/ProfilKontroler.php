<?php

// Kontroler pro vypis profilů

class ProfilKontroler extends Kontroler {

    public function zpracuj($parametry) {

        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        // Vytvoření instance modelu, který nám umožní pracovat s profily uživatelů
        $spravceProfilu = new SpravceProfilu();
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
            // Naplnění proměnných pro šablonu
            $this->data['jmeno'] = $udaje['username'];
            $this->data['admin'] = $udaje['admin'];
            $this->data['lastlogin'] = $spravceProfilu->prevedCas($udaje['lastlogin']);
        } else {
            $this->overUzivatele();
            // Přístup mají jen přihlášení uživatelé
            $uzivatel = $spravceUzivatelu->vratUzivatele();
            // Vrátí údaje uživatele
            $udaje = $spravceUzivatelu->vratUdaje($uzivatel['username']);
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = 'Profil';
            // Naplnění proměnných pro šablonu
            $this->data['jmeno'] = $udaje['username'];
            $this->data['admin'] = $udaje['admin'];
            $this->data['lastlogin'] = $spravceProfilu->prevedCas($udaje['lastlogin']);
        }
    }

}

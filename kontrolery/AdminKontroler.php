<?php

// Kontroler pro přidání nebo odebrání administrátora

class AdminKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->jeAdmin();
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        // Nastavení šablony
        $this->pohled = 'admin';
        if (!empty($parametry[0])) {
            switch ($parametry[0]) {
                case 'pridat':
                    // Nastavení hlavičky
                    $this->hlavicka['titulek'] = 'Přidání administrátora webu';
                    // Naplnění proměnných pro šablonu	
                    $this->data['typ'] = 'Přidání';
                    $this->data['tlacitko'] = 'Přidat';
                    // Je odeslán formulář
                    if ($_POST) {
                        // Přidání administrátora
                        $spravceUzivatelu->upravaAdmina($_POST['jmeno'], 1);
                        // Vypíše uživateli zprávu
                        $this->pridejZpravu('Administrátor ' . $_POST['jmeno'] . ' byl úspěšně přidán.');
                    }
                    break;
                case 'odebrat':
                    // Nastavení hlavičky
                    $this->hlavicka['titulek'] = 'Odebrání administrátora webu';
                    // Naplnění proměnných pro šablonu	
                    $this->data['typ'] = 'Odebrání';
                    $this->data['tlacitko'] = 'Odebrat';
                    // Je odeslán formulář
                    if ($_POST) {
                        // Odebrání administrátora
                        $spravceUzivatelu->upravaAdmina($_POST['jmeno'], 0);
                        // Vypíše uživateli zprávu
                        $this->pridejZpravu('Administrátor ' . $_POST['jmeno'] . ' byl úspěšně odebrán.');
                    }
                    break;
                default :
                    // Přesměrování na chybu 404
                    $this->presmeruj('chyba');
            }
        } else {
            // Přesměrování na chybu 404
            $this->presmeruj('chyba');
        }
    }

}

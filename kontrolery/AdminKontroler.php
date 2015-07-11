<?php

// Kontroler pro přidání nebo odebrání administrátora

namespace CMS\kontrolery;

use CMS\kontrolery\Kontroler,
    CMS\modely\SpravceUzivatelu;

class AdminKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->jeAdmin();
        $spravceUzivatelu = new SpravceUzivatelu();
        $this->sablona = 'admin';
        if (!empty($parametry[0])) {
            switch ($parametry[0]) {
                case 'pridat':
                    $this->hlavicka['titulek'] = 'Přidání administrátora webu';
                    $this->data['typ'] = 'Přidání';
                    $this->data['tlacitko'] = 'Přidat';
                    if ($_POST) {
                        // Přidání administrátora
                        $spravceUzivatelu->upravaAdmina($_POST['jmeno'], 1);
                        $this->pridejZpravu('Administrátor ' . $_POST['jmeno'] . ' byl úspěšně přidán.');
                    }
                    break;
                case 'odebrat':
                    $this->hlavicka['titulek'] = 'Odebrání administrátora webu';
                    $this->data['typ'] = 'Odebrání';
                    $this->data['tlacitko'] = 'Odebrat';
                    if ($_POST) {
                        // Odebrání administrátora
                        $spravceUzivatelu->upravaAdmina($_POST['jmeno'], 0);
                        $this->pridejZpravu('Administrátor ' . $_POST['jmeno'] . ' byl úspěšně odebrán.');
                    }
                    break;
                default :
                    $this->presmeruj('chyba');
            }
        } else {
            $this->presmeruj('chyba');
        }
    }

}

<?php

// Komtroler pro přihlášení

namespace CMS\Kontrolery;

use CMS\Kontrolery\Kontroler,
    CMS\Modely\SpravceUzivatelu;

class PrihlaseniKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceUzivatelu = new SpravceUzivatelu();
        $spravceUzivatelu->vratUzivatele() ? $this->presmeruj('administrace') : false;
        $this->hlavicka['titulek'] = 'Přihlášení';
        if ($_POST) {
            try {
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně přihlášen.');
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        $this->sablona = 'prihlaseni';
    }

}

<?php

// Kontroler pro registraci uživatelů
namespace CMS\Kontrolery;

use CMS\Kontrolery\Kontroler,
    CMS\Modely\SpravceUzivatelu;

class RegistraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->hlavicka['titulek'] = 'Registrace';
        if ($_POST) {
            try {
                $spravceUzivatelu = new SpravceUzivatelu();
                $spravceUzivatelu->registruj($_POST['jmeno'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                $spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        $this->sablona = 'registrace';
    }

}

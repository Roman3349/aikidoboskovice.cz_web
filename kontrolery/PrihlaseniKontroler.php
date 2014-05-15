<?php

class PrihlaseniKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceUzivatelu = new SpravceUzivatelu();
        if ($spravceUzivatelu->vratUzivatele()) {
            $this->presmeruj('administrace');
        }
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
        $this->pohled = 'prihlaseni';
    }

}

<?php

class PridejAdminaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->overUzivatele(true);
        $this->pohled = 'pridejadmina';
        $this->hlavicka['titulek'] = 'Přidání administrátora webu';
        if ($_POST) {
            $spravceUzivatelu = new SpravceUzivatelu();
            $spravceUzivatelu->pridejAdmina($_POST['jmeno']);
        }
    }

}

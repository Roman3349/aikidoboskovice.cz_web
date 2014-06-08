<?php

class AdministraceKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->overUzivatele();
        $this->hlavicka['titulek'] = 'Přihlášení';
        $spravceUzivatelu = new SpravceUzivatelu();
        if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
            $spravceUzivatelu->odhlas();
            $this->presmeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['username'];
        $this->data['admin'] = $uzivatel['admin'];
        $this->pohled = 'administrace';
    }

}

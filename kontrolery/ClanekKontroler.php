<?php

class ClanekKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceClanku = new SpravceClanku();
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];

        if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
            $this->overUzivatele(true);
            $spravceClanku->odstranClanek($parametry[0]);
            $this->pridejZpravu('Článek byl úspěšně odstraněn');
            $this->presmeruj('clanek');
        } else if (!empty($parametry[0])) {
            $clanek = $spravceClanku->vratClanek($parametry[0]);
            if (!$clanek) {
                $this->presmeruj('chyba');
            }
            $this->hlavicka = array('titulek' => $clanek['titulek'],);
            $this->data['titulek'] = $clanek['titulek'];
            $this->data['obsah'] = $clanek['obsah'];
            $this->pohled = 'clanek';
        } else {
            $clanky = $spravceClanku->vratClanky();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clanky';
        }
    }

}

<?php

class StrankaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $spravceStranek = new SpravceStranek();
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];
        if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
            $this->overUzivatele(true);
            $spravceStranek->odstranStranku($parametry[0]);
            $this->pridejZpravu('Stránka byla úspěšně odstraněna');
            $this->presmeruj('stranka');
        } else if (!empty($parametry[0])) {
            $stranka = $spravceStranek->vratStranku($parametry[0]);
            if (!$stranka) {
                $this->presmeruj('chyba');
            }
            $this->hlavicka = array('titulek' => $stranka['titulek'], );
            $this->data['titulek'] = $stranka['titulek'];
            $this->data['obsah'] = $stranka['obsah'];
            $this->pohled = 'stranka';
        } else {
            $stranky = $spravceStranek->vratStranky();
            $this->data['stranky'] = $stranky;
            $this->pohled = 'stranky';
        }
    }

}

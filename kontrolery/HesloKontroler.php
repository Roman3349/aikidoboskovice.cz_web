<?php

class HesloKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->pohled = 'heslo';
        $this->hlavicka['titulek'] = 'Změna hesla';
        if ($_POST) {
            $spravceUzivatelu = new SpravceUzivatelu();
            $uzivatel = $spravceUzivatelu->vratUzivatele();
            $spravceUzivatelu->zmenHeslo($uzivatel['username'],$_POST['heslo'], $_POST['nove_heslo'], $_POST['nove_heslo_znovu']);
        }
    }

}

<?php

class SpravceUzivatelu {

    public function zkontrolujOtisk($heslo, $otisk) {
        $tmp = explode('$', $otisk);
        return (hash('sha256', hash('sha256', $heslo) . $tmp[2]) == $tmp[3]);
    }

    public function prihlas($jmeno, $heslo) {
        $otisk = MC::dotazJeden("SELECT password FROM authme WHERE username = '$jmeno'");
        $uzivatel = Db::dotazJeden('SELECT username, admin FROM authme WHERE username = ? AND password = ?', array($jmeno, $this->zkontrolujOtisk($heslo, $otisk)));
        // $vysledek = zkontrolujHeslo($heslo, $otisk);
        if ($uzivatel) {
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        }
        $_SESSION['uzivatel'] = $uzivatel;
    }

    public function odhlas() {
        unset($_SESSION['uzivatel']);
    }

    public function vratUzivatele() {
        if (isset($_SESSION['uzivatel'])) {
            return $_SESSION['uzivatel'];
        }
        return null;
    }

}

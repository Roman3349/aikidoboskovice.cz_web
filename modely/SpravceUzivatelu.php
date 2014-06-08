<?php

class SpravceUzivatelu {

    public function vratOtisk($heslo) {
        return sha1($heslo);
    }

    public function prihlas($jmeno, $heslo) {
        $uzivatel = MC::dotazJeden('SELECT id, username, admin FROM authme WHERE username = ? AND password = ?', array($jmeno, $this->vratOtisk($heslo)));
        if (!$uzivatel) {
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

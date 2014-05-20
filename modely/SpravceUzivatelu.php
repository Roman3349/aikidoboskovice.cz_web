<?php

class SpravceUzivatelu {

    public function prihlas($jmeno, $heslo) {
        $salt = (string) mt_rand(10000000, 999999999) . (string) mt_rand(10000000, 999999999);
        $pw = '$SHA$' . $salt . '$' . hash('sha256', hash('sha256', $heslo) . $salt);
        $uzivatel = MC::dotazJeden('SELECT (username, password) FROM authme WHERE jmeno = ? AND password = ? ', array($jmeno, $pw));
        if (!$uzivatel) {
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        }
        $_SESSION['uzivatel'] = $uzivatel;
    }

    public function odhlas() {
        unset($_SESSION['uzivatel']);
    }

    public function vratUzivatele() {
        $db = Db::dotazJeden('SELECT ' . $_SESSION['uzivatel'] . ' FROM admin');
        if (isset($db)) {
            return $db;
        }
        return null;
    }

}

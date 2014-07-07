<?php

class SpravceUzivatelu {

    public function vratOtisk($heslo) {
        return sha1($heslo);
    }

    public function zmenHeslo($jmeno, $heslo, $noveHeslo, $noveHesloZnovu) {
        if ($this->vratOtisk($heslo) != MC::dotazJeden('SELECT password FROM authme WHERE username = ?', $jmeno)) {
            throw new ChybaUzivatele('Chybně vyplněné součastné heslo.');
        }
        if ($noveHeslo != $noveHesloZnovu) {
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        try {
            MC::zmen('authme', array('password' => $noveHeslo), 'WHERE username = ?', array($jmeno));
        } catch (PDOException $e) {
            throw new ChybaUzivatele('Nekde se stala chyba.');
        }
    }
    
    public function pridejAdmina($jmeno) {
        try {
            MC::zmen('authme',array('admin' => '1'), 'WHERE username = ?', array($jmeno));
        } catch (PDOException $e) {
            throw new ChybaUzivatele('Nekde se stala chyba.');
        }
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

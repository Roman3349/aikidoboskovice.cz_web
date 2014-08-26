<?php

// Správce uživatelů redakčního systému

class SpravceUzivatelu {

    // Vratí náhodný salt 
    private static function vratSalt($len) {
        $bytes = openssl_random_pseudo_bytes(40);
        $sha1 = sha1($bytes);
        return substr($sha1, 0, $len);
    }

    // Vrátí otisk hesla
    private function vratOtisk($heslo) {
        $sul = $this->gen_hex_salt(16);
        return '$SHA$' . $sul . '$' . hash('sha256', hash('sha256', $heslo) . $sul);
    }

    // Když heslo souhlasí vrátí hash
    private function zkontrolujHeslo($heslo, $hash) {
        $cast = explode('$', $hash);
        if (hash('sha256', hash('sha256', $heslo) . $cast[2]) == $cast[3]) {
            return $hash;
        } else {
            return false;
        }
    }

    // Změna hesla uživatele
    public function zmenHeslo($jmeno, $heslo, $noveHeslo, $noveHesloZnovu) {
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $hash = $this->vratHash($jmeno);
        // Souhlasí stávající heslo
        if ($this->zkontrolujHeslo($heslo, $hash) != $hash) {
            throw new ChybaUzivatele('Chybně vyplněné současné heslo.');
        }
        // Souhlasí nové hesla
        if ($noveHeslo != $noveHesloZnovu) {
            // Vypíše chybovou správu uživateli
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        try {
            // Změní heslo v databázi AuthMe
            MC::zmen('authme', array('password' => $this->vratOtisk($noveHeslo)), 'WHERE username = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Přidání administrátora
    public function pridejAdmina($jmeno) {
        try {
            MC::zmen('authme', array('admin' => '1'), 'WHERE username = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Odebrání administrátora
    public function odeberAdmina($jmeno) {
        try {
            MC::zmen('authme', array('admin' => '0'), 'WHERE username = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo) {
        $hash = $this->zkontrolujHeslo($heslo, $this->vratHash($jmeno));
        $uzivatel = MC::dotazJeden('SELECT `username` FROM `authme` WHERE `username` = ? AND `password` = ?', array($jmeno, $hash));
        if (!$uzivatel) {
            // Vypíše chybovou správu uživateli
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        }
        $_SESSION['uzivatel'] = $uzivatel;
    }

    // Odhlásí uživatele
    public function odhlas() {
        unset($_SESSION['uzivatel']);
    }

    // Zjistí, zda je přihlášený uživatel administrátor
    public function vratUzivatele() {
        if (isset($_SESSION['uzivatel'])) {
            return $_SESSION['uzivatel'];
        }
        return null;
    }

    // Vrátí hash hesla z databáze
    public function vratHash($jmeno) {
        $dotaz = MC::dotazJeden('SELECT `password` FROM `authme` WHERE `username` = ?', array($jmeno));
        return $dotaz['password'];
    }

    // Zjístí, zda je uživatel administrátorem
    public function vratAdmina($jmeno) {
        $dotaz = MC::dotazJeden('SELECT `admin` FROM `authme` WHERE `username` = ?', array($jmeno));
        if ($dotaz['admin'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Vrátí údaje uživatele
    public function vratUdaje($jmeno) {
        return MC::dotazJeden('SELECT `username`, `lastlogin`, `admin` FROM `authme` WHERE `username` = ?', array($jmeno));
    }

}

<?php

// Správce uživatelů redakčního systému

class SpravceUzivatelu {

    // Vrátí otisk hesla
    public function vratOtisk($heslo) {
        $sul = '1G@ag0AoBS';
        return hash('sha256', $heslo . $sul);
    }

    // Registruje nového uživatele do systému
    public function registruj($jmeno, $heslo, $hesloZnovu, $rok) {
        if ($rok != date('Y')) {
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        }
        if ($heslo != $hesloZnovu) {
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        $uzivatel = array('jmeno' => $jmeno, 'heslo' => $this->vratOtisk($heslo));
        try {
            Db::vloz('uzivatele', $uzivatel);
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo) {
        $uzivatel = Db::dotazJeden('SELECT `jmeno` FROM `uzivatele` WHERE `jmeno` = ? AND `heslo` = ?', array($jmeno, $this->vratOtisk($heslo)));
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

    // Změna hesla uživatele
    public function zmenHeslo($jmeno, $heslo, $noveHeslo, $noveHesloZnovu) {
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        // Souhlasí stávající heslo
        if ($this->vratOtisk($heslo) != $this->vratHash($jmeno)) {
            // Vypíše chybovou správu uživateli
            throw new ChybaUzivatele('Chybně vyplněné současné heslo.');
        }
        // Souhlasí nové hesla
        if ($noveHeslo != $noveHesloZnovu) {
            // Vypíše chybovou správu uživateli
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        try {
            // Změní heslo v databázi
            Db::zmen('uzivatele', array('heslo' => $this->vratOtisk($noveHeslo)), 'WHERE jmeno = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Přidání administrátora
    public function pridejAdmina($jmeno) {
        try {
            // Změní hodnotu admin z 0 na 1 u uživatele
            Db::zmen('uzivatele', array('admin' => '1'), 'WHERE jmeno = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Odebrání administrátora
    public function odeberAdmina($jmeno) {
        try {
            // Změní hodnotu admin z 0 na 1 u uživatele
            Db::zmen('uzivatele', array('admin' => '0'), 'WHERE jmeno = ?', array($jmeno));
        } catch (ChybaUzivatele $chyba) {
            // Vypíše chybovou zprávu uživateli
            $this->pridejZpravu($chyba->getMessage());
        }
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
        $dotaz = Db::dotazJeden('SELECT `password` FROM `uzivatele` WHERE `jmeno` = ?', array($jmeno));
        return $dotaz['password'];
    }

    // Zjístí, zda je uživatel administrátorem
    public function vratAdmina($jmeno) {
        $dotaz = Db::dotazJeden('SELECT `admin` FROM `uzivatele` WHERE `jmeno` = ?', array($jmeno));
        if ($dotaz['admin'] == 1) {
            return true;
        } else {
            return false;
        }
    }

}

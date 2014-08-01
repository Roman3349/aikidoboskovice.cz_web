<?php

// Správce uživatelů redakčního systému

class SpravceUzivatelu {

    // Vrátí otisk hesla
    public function vratOtisk($heslo) {
        return sha1($heslo);
    }

    // Změna hesla uživatele
    public function zmenHeslo($jmeno, $heslo, $noveHeslo, $noveHesloZnovu) {
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        // Souhlasí stávající heslo
        if ($this->vratOtisk($heslo) != $uzivatel['password']) {
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

    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo) {
        $uzivatel = MC::dotazJeden('SELECT id, username, password, admin FROM authme WHERE username = ? AND password = ?', array($jmeno, $this->vratOtisk($heslo)));
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

}

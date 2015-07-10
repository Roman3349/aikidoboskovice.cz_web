<?php

// Správce uživatelů redakčního systému

namespace CMS\Modely;

use CMS\Modely\Db;

class SpravceUzivatelu {

    // Vrátí otisk hesla
    public function vratOtisk($jmeno, $heslo) {
        return hash('sha512', $heslo . ucwords($jmeno));
    }

    // Registruje nového uživatele do systému
    public function registruj($jmeno, $heslo, $hesloZnovu, $rok) {
        if ($rok != date('Y')) {
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        }
        if ($heslo != $hesloZnovu) {
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        $uzivatel = ['jmeno' => $jmeno, 'heslo' => $this->vratOtisk($jmano, $heslo)];
        try {
            Db::vloz('uzivatele', $uzivatel);
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo) {
        $uzivatel = Db::dotazJeden('SELECT * FROM `uzivatele` WHERE `jmeno` = ? AND `heslo` = ?', [$jmeno, $this->vratOtisk($jmeno, $heslo)]);
        if (!$uzivatel) {
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
        // Získání informací o uživateli z databáze
        $uzivatel = Db::dotazJeden('SELECT * FROM `uzivatele` WHERE `jmeno` = ?', [$jmeno]);
        // Souhlasí stávající heslo
        if ($this->vratOtisk($jmeno, $heslo) != $uzivatel['heslo']) {
            throw new ChybaUzivatele('Chybně vyplněné současné heslo.');
        }
        // Souhlasí nové hesla
        if ($noveHeslo != $noveHesloZnovu) {
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        }
        try {
            // Změní heslo v databázi
            Db::zmen('uzivatele', ['heslo' => $this->vratOtisk($jmeno, $noveHeslo)], 'WHERE jmeno = ?', [$jmeno]);
        } catch (ChybaUzivatele $chyba) {
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Přidání nebo odebrání administrátora
    public function upravaAdmina($jmeno, $admin) {
        try {
            Db::zmen('uzivatele', ['admin' => $admin], 'WHERE jmeno = ?', [$jmeno]);
        } catch (ChybaUzivatele $chyba) {
            $this->pridejZpravu($chyba->getMessage());
        }
    }

    // Vrátí informace o uživateli z sessionu
    public function vratUzivatele() {
        return isset($_SESSION['uzivatel']) ? $_SESSION['uzivatel'] : null;
    }

}

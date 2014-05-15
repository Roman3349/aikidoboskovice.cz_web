<?php

class SpravceUzivatelu {

    public function vratOtisk($heslo) {
        return hash('sha256', $heslo);
    }

    public function prihlas($jmeno, $heslo) {
        $result = MC::dotazJeden("SELECT password FROM authme WHERE username = '" . preg_replace('/\s+/', '', $_POST['nick']) . "'");
        $row = $result->fetch_assoc();
        $userPasswordField = explode('$', $row['password']);
        $heslo = hash('sha256', preg_replace('/\s+/', '', $_POST['heslo']));
        $heslo .= $userPasswordField[2];
        $heslo = '$SHA$' . $userPasswordField[2] . '$' . hash('sha256', $heslo);
        $heslicko = $heslo === $row['password'];
        $uzivatel = MC::dotazJeden('SELECT id, jmeno, admin FROM uzivatele WHERE jmeno = ? AND heslo = ? ', array($jmeno, $this->vratOtisk($heslo)));
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

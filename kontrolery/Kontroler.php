<?php

// Výchozí kontroler pro redakční systém

namespace CMS\kontrolery;

use CMS\modely\SpravceUzivatelu;

abstract class Kontroler {

    // Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
    protected $data = array();
    // Název šablony bez přípony
    protected $sablona = '';
    // Hlavička HTML stránky
    protected $hlavicka = array('titulek' => '');

    // Ošetří proměnnou pro výpis do HTML stránky
    private function osetri($x = null) {
        if (!isset($x)) {
            return null;
        } elseif (is_string($x)) {
            return htmlspecialchars($x, ENT_QUOTES);
        } elseif (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        } else {
            return $x;
        }
    }

    // Vyrenderuje pohled
    public function vypisPohled() {
        if ($this->sablona) {
            extract($this->osetri($this->data));
            extract($this->data, EXTR_PREFIX_ALL, '');
            require('pohledy/' . $this->sablona . '.phtml');
        }
    }

    // Přidá zprávu pro uživatele
    public function pridejZpravu($zprava) {
        isset($_SESSION['zpravy']) ? $_SESSION['zpravy'][] = $zprava : $_SESSION['zpravy'] = array($zprava);
    }

    // Vrátí zprávy pro uživatele
    public static function vratZpravy() {
        if (isset($_SESSION['zpravy'])) {
            $zpravy = $_SESSION['zpravy'];
            unset($_SESSION['zpravy']);
            return $zpravy;
        } else {
            return array();
        }
    }

    // Přesměruje uživatele na danou URL adresu
    public function presmeruj($url) {
        header('Location: /' . $url);
        header('Connection: close');
        exit;
    }

    // Ověří, zda je přihlášený uživatel, případně přesměruje na login
    public function overUzivatele() {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel) {
            $this->pridejZpravu('Nejste přihlášen.');
            $this->presmeruj('prihlaseni');
        }
    }

    // Ověří zda je uživatel administrátor
    public function jeAdmin() {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel['admin']) {
            $this->pridejZpravu('Nemáte oprávnění do této sekce webu.');
            $this->presmeruj('administrace');
        }
    }

    // Hlavní metoda controlleru
    abstract function zpracuj($parametry);
}

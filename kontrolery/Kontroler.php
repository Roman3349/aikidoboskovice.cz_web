<?php

// Výchozí kontroler pro redakční systém

abstract class Kontroler {

    // Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
    protected $data = array();
    // Název šablony bez přípony
    protected $pohled = "";
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
        if ($this->pohled) {
            extract($this->osetri($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }

    // Přidá zprávu pro uživatele
    public function pridejZpravu($zprava) {
        if (isset($_SESSION['zpravy'])) {
            $_SESSION['zpravy'][] = $zprava;
        } else {
            $_SESSION['zpravy'] = array($zprava);
        }
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
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    // Ověří, zda je přihlášený uživatel, případně přesměruje na login
    public function overUzivatele($admin = false) {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel) {
            $this->pridejZpravu('Nedostatečná oprávnění.');
            $this->presmeruj('prihlaseni');
        }
    }

    // Hlavní metoda controlleru
    abstract function zpracuj($parametry);
}

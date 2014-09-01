<?php

// Třída poskytuje metody pro správu stránek v redakčním systému

class SpravceStranek {
    
    // Převede MySQL TIMESTAMP na normální datum a čas
    public static function prevedCas($cas) {
        return date('j. n. Y v G:i', strtotime($cas));
    }

    // Vrátí stránku z databáze podle její URL
    public function vratStranku($url) {
        return Db::dotazJeden('SELECT `stranky_id`, `titulek`, `obsah`, `url`, `pridal`, `pridano` FROM `stranky` WHERE `url` = ?', array($url));
    }

    // Uloží stránku do systému. Pokud je ID false, vloží novou, jinak provede editaci.
    public function ulozStranku($id, $stranka) {
        // Je vyplněno ID stránky
        if (!$id) {
            // Vloží data nové stránky do databáze
            Db::vloz('stranky', $stranka);
        } else {
            // Upraví data stránky v databázi
            Db::zmen('stranky', $stranka, 'WHERE stranky_id = ?', array($id));
        }
    }

    // Vrátí seznam stránek v databázi
    public function vratStranky() {
        return Db::dotazVsechny('SELECT `stranky_id`, `titulek`, `url`, `pridal`, `pridano` FROM `stranky` ORDER BY `stranky_id` DESC');
    }

    // Odstraní stránku
    public function odstranStranku($url) {
        Db::dotaz('DELETE FROM `stranky` WHERE `url` = ?', array($url));
    }

}

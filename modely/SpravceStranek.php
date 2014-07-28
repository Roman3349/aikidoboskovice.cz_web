<?php

// Třída poskytuje metody pro správu stránek v redakčním systému

class SpravceStranek {

    // Vrátí stránku z databáze podle její URL
    public function vratStranku($url) {
        return Db::dotazJeden('SELECT `stranky_id`, `titulek`, `obsah`, `url` FROM `stranky` WHERE `url` = ?', array($url));
    }

    // Uloží stránku do systému. Pokud je ID false, vloží novou, jinak provede editaci.
    public function ulozStranku($id, $stranka) {
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
        return Db::dotazVsechny('SELECT `stranky_id`, `titulek`, `url` FROM `stranky` ORDER BY `stranky_id` DESC');
    }

    // Odstraní stránku
    public function odstranStranku($url) {
        Db::dotaz('DELETE FROM `stranky` WHERE `url` = ?', array($url));
    }

}

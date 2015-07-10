<?php

// Třída poskytuje metody pro správu stránek v redakčním systému

namespace CMS\Modely;

use CMS\Modely\Db;

class SpravceStranek {

    // Převede MySQL TIMESTAMP na normální datum a čas
    public static function prevedCas($cas) {
        return date('j. n. Y v G:i', strtotime($cas));
    }

    // Vrátí stránku z databáze podle její URL
    public function vratStranku($url) {
        return Db::dotazJeden('SELECT * FROM `stranky` WHERE `url` = ?', [$url]);
    }

    // Uloží stránku do systému. Pokud je ID false, vloží novou, jinak provede editaci.
    public function ulozStranku($id, $stranka) {
        !$id ? Db::vloz('stranky', $stranka) : Db::zmen('stranky', $stranka, 'WHERE stranky_id = ?', [$id]);
    }

    // Vrátí seznam stránek v databázi
    public function vratStranky() {
        return Db::dotazVsechny('SELECT * FROM `stranky` ORDER BY `stranky_id` DESC');
    }

    // Odstraní stránku
    public function odstranStranku($url) {
        Db::dotaz('DELETE FROM `stranky` WHERE `url` = ?', [$url]);
    }

}

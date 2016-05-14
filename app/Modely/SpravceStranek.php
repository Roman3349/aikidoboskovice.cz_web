<?php

namespace App\Modely;

use App\Modely\Db;

/**
 * Třída poskytuje metody pro správu stránek v redakčním systému
 */
class SpravceStranek {

	/**
	 * Převede MySQL TIMESTAMP na normální datum a čas
	 * @param string $cas
	 * @return string
	 */
	public static function prevedCas($cas) {
		return date('j. n. Y G:i', strtotime($cas));
	}

	/**
	 * Vrátí stránku z databáze podle její URL
	 * @param string $url
	 * @return array
	 */
	public function vratStranku($url) {
		return Db::dotazJeden('SELECT * FROM `stranky` WHERE `url` = ?', [$url]);
	}

	/**
	 * Uloží stránku do systému. Pokud je ID false, vloží novou, jinak provede editaci.
	 * @param int $id
	 * @param array $stranka
	 */
	public function ulozStranku($id, $stranka) {
		!$id ? Db::vloz('stranky', $stranka) : Db::zmen('stranky', $stranka, 'WHERE stranky_id = ?', [$id]);
	}

	/**
	 * Vrátí seznam stránek v databázi
	 * @return array
	 */
	public function vratStranky() {
		return Db::dotazVsechny('SELECT * FROM `stranky` ORDER BY `stranky_id` DESC');
	}

	/**
	 * Odstraní stránku
	 * @param string $url
	 */
	public function odstranStranku($url) {
		Db::dotaz('DELETE FROM `stranky` WHERE `url` = ?', [$url]);
	}

}

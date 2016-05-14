<?php

namespace App\Modely;

use PDO;

/**
 * Wrapper pro snadnější práci s databází s použitím PDO a automatickým zabezpečením parametrů (proměnných) v dotazech.
 */
class Db {

	/**
	 * Databázové spojení
	 */
	private static $spojeni;

	/**
	 * Výchozí nastavení ovladače
	 * @var array
	 */
	private static $nastaveni = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::ATTR_EMULATE_PREPARES => false
	];

	/**
	 * Připojí se k databázi pomocí daných údajů
	 * @param string $host
	 * @param string $uzivatel
	 * @param string $heslo
	 * @param string $databaze
	 */
	public static function pripoj($host, $uzivatel, $heslo, $databaze) {
		if (!isset(self::$spojeni)) {
			self::$spojeni = new PDO('mysql:host=' . $host . ';dbname=' . $databaze, $uzivatel, $heslo, self::$nastaveni);
		}
	}

	/**
	 * Spustí dotaz a vrátí z něj první řádek
	 * @param string $dotaz
	 * @param array $parametry
	 * @return array
	 */
	public static function dotazJeden($dotaz, $parametry = []) {
		$navrat = self::$spojeni->prepare($dotaz);
		$navrat->execute($parametry);
		return $navrat->fetch();
	}

	/**
	 * Spustí dotaz a vrátí všechny jeho řádky jako pole asociativních polí
	 * @param string  $dotaz
	 * @param array $parametry
	 * @return array
	 */
	public static function dotazVsechny($dotaz, $parametry = []) {
		$navrat = self::$spojeni->prepare($dotaz);
		$navrat->execute($parametry);
		return $navrat->fetchAll();
	}

	/**
	 * Spustí dotaz a vrátí z něj první sloupec prvního řádku
	 * @param string $dotaz
	 * @param array $parametry
	 * @return string
	 */
	public static function dotazSamotny($dotaz, $parametry = []) {
		return self::dotazJeden($dotaz, $parametry)[0];
	}

	/**
	 * Spustí dotaz a vrátí počet ovlivněných řádků
	 * @param string $dotaz
	 * @param array $parametry
	 * @return array
	 */
	public static function dotaz($dotaz, $parametry = []) {
		$navrat = self::$spojeni->prepare($dotaz);
		$navrat->execute($parametry);
		return $navrat->rowCount();
	}

	/**
	 * Vloží do tabulky nový řádek jako data z asociativního pole
	 * @param string $tabulka
	 * @param array $parametry
	 * @return array
	 */
	public static function vloz($tabulka, $parametry = []) {
		return self::dotaz("INSERT INTO `$tabulka` (`" . implode('`, `', array_keys($parametry)) . "`) VALUES (" . str_repeat('?,', sizeOf($parametry) - 1) . "?)", array_values($parametry));
	}

	/**
	 * Změní řádek v tabulce tak, aby obsahoval data z asociativního pole
	 * @param string $tabulka
	 * @param array $hodnoty
	 * @param string $podminka
	 * @param array $parametry
	 * @return array
	 */
	public static function zmen($tabulka, $hodnoty = [], $podminka, $parametry = []) {
		return self::dotaz("UPDATE `$tabulka` SET `" . implode('` = ?, `', array_keys($hodnoty)) . "` = ? " . $podminka, array_merge(array_values($hodnoty), $parametry));
	}

}

<?php

namespace App\Modely;

use App\Modely\ChybaUzivatele;
use App\Modely\Db;

/**
 * Správce uživatelů redakčního systému
 */
class SpravceUzivatelu {

	/**
	 * Registruje nového uživatele do systému
	 * @param string $jmeno
	 * @param string $heslo
	 * @param string $hesloZnovu
	 * @throws ChybaUzivatele
	 */
	public function registruj($jmeno, $heslo, $hesloZnovu) {
		if ($heslo != $hesloZnovu) {
			throw new ChybaUzivatele('Hesla nesouhlasí.');
		} elseif (strlen($heslo) > 60) {
			throw new ChybaUzivatele('Heslo je delší než 60 znaků.');
		}
		$uzivatel = ['jmeno' => $jmeno, 'heslo' => password_hash($heslo, PASSWORD_BCRYPT)];
		try {
			Db::vloz('uzivatele', $uzivatel);
		} catch (PDOException $chyba) {
			throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
		}
	}

	/**
	 * Přihlásí uživatele do systému
	 * @param string $jmeno
	 * @param string $heslo
	 * @throws ChybaUzivatele
	 */
	public function prihlas($jmeno, $heslo) {
		if (!$this->jePrihlasen()) {
			$uzivatel = Db::dotazJeden('SELECT `id`, `jmeno`, `heslo`, `admin` FROM `uzivatele` WHERE `jmeno` = ?', [$jmeno]);
			if (!$uzivatel) {
				throw new ChybaUzivatele('Neplatné jméno.');
			} elseif (!password_verify($heslo, $uzivatel['heslo'])) {
				throw new ChybaUzivatele('Neplatné heslo.');
			}
			$_SESSION = [];
			session_regenerate_id();
			$_SESSION['id'] = $uzivatel['id'];
			$_SESSION['jmeno'] = $uzivatel['jmeno'];
			$_SESSION['heslo'] = $uzivatel['heslo'];
			$_SESSION['admin'] = $uzivatel['admin'];
			$_SESSION['agent'] = filter_input(INPUT_SERVER ,'HTTP_USER_AGENT');
		}
	}

	/**
	 * Odhlásí uživatele
	 */
	public function odhlas() {
		$_SESSION = [];
		session_regenerate_id();
	}

	/**
	 * Změna hesla uživatele
	 * @param string $jmeno
	 * @param string $heslo
	 * @param string $noveHeslo
	 * @param string $noveHesloZnovu
	 * @throws ChybaUzivatele
	 */
	public function zmenHeslo($jmeno, $heslo, $noveHeslo, $noveHesloZnovu) {
		// Získání informací o uživateli z databáze
		$uzivatel = Db::dotazJeden('SELECT `heslo` FROM `uzivatele` WHERE `jmeno` = ?', [$jmeno]);
		// Souhlasí stávající heslo
		if (!password_verify($heslo, $uzivatel['heslo'])) {
			throw new ChybaUzivatele('Chybně vyplněné současné heslo.');
		} elseif ($noveHeslo != $noveHesloZnovu) {
			throw new ChybaUzivatele('Hesla nesouhlasí.');
		} elseif (strlen($noveHeslo) > 60) {
			throw new ChybaUzivatele('Heslo je delší než 60 znaků.');
		}
		try {
			// Změní heslo v databázi
			Db::zmen('uzivatele', ['heslo' => password_hash($noveHeslo, PASSWORD_BCRYPT)], 'WHERE jmeno = ?', [$jmeno]);
		} catch (ChybaUzivatele $chyba) {
			$this->pridejZpravu($chyba->getMessage());
		}
	}

	/**
	 * Přidání nebo odebrání administrátora
	 * @param string $jmeno
	 * @param int $admin
	 */
	public function upravaAdmina($jmeno, $admin) {
		try {
			Db::zmen('uzivatele', ['admin' => $admin], 'WHERE jmeno = ?', [$jmeno]);
		} catch (ChybaUzivatele $chyba) {
			$this->pridejZpravu($chyba->getMessage());
		}
	}

	/**
	 * Vrátí informace o uživateli z sessionu
	 * @return mixed
	 */
	public function vratUzivatele() {
		if ($this->jePrihlasen()) {
			return isset($_SESSION) ? $_SESSION : null;
		} else {
			$_SESSION = [];
			session_regenerate_id();
		}
	}

	/**
	 * Ověří zda je uživatel přihlášen
	 * @return boolean
	 */
	public function jePrihlasen() {
		if (empty($_SESSION['id']) || empty($_SESSION['jmeno']) || empty($_SESSION['heslo']) || empty($_SESSION['agent'])) {
			return false;
		}
		$uzivatel = Db::dotazJeden('SELECT `id`, `jmeno`, `heslo`, `admin` FROM `uzivatele` WHERE `jmeno` = ?', [$_SESSION['jmeno']]);
		if ($_SESSION['id'] === $uzivatel['id'] && $_SESSION['jmeno'] === $uzivatel['jmeno'] &&
				$_SESSION['heslo'] === $uzivatel['heslo'] && $_SESSION['admin'] === $uzivatel['admin'] &&
				$_SESSION['agent'] === filter_input(INPUT_SERVER ,'HTTP_USER_AGENT')) {
			return true;
		} else {
			return false;
		}
	}

}

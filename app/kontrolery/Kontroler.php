<?php

/**
 * Výchozí kontroler pro redakční systém
 */
abstract class Kontroler {

	/**
	 * @var array Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
	 */
	protected $data = [];

	/**
	 * @var string Název šablony bez přípony
	 */
	protected $sablona = '';

	/**
	 * @var array Hlavička HTML stránky
	 */
	protected $hlavicka = ['titulek' => ''];

	/**
	 * Ošetří proměnnou pro výpis do HTML stránky
	 * @param mixed $x
	 * @return mixed
	 */
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

	/**
	 * Vyrenderuje pohled
	 */
	public function vypisPohled() {
		if ($this->sablona) {
			extract($this->osetri($this->data));
			extract($this->data, EXTR_PREFIX_ALL, '');
			require('app/pohledy/' . $this->sablona . '.phtml');
		}
	}

	/**
	 * Přidá zprávu pro uživatele
	 * @param string $zprava
	 */
	public function pridejZpravu($zprava) {
		isset($_SESSION['zpravy']) ? $_SESSION['zpravy'][] = $zprava : $_SESSION['zpravy'] = [$zprava];
	}

	/**
	 * Vrátí zprávy pro uživatele
	 * @return array
	 */
	public static function vratZpravy() {
		if (isset($_SESSION['zpravy'])) {
			$zpravy = $_SESSION['zpravy'];
			unset($_SESSION['zpravy']);
			return $zpravy;
		} else {
			return [];
		}
	}

	/**
	 * Přesměruje uživatele na danou URL adresu
	 */
	public function presmeruj($url) {
		header('Location: /' . $url);
		header('Connection: close');
		exit;
	}

	/**
	 * Ověří, zda je přihlášený uživatel, případně přesměruje na login
	 */
	public function overUzivatele() {
		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		if (!$uzivatel) {
			$this->pridejZpravu('Nejste přihlášen.');
			$this->presmeruj('prihlaseni');
		}
	}

	/**
	 * Ověří zda je uživatel administrátor
	 */
	public function jeAdmin() {
		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		if (!$uzivatel['admin']) {
			$this->pridejZpravu('Nemáte oprávnění do této sekce webu.');
			$this->presmeruj('administrace');
		}
	}

	/**
	 * Hlavní metoda controlleru
	 */
	abstract function zpracuj($parametry);
}

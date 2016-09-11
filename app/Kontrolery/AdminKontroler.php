<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;
use App\Modely\SpravceUzivatelu;

/**
 * Kontroler pro přidání nebo odebrání administrátora
 */
class AdminKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		// Nastavení přístupu pouze pro administrátory
		$this->jeAdmin();
		$spravceUzivatelu = new SpravceUzivatelu();
		$this->sablona = 'admin';
		if (!empty($parametry[0])) {
			switch ($parametry[0]) {
				case 'pridat':
					$this->hlavicka['titulek'] = 'Přidání administrátora webu';
					$this->data['typ'] = 'Přidání';
					$this->data['tlacitko'] = 'Přidat';
					if (filter_input_array(INPUT_POST) && $_SESSION['admin'] == 1) {
						// Přidání administrátora
						$spravceUzivatelu->upravaAdmina(filter_input(INPUT_POST, 'jmeno'), 1);
						$this->pridejZpravu('Administrátor ' . filter_input(INPUT_POST, 'jmeno') . ' byl úspěšně přidán.');
					}
					break;
				case 'odebrat':
					$this->hlavicka['titulek'] = 'Odebrání administrátora webu';
					$this->data['typ'] = 'Odebrání';
					$this->data['tlacitko'] = 'Odebrat';
					if (filter_input_array(INPUT_POST) && $_SESSION['admin'] == 1) {
						// Odebrání administrátora
						$spravceUzivatelu->upravaAdmina(filter_input(INPUT_POST, 'jmeno'), 0);
						$this->pridejZpravu('Administrátor ' . filter_input(INPUT_POST, 'jmeno') . ' byl úspěšně odebrán.');
					}
					break;
				default:
					$this->presmeruj('chyba');
			}
		} else {
			$this->presmeruj('chyba');
		}
	}

}

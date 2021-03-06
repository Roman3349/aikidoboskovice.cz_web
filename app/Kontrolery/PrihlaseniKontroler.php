<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;
use App\Modely\ChybaUzivatele;
use App\Modely\SpravceUzivatelu;

/**
 * Komtroler pro přihlášení
 */
class PrihlaseniKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		$spravceUzivatelu = new SpravceUzivatelu();
		$spravceUzivatelu->vratUzivatele() ? $this->presmeruj('administrace') : false;
		$this->hlavicka['titulek'] = 'Přihlášení';
		if (filter_input_array(INPUT_POST)) {
			try {
				$spravceUzivatelu->prihlas(filter_input(INPUT_POST, 'jmeno'), filter_input(INPUT_POST, 'heslo'));
				$this->pridejZpravu('Byl jste úspěšně přihlášen.');
				$this->presmeruj('administrace');
			} catch (ChybaUzivatele $chyba) {
				$this->pridejZpravu($chyba->getMessage());
			}
		}
		$this->sablona = 'prihlaseni';
	}

}

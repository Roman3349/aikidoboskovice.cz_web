<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;
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
		if ($_POST) {
			try {
				$spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
				$this->pridejZpravu('Byl jste úspěšně přihlášen.');
				$this->presmeruj('administrace');
			} catch (ChybaUzivatele $chyba) {
				$this->pridejZpravu($chyba->getMessage());
			}
		}
		$this->sablona = 'prihlaseni';
	}

}

<?php

namespace App\Kontrolery;

use App\Config\Config;
use App\Kontrolery\Kontroler;
use App\Modely\ChybaUzivatele;
use App\Modely\SpravceUzivatelu;
use ReCaptcha\ReCaptcha;

/**
 * Kontroler pro registraci uživatelů
 */
class RegistraceKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		$this->hlavicka['titulek'] = 'Registrace';
		if (filter_input_array(INPUT_POST)) {
			try {
				$recaptcha = new ReCaptcha(Config::captcha_secretkey);
				$odpoved = $recaptcha->verify(filter_input(INPUT_POST, 'g-recaptcha-response'), filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
				if ($odpoved->isSuccess()) {
					$spravceUzivatelu = new SpravceUzivatelu();
					$spravceUzivatelu->registruj(filter_input(INPUT_POST, 'jmeno'), filter_input(INPUT_POST, 'heslo'), filter_input(INPUT_POST, 'heslo_znovu'));
					$spravceUzivatelu->prihlas(filter_input(INPUT_POST, 'jmeno'), filter_input(INPUT_POST, 'heslo'));
					$this->pridejZpravu('Byl jste úspěšně zaregistrován.');
					$this->presmeruj('administrace');
				} else {
					$this->pridejZpravu('Zadal jste špatnou odpověď do antispamu.');
				}
			} catch (ChybaUzivatele $chyba) {
				$this->pridejZpravu($chyba->getMessage());
			}
		}
		$this->sablona = 'registrace';
		$this->data['sitekey'] = Config::captcha_sitekey;
	}

}

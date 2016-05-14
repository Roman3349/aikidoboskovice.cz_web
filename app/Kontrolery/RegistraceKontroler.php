<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;
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
		if ($_POST) {
			try {
				$recaptcha = new ReCaptcha(Config::captcha_secretkey);
				$odpoved = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
				if ($odpoved->isSuccess()) {
					$spravceUzivatelu = new SpravceUzivatelu();
					$spravceUzivatelu->registruj($_POST['jmeno'], $_POST['heslo'], $_POST['heslo_znovu']);
					$spravceUzivatelu->prihlas($_POST['jmeno'], $_POST['heslo']);
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

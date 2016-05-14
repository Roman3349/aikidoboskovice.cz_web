<?php

/**
 * Kontroler pro zpracovíní administrace
 */
class AdministraceKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		// Přístup mají jen přihlášení uživatelé
		$this->overUzivatele();
		$this->hlavicka['titulek'] = 'Administrace';
		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		if (!empty($parametry[0])) {
			switch ($parametry[0]) {
				case 'odhlasit':
					$spravceUzivatelu->odhlas();
					$this->presmeruj('prihlaseni');
					$this->pridejZpravu('Byli jste úspěšně odhlášeni.');
					break;
				case 'heslo':
					$this->sablona = 'heslo';
					$this->hlavicka['titulek'] = 'Změna hesla';
					if ($_POST) {
						try {
							$spravceUzivatelu->zmenHeslo($uzivatel['jmeno'], $_POST['heslo'], $_POST['nove_heslo'], $_POST['nove_heslo_znovu']);
							$spravceUzivatelu->odhlas();
							$this->presmeruj('prihlaseni');
							$this->pridejZpravu('Vaše heslo bylo úspěšně změněno.');
						} catch (ChybaUzivatele $chyba) {
							$this->pridejZpravu($chyba->getMessage());
						}
					}
					break;
				default :
					$this->presmeruj('chyba');
			}
		} else {
			$this->data['jmeno'] = $uzivatel['jmeno'];
			$this->data['admin'] = $uzivatel['admin'];
			$this->sablona = 'administrace';
		}
	}

}

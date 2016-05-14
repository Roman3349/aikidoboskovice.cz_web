<?php

/**
 * Kontroler pro výpis stránek
 */
class StrankaKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		$spravceStranek = new SpravceStranek();
		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel['admin'];
		if (!empty($parametry[1])) {
			// Je zadána URL stránky ke smazání
			if ($parametry[1] == 'odstranit' && $_SESSION['admin'] == 1) {
				// Nastavení přístupu pouze pro administrátory
				$this->jeAdmin();
				$spravceStranek->odstranStranku($parametry[0]);
				$this->pridejZpravu('Stránka byla úspěšně odstraněna');
				$this->presmeruj('stranka');
			} else {
				$this->presmeruj('chyba');
			}
			// Je zadána URL stránky k zobrazení
		} else if (!empty($parametry[0])) {
			// Získání článku pomocí URL
			$stranka = $spravceStranek->vratStranku($parametry[0]);
			// Pokud nebyla stránka s danou URL nalezena zoborazí se chyba 404
			!$stranka ? $this->presmeruj('chyba') : false;
			$this->hlavicka = ['titulek' => $stranka['titulek'],];
			$this->data['titulek'] = $stranka['titulek'];
			$this->data['obsah'] = $stranka['obsah'];
			$this->data['pridano'] = $spravceStranek->prevedCas($stranka['pridano']);
			$this->data['pridal'] = $stranka['pridal'];
			$this->data['url'] = $stranka['url'];
			$this->sablona = 'stranka';
			// Není zadáno URL článku, vypíšeme všechny
		} else {
			// Vrátí všechny stránky
			$stranky = $spravceStranek->vratStranky();
			$this->data['stranky'] = $stranky;
			$this->sablona = 'stranky';
			$this->hlavicka['titulek'] = 'Stránky';
		}
	}

}

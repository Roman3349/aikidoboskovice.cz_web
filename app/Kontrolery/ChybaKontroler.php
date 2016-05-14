<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;

/**
 * Kontroler pro zpracování chyby 404
 */
class ChybaKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		// Nastavení hlavičky požadavku
		header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
		$this->hlavicka['titulek'] = 'Chyba 404';
		$this->sablona = 'chyba';
	}

}

<?php

namespace App\Kontrolery;

use App\Kontrolery\Kontroler;
use App\Modely\SpravceStranek;
use App\Modely\SpravceEditoru;

/**
 * Kontroler pro editaci stránek
 */
class EditorKontroler extends Kontroler {

	/**
	 * @param array $parametry
	 */
	public function zpracuj($parametry) {
		// Nastavení přístupu pouze pro administrátory
		$this->jeAdmin();
		$this->hlavicka['titulek'] = 'Editor stránek';
		$spravceStranek = new SpravceStranek();
		// Příprava prázdné stránky
		$stranka = ['stranky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '', 'pridal' => ''];
		if (filter_input_array(INPUT_POST) && $_SESSION['admin'] == 1) {
			$post = filter_input_array(INPUT_POST);
			$post['titulek'] = trim($post['titulek']);
			$post['obsah'] = trim($post['obsah']);
			$post['url'] = trim($post['url']);
			$post['pridal'] = trim($post['pridal']);
			$stranka = $post;
			if (empty($post['titulek'])) {
				$this->pridejZpravu('Titulek musí být vyplněn.');
			} elseif (empty($post['obsah'])) {
				$this->pridejZpravu('Obsah musí být vyplněn.');
			} elseif (empty($post['url'])) {
				$this->pridejZpravu('URL musí být vyplněná.');
			} elseif (empty($post['pridal'])) {
				$this->pridejZpravu('Autor musí být vyplněn.');
			} else {
				// Získání dat z formuláře
				$klice = ['titulek', 'obsah', 'url', 'pridal'];
				$spravceEditoru = new SpravceEditoru();
				$post['obsah'] = $spravceEditoru->odstranJS($post['obsah']);
				$stranka = array_intersect_key($post, array_flip($klice));
				// Uložení stránky do databáze
				$spravceStranek->ulozStranku($post['stranky_id'], $stranka);
				$this->pridejZpravu('Stránka byla úspěšně uložena.');
				$this->presmeruj('stranka/' . $stranka['url']);
			}
			// Je zadaná URL článku k editaci
		} else if (!empty($parametry[0])) {
			// Vrátí stránku podle její URL adresy
			$nactenaStranka = $spravceStranek->vratStranku($parametry[0]);
			$nactenaStranka ? $stranka = $nactenaStranka : $this->pridejZpravu('Stránka nebyla nalezena');
		}
		$this->data['stranka'] = $stranka;
		$this->sablona = 'editor';
	}

}

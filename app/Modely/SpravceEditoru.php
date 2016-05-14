<?php

namespace App\Modely;

/**
 * Třída poskytuje metody pro správu editorů v redakčním systému
 */
class SpravceEditoru {

	/**
	 * Odstraní <script> tagy
	 * @param string $vstup
	 * @return string
	 */
	public function odstranJS($vstup) {
		return preg_replace('/(<script(.*?)>)(.*?)(<\/script>)/is', '', $vstup);
	}

}

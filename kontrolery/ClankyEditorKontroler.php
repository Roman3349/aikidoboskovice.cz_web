<?php

// Kontroler pro editaci článků

class ClankyEditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->overUzivatele(true);
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Editor článků';
        // Vytvoření instance modelu, který nám umožní pracovat s uživateli
        $spravceClanku = new SpravceClanku();
        // Příprava prázdného článku
        $clanek = array('clanky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '', 'pridal' => '');
        // Je odeslán formulář
        if ($_POST) {
            // Získání dat z formuláře
            $klice = array('titulek', 'obsah', 'url', 'pridal');
            $clanek = array_intersect_key($_POST, array_flip($klice));
            // Uložení článku do databáze
            $spravceClanku->ulozClanek($_POST['clanky_id'], $clanek);
            // Vypsání zprávy uživateli
            $this->pridejZpravu('Článek byl úspěšně uložen.');
            // Přesměruj na vytvořený článek
            $this->presmeruj('clanek/' . $clanek['url']);
            // Je zadaná URL článku k editaci
        } else if (!empty($parametry[0])) {
            $nactenyClanek = $spravceClanku->vratClanek($parametry[0]);
            if ($nactenyClanek) {
                $clanek = $nactenyClanek;
            } else {
                $this->pridejZpravu('Článek nebyl nalezen');
            }
        }
        // Naplnění proměnné pro šablonu
        $this->data['clanek'] = $clanek;
        // Nastavení šablony
        $this->pohled = 'ceditor';
    }

}

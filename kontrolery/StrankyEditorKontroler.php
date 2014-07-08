<?php

// Kontroler pro editaci stránek

class StrankyEditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->overUzivatele(true);
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Editor stránek';
        // Vytvoření instance modelu
        $spravceStranek = new SpravceStranek();
        // Příprava prázdné stránky
        $stranka = array('stranky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '',);
        // Je odeslán formulář
        if ($_POST) {
            // Získání dat z formuláře
            $klice = array('titulek', 'obsah', 'url',);
            $stranka = array_intersect_key($_POST, array_flip($klice));
            // Uložení stránky do databáze
            $spravceStranek->ulozStranku($_POST['stranky_id'], $stranka);
            $this->pridejZpravu('Stránka byla úspěšně uložena.');
            // Přesměruj na vytvořenou stránku
            $this->presmeruj('stranka/' . $stranka['url']);
            // Je zadaná URL článku k editaci
        } else if (!empty($parametry[0])) {
            $nactenaStranka = $spravceStranek->vratStranku($parametry[0]);
            if ($nactenaStranka) {
                $stranka = $nactenaStranka;
            } else {
                $this->pridejZpravu('Stránka nebyla nalezena');
            }
        }
        // Naplnění proměnné pro šablonu
        $this->data['stranka'] = $stranka;
        // Nastavení šablony
        $this->pohled = 'seditor';
    }

}

<?php

// Kontroler pro editaci stránek

class EditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->jeAdmin();
        $this->hlavicka['titulek'] = 'Editor stránek';
        $spravceStranek = new SpravceStranek();
        // Příprava prázdné stránky
        $stranka = ['stranky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '', 'pridal' => ''];
        if ($_POST && $_SESSION['admin'] == 1) {
            $_POST['titulek'] = trim($_POST['titulek']);
            $_POST['obsah'] = trim($_POST['obsah']);
            $_POST['url'] = trim($_POST['url']);
            $_POST['pridal'] = trim($_POST['pridal']);
            if (empty($_POST['titulek'])) {
                $this->pridejZpravu('Titulek musí být vyplněn.');
            } elseif (empty($_POST['obsah'])) {
                $this->pridejZpravu('Obsah musí být vyplněn.');
            } elseif (empty(['url'])) {
                $this->pridejZpravu('URL musí být vyplněná.');
            } elseif (empty($_POST['pridal'])) {
                $this->pridejZpravu('Autor musí být vyplněn.');
            } else {
                // Získání dat z formuláře
                $klice = ['titulek', 'obsah', 'url', 'pridal'];
                $spravceEditoru = new SpravceEditoru();
                $_POST['obsah'] = $spravceEditoru->odstranJS($_POST['obsah']);
                $stranka = array_intersect_key($_POST, array_flip($klice));
                // Uložení stránky do databáze
                $spravceStranek->ulozStranku($_POST['stranky_id'], $stranka);
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

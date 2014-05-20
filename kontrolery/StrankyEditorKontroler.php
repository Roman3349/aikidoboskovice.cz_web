<?php

class StrankyEditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->overUzivatele(true);
        $this->hlavicka['titulek'] = 'Editor stránek';
        $spravceStranek = new SpravceStranek();
        $stranka = array('stranky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '',);
        if ($_POST) {
            $klice = array('titulek', 'obsah', 'url',);
            $stranka = array_intersect_key($_POST, array_flip($klice));
            $spravceStranek->ulozStranku($_POST['stranky_id'], $stranka);
            $this->pridejZpravu('Stránka byla úspěšně uložena.');
            $this->presmeruj('stranka/' . $stranka['url']);
        } else if (!empty($parametry[0])) {
            $nactenaStranka = $spravceStranek->vratStranku($parametry[0]);
            if ($nactenaStranka) {
                $stranka = $nactenaStranka;
            } else {
                $this->pridejZpravu('Stránka nebyla nalezena');
            }
        }

        $this->data['stranka'] = $stranka;
        $this->pohled = 'editor';
    }

}

<?php

class EditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->overUzivatele(true);
        $this->hlavicka['titulek'] = 'Editor článků';
        $spravceClanku = new SpravceClanku();
        $clanek = array('id' => '', 'titulek' => '', 'obsah' => '', 'url' => '', 'popisek' => '', 'klicova_slova' => '',);
        if ($_POST) {
            $klice = array('titulek', 'obsah', 'url', 'popisek', 'klicova_slova');
            $clanek = array_intersect_key($_POST, array_flip($klice));
            $spravceClanku->ulozClanek($_POST['clanky'], $clanek);
            $this->pridejZpravu('Článek byl úspěšně uložen.');
            $this->presmeruj('clanek/' . $clanek['url']);
        } else if (!empty($parametry[0])) {
            $nactenyClanek = $spravceClanku->vratClanek($parametry[0]);
            if ($nactenyClanek) {
                $clanek = $nactenyClanek;
            } else {
                $this->pridejZpravu('Článek nebyl nalezen');
            }
        }

        $this->data['clanek'] = $clanek;
        $this->pohled = 'editor';
    }

}

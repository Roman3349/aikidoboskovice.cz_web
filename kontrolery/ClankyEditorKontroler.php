<?php

class ClankyEditorKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->overUzivatele(true);
        $this->hlavicka['titulek'] = 'Editor článků';
        $spravceClanku = new SpravceClanku();
        $clanek = array('clanky_id' => '', 'titulek' => '', 'obsah' => '', 'url' => '');
        if ($_POST) {
            $klice = array('titulek', 'obsah', 'url');
            $clanek = array_intersect_key($_POST, array_flip($klice));
            $spravceClanku->ulozClanek($_POST['clanky_id'], $clanek);
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
        $this->pohled = 'ceditor';
    }

}

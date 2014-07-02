<?php

class SpravceStranek {

    public function vratStranku($url) {
        return Db::dotazJeden('SELECT `stranky_id`, `titulek`, `obsah`, `url` FROM `stranky` WHERE `url` = ?', array($url));
    }

    public function ulozStranku($id, $stranka) {
        if (!$id) {
            Db::vloz('stranky', $stranka);
        } else {
            Db::zmen('stranky', $stranka, 'WHERE `stranky_id` = ?', array($id));
        }
    }

    public function vratStranky() {
        return Db::dotazVsechny('SELECT `stranky_id`, `titulek`, `url` FROM `stranky` ORDER BY `stranky_id` DESC');
    }

    public function odstranStranku($url) {
        Db::dotaz('DELETE FROM `stranky` WHERE `url` = ?', array($url));
    }

}

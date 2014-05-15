<?php

use Db;

class SpravceClanku {

    public function vratStranku($url) {
        return Db::dotazJeden('SELECT `id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova` FROM `stranky` WHERE `url` = ?', array($url));
    }

    public function ulozStranku($id, $stranka) {
        if (!$id) {
            Db::vloz('stranky', $stranka);
        } else {
            Db::zmen('stranky', $stranka, 'WHERE id = ?', array($id));
        }
    }

    public function vratStranky() {
        return Db::dotazVsechny('SELECT `id`, `titulek`, `url`, `popisek` FROM `stranky` ORDER BY `id` DESC');
    }

    public function odstranClanek($url) {
        Db::dotaz('DELETE FROM clanky WHERE url = ? ', array($url));
    }

}

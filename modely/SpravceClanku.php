<?php

use Db;

class SpravceClanku {

    public function vratClanek($url) {
        return Db::dotazJeden('SELECT `id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova` FROM `clanky` WHERE `url` = ?', array($url));
    }

    public function ulozClanek($id, $clanek) {
        if (!$id) {
            Db::vloz('clanky', $clanek);
        } else {
            Db::zmen('clanky', $clanek, 'WHERE id = ?', array($id));
        }
    }

    public function vratClanky() {
        return Db::dotazVsechny('SELECT `id`, `titulek`, `url`, `popisek` FROM `clanky` ORDER BY `id` DESC');
    }

    public function odstranClanek($url) {
        Db::dotaz('DELETE FROM clanky WHERE url = ? ', array($url));
    }

}

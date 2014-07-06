<?php

class SpravceClanku {

    public function vratClanek($url) {
        return Db::dotazJeden('SELECT `clanky_id`, `titulek`, `obsah`, `url`, `pridal`, `pridano` FROM `clanky` WHERE `url` = ?', array($url));
    }

    public function ulozClanek($id, $clanek) {
        if (!$id) {
            Db::vloz('clanky', $clanek);
        } else {
            Db::zmen('clanky', $clanek, 'WHERE clanky_id = ?', array($id));
        }
    }

    public function vratClanky() {
        return Db::dotazVsechny('SELECT `clanky_id`, `titulek`, `obsah`, `url`, `pridal`, `pridano` FROM `clanky` ORDER BY `clanky_id` DESC');
    }

    public function odstranClanek($url) {
        Db::dotaz('DELETE FROM clanky WHERE url = ?', array($url));
    }
}

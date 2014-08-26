<?php

// Správce ticketů redakčního systému

class SpravceTicketu {

    // Vrátí seznam ticketů v databázi
    public function vratTickety() {
        return Db::dotazVsechny('SELECT `id`, `nazev`, `pridal`, `pridano`, `stav` FROM `tickety` ORDER BY `pridano` DESC');
    }

}

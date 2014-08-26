<?php

// Kontroler pro tickety

class TicketKontroler extends Kontroler {

    public function zpracuj($parametry) {
        if ($parametry[0] == 'pridat') {
            // Nastavení šablony
            $this->pohled = 'pridatticket';
            // Nastavení hlavičky
            $this->hlavicka['titulek'] = "Přidání ticketu";
        }
    }

}

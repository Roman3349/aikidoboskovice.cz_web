<?php

// Kontroler pro vypis serverů

class ServeryKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Natavení šablony
        $this->pohled = 'servery';
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Servery';
    }

}

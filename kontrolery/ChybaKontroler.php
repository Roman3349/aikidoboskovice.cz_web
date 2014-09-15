<?php

// Kontroler pro zpracování chyby 404

class ChybaKontroler extends Kontroler {

    public function zpracuj($parametry) {
        // Nastavení hlavičky požadavku
        header('HTTP/1.0 404 Not Found');
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Chyba 404';
        // Nastavení šablony
        $this->pohled = 'chyba';
    }

}

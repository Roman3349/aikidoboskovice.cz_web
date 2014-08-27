<?php

// Třída poskytuje metody pro správu serverů v redakčním systému

class SpravceServeru {

    // Vrátí informace o serveru
    public function vratServer($ip) {
        return json_decode(file_get_contents($ip));
    }

}

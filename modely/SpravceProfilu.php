<?php

// Třída poskytuje metody pro správu profilu uživatelů v redakčním systému

class SpravceProfilu {

    // Převede čas z AuthMe do normálního
    public function prevedCas($cas) {
        // Převod AuthMe času na čas unixový
        $unix_time = $cas / 1000;
        // Převod unixového času na datum a čas
        $lastlogin = date('j. n. Y, G:i', $unix_time);
        return $lastlogin;
    }

}

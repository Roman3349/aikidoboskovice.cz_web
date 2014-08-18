<?php

// Třída poskytuje metody pro správu SMS v redakčním systému

class SpravceSMS {

    // Vrátí seznam SMS plateb v databázi
    public function vratSMS() {
        return SMS::dotazVsechny('SELECT * FROM mp_vypis ORDER BY datum DESC');
    }

}

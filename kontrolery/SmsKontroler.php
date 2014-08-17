<?php

// Kontroler pro výpis SMS plateb
class SmsKontroler extends Kontroler {
    
    public function zpracuj($parametry) {
        // Nastavení přístupu pouze pro administrátory
        $this->overUzivatele(true);
        // Nastavení hlavičky
        $this->hlavicka['titulek'] = 'Seznam SMS plateb';
        // Nastavení šablony
        $this->pohled = 'sms';
        // Vytvoření instance modelu, který nám umožní pracovat se SMS platbami
        $spravceSMS = new SpravceSMS();
        $SMS = $spravceSMS->vratSMS();
        // Naplnění proměnných pro šablonu
        $this->data['platby'] = $SMS;
        $this->data['poradi'] = 1;
    }
}

<?php

class ServeryKontroler extends Kontroler {

    public function zpracuj($parametry) {
        $this->pohled = 'servery';
        $this->hlavicka['titulek'] = 'Servery';
    }

}

<?php

// Třída poskytuje metody pro správu editorů v redakčním systému

class SpravceEditoru {

    public function odstranJS($vstup) {
        return preg_replace('/(<script(.*?)>)(.*?)(<\/script>)/is', '', $vstup);
    }

}

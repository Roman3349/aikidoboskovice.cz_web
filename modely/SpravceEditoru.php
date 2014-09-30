<?php

// Třída poskytuje metody pro správu editorů v redakčním systému

class SpravceEditoru {

    private static $_script_serialization_pattern = '/(<script(.*?)>)(.*?)(<\/script>)/is';
    private static $_script_serialization_replacement = '$1<![CDATA[$3]]>$4';

    public function odstranJS($vstup) {
        return preg_replace(static::$_script_serialization_pattern, '', $vystup);
    }

    private function serialize_scripts($input) {
        return preg_replace(static::$_script_serialization_pattern, static::$_script_serialization_replacement, $input);
    }

}

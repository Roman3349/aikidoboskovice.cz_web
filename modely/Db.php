<?php

class Db {

    private static $spojeni;
    private static $nastaveni = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function pripoj($host, $uzivatel, $heslo, $databaze) {
        if (!isset(self::$spojeni)) {
            self::$spojeni = new PDO("mysql:host=$host;dbname=$databaze", $uzivatel, $heslo, self::$nastaveni);
        }
    }

    public static function dotazJeden($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    public static function dotazVsechny($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    public static function dotazSamotny($dotaz, $parametry = array()) {
        return self::dotazJeden($dotaz, $parametry)[0];
    }

    public static function dotaz($dotaz, $parametry = array()) {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }

    public static function vloz($tabulka, $parametry = array()) {
        return self::dotaz("INSERT INTO `$tabulka` (`" . implode('`, `', array_keys($parametry)) . "`) VALUES (" . str_repeat('?,', sizeOf($parametry) - 1) . "?)", array_values($parametry));
    }

    public static function zmen($tabulka, $hodnoty = array(), $podminka, $parametry = array()) {
        return self::dotaz("UPDATE `$tabulka` SET `" . implode('` = ?, `', array_keys($hodnoty)) . "` = ? " . $podminka, array_merge(array_values($hodnoty), $parametry));
    }

    public static function getLastId() {
        return self::$spojeni->lastInsertId();
    }

}

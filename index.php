<?php

session_start();
mb_internal_encoding("UTF-8");

function autoloadFunkce($trida) {
    if (preg_match('/Kontroler$/', $trida)) {
        require("kontrolery/" . $trida . ".php");
    } else {
        require("modely/" . $trida . ".php");
    }
}

spl_autoload_register("autoloadFunkce");

Db::pripoj("wm51.wedos.net", "a56515_new", "LSU9Qgq4", "d56515_new");
MC::pripoj("93.91.240.147", "151812_mysql_db", "fdsdfghgfdsfg", "151812_mysql_db");
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
$smerovac->vypisPohled();

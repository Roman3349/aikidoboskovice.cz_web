<?php

session_start();

// Nastavení interního kódování
mb_internal_encoding("UTF-8");

// Callback pro automatické načítání tříd controllerů a modelů
function autoloadFunkce($trida) {
    if (preg_match('/Kontroler$/', $trida)) {
        require("kontrolery/" . $trida . ".php");
    } else {
        require("modely/" . $trida . ".php");
    }
}

// Registrace callbacku
spl_autoload_register("autoloadFunkce");

// Připojení k MySQL databázi webového serveru
// Db::pripoj("HOST", "USER", "PASSWORD", "DATABASE");
Db::pripoj("wm51.wedos.net", "a56515_new", "LSU9Qgq4", "d56515_new");

// Připojení k MySQL databázi Minecraftového serveru
// MC::pripoj("HOST", "USER", "PASSWORD", "DATABASE");
MC::pripoj("93.91.250.215", "120644_mysql_db", "nbvcxsertzhdfd", "120644_mysql_db");

// Připojení k MySQL databázi SMS plateb
// SMS::pripoj("HOST", "USER", "PASSWORD", "DATABASE");
SMS::pripoj("mysql.fakaheda.eu", "107281_web", "dasdda45dasd", "107281_web");

// Vytvoření routeru a zpracování URL uživatele
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
// Vyrenderování šablony
$smerovac->vypisPohled();

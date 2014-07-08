<?php

// Tento soubor musí být v rootu webhostingu! Jinak web nebude fungovat !!

session_start();

//Nastavení interního kódování
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

MC::pripoj("93.91.240.147", "151812_mysql_db", "fdsdfghgfdsfg", "151812_mysql_db");

// Vytvoření routeru a zpracování URL uživatele
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
//renderování šablony
$smerovac->vypisPohled();

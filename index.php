<?php

// Hlavička pro session
session_start();

// Nastavení interního kódování
mb_internal_encoding('UTF-8');

// Callback pro automatické načítání tříd controllerů a modelů
function autoloadFunkce($trida) {
    require preg_match('/Kontroler$/', $trida) ? 'kontrolery/' . $trida . '.php' : 'modely/' . $trida . '.php';
}

// Registrace callbacku
spl_autoload_register('autoloadFunkce');

// Připojení k MySQL databázi webového serveru
// Db::pripoj('HOST', 'USER', 'PASSWORD', 'DATABASE');
Db::pripoj('localhost', 'aikidobce321', 'LJeQsYYmSj', 'aikidobce321');

// Vytvoření routeru a zpracování URL uživatele
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
// Vyrenderování šablony
$smerovac->vypisPohled();

<?php

require 'config.php';
require 'vendor/recaptcha/autoload.php';

// Zapnutí HTTP Only cookies
ini_set('session.cookie_httponly', 1);
// Vypnutí přenosu cookies pomocí URL
ini_set('session.use_trans_sid', 0);
// Nastavení maximální délky života cookies
ini_set('session.cookie_lifetime', 21600);
// Nastavení hashovací funkce pro generování session ID
ini_set('session.hash_function', 'sha512');
// Nastavení délky entropie
ini_set('session.entropy_length', 256);
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
Db::pripoj(Config::db_host, Config::db_user, Config::db_pass, Config::db_db);

// Vytvoření routeru a zpracování URL uživatele
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj([$_SERVER['REQUEST_URI']]);
// Vyrenderování šablony
$smerovac->vypisPohled();

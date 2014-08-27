<?php

$spravceServeru = new SpravceServeru;

$E = $spravceServeru->vratServer("http://query.fakaheda.eu/93.91.250.215:25565.feed");
$SB = $spravceServeru->vratServer("http://query.fakaheda.eu/93.91.250.139:27548.feed");
$TS3 = $spravceServeru->vratServer("http://query.fakaheda.eu/81.0.217.180:7235.feed");
$Creative = $spravceServeru->vratServer("http://query.fakaheda.eu/93.91.250.120:27639.feed");
$TF2 = $spravceServeru->vratServer("http://query.fakaheda.eu/217.11.249.93:27554.feed");
$PVP = $spravceServeru->vratServer("http://query.fakaheda.eu/93.91.250.122:27368.feed");

$Players = $E->players + $SB->players + $TS3->players + $Creative->players + $TF2->players + $PVP->players;
$Slots = $E->slots + $SB->slots + $TS3->slots + $Creative->slots + $TF2->slots + $PVP->slots;

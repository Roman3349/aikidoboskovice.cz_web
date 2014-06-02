<?php

$E1 = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.215:25565.feed"));
$E2 = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.200:25565.feed"));
$SB = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.139:27548.feed"));
$Classic = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.140:27884.feed"));
$CtF = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.143:27192.feed"));
$TS3 = json_decode(file_get_contents("http://query.fakaheda.eu/81.0.217.180:7235.feed"));
$Lobby = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.152:27871.feed"));
$Creative = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.120:27639.feed"));
$TF2 = json_decode(file_get_contents("http://query.fakaheda.eu/217.11.249.93:27554.feed"));

$Players = $E1->players + $E2->players + $SB->players + $Classic->players + $CtF->players + $TS3->players + $Lobby->players + $Creative->players + $TF2->players;
$Slots = $E1->slots + $E2->slots + $SB->slots + $Classic->slots + $CtF->slots + $TS3->slots + $Lobby->slots + $Creative->slots + $TF2->slots;

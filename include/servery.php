<?php

$E1 = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.215:25565.feed"));
$E2 = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.200:25565.feed"));
$SB = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.139:27548.feed"));
$Classic = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.140:27884.feed"));
$CarMC = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.138:27052.feed"));
$FC = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.103:27789.feed"));
$CtF = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.143:27192.feed"));
$TS3 = json_decode(file_get_contents("http://query.fakaheda.eu/81.0.217.180:7235.feed"));
$Lobby = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.152:27871.feed"));

$Players = $E1->players + $E2->players + $SB->players + $Classic->players + $CarMC->players + $FC->players + $CtF->players + $TS3->players + $Lobby->players;
$Slots = $E1->slots + $E2->slots + $SB->slots + $Classic->slots + $CarMC->slots + $FC->slots + $CtF->slots + $TS3->slots + $Lobby->slots;

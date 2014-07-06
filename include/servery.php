<?php

$E = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.215:25565.feed"));
$SB = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.139:27548.feed"));
$CtF = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.143:27192.feed"));
$TS3 = json_decode(file_get_contents("http://query.fakaheda.eu/81.0.217.180:7235.feed"));
$Lobby = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.152:27871.feed"));
$Creative = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.120:27639.feed"));
$TF2 = json_decode(file_get_contents("http://query.fakaheda.eu/217.11.249.93:27554.feed"));
$FC = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.128:27308.feed"));
$PVP = json_decode(file_get_contents("http://query.fakaheda.eu/93.91.250.122:27368.feed"));

$Players = $E->players + $SB->players + $CtF->players + $TS3->players + $Lobby->players + $Creative->players + $TF2->players + $FC->players + $PVP->players;
$Slots = $E->slots + $SB->slots + $CtF->slots + $TS3->slots + $Lobby->slots + $Creative->slots + $TF2->slots + $FC->slots + $PVP->slots;

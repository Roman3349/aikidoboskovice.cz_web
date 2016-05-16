CREATE TABLE `clanky` (
  `clanky_id` int(11) NOT NULL,
  `url` varchar(155) DEFAULT NULL,
  `titulek` varchar(155) DEFAULT NULL,
  `obsah` text,
  `publikovano` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `stranky` (
  `stranky_id` int(11) NOT NULL,
  `titulek` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `obsah` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `pridal` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pridano` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

ALTER TABLE `clanky`
  ADD PRIMARY KEY (`clanky_id`),
  ADD KEY `url` (`url`);

ALTER TABLE `stranky`
  ADD PRIMARY KEY (`stranky_id`);

ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `jmeno` (`jmeno`);

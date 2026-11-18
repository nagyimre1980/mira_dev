<?php

function admin_backup_terv1_masol_proc_db_letrehoz($ev){
$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

//-- Tábla szerkezet ehhez a táblához `backup_adat_".$ev."_teny_1`
$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_1` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_user_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny1_ora_egesz` decimal(7,2) DEFAULT 0.00,
  `rogzitett_teny1_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny1_perc` mediumint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

//-- A tábla indexei `backup_adat_".$ev."_teny_1`
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_1`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_user_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_szerv_id` (`backup_user_id`);
";

//-- Megkötések a táblához `backup_adat_".$ev."_teny_1`
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_1`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_1_ibfk_1` FOREIGN KEY (`backup_ver_id`) REFERENCES `backup_ver` (`backup_ver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_1_ibfk_2` FOREIGN KEY (`backup_user_id`) REFERENCES `backup_user` (`backup_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
";

$sql.="
SET FOREIGN_KEY_CHECKS=1;
";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;
}

function admin_backup_terv2_masol_proc_db_letrehoz($ev){
$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

//-- Tábla szerkezet ehhez a táblához `backup_adat_".$ev."_teny_2`
$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_2` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_szerv_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny2_ora_egesz` decimal(7,2) DEFAULT 0.00,
  `rogzitett_teny2_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny2_perc` mediumint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

//-- A tábla indexei `backup_adat_".$ev."_teny_2`
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_2`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_szerv_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_szerv_id` (`backup_szerv_id`);
";

//-- Megkötések a táblához `backup_adat_".$ev."_teny_2`
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_2`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_2_ibfk_1` FOREIGN KEY (`backup_ver_id`) REFERENCES `backup_ver` (`backup_ver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_2_ibfk_2` FOREIGN KEY (`backup_szerv_id`) REFERENCES `backup_szerv` (`backup_szerv_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
";

$sql.="
SET FOREIGN_KEY_CHECKS=1;
";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;
}

function admin_backup_terv3_1_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_3_1` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_user_id` int(8) UNSIGNED NOT NULL,
  `backup_szerv_id` int(8) UNSIGNED NOT NULL,
  `backup_pojekt_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny3_ora_egesz` decimal(11,2) DEFAULT 0.00,
  `rogzitett_teny3_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny3_perc` mediumint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_1`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_user_id`,`backup_pojekt_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_user_id` (`backup_user_id`),
  ADD KEY `backup_szerv_id` (`backup_szerv_id`),
  ADD KEY `backup_pojekt_id` (`backup_pojekt_id`);
";
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_1`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_ibfk_1` FOREIGN KEY (`backup_user_id`) REFERENCES `backup_user` (`backup_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_ibfk_2` FOREIGN KEY (`backup_szerv_id`) REFERENCES `backup_szerv` (`backup_szerv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_ibfk_3` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
";
$sql.="
COMMIT;
SET FOREIGN_KEY_CHECKS=1;

";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;

}


function admin_backup_terv3_1_1_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_3_1_1` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_user_id` int(8) UNSIGNED NOT NULL,
  `backup_szerv_id` int(8) UNSIGNED NOT NULL,
  `backup_pojekt_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny3_ora_egesz` decimal(11,2) DEFAULT 0.00,
  `rogzitett_teny3_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny3_perc` decimal(11,4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_1_1`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_user_id`,`backup_pojekt_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_user_id` (`backup_user_id`),
  ADD KEY `backup_szerv_id` (`backup_szerv_id`),
  ADD KEY `backup_pojekt_id` (`backup_pojekt_id`);
";
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_1_1`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_1_ibfk_1` FOREIGN KEY (`backup_user_id`) REFERENCES `backup_user` (`backup_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_1_ibfk_2` FOREIGN KEY (`backup_szerv_id`) REFERENCES `backup_szerv` (`backup_szerv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_1_1_ibfk_3` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
";
$sql.="
COMMIT;
SET FOREIGN_KEY_CHECKS=1;

";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;

}

function admin_backup_terv3_3_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_3_3` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_pojekt_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny3_ora_egesz` decimal(11,2) DEFAULT 0.00,
  `rogzitett_teny3_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny3_perc` decimal(11,4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_3`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_pojekt_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_pojekt_id` (`backup_pojekt_id`);

";

$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_3`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_3_ibfk_2` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

";
$sql.="
COMMIT;
SET FOREIGN_KEY_CHECKS=1;
";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;
}

function admin_backup_terv3_2_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_3_2` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_szerv_id` int(8) UNSIGNED NOT NULL,
  `backup_pojekt_id` int(8) UNSIGNED NOT NULL,
  `rogzitett_teny3_ora_egesz` decimal(11,2) DEFAULT 0.00,
  `rogzitett_teny3_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny3_perc` decimal(11,4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_2`
  ADD PRIMARY KEY (`backup_ver_id`,`backup_szerv_id`,`backup_pojekt_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_szerv_id` (`backup_szerv_id`),
  ADD KEY `backup_pojekt_id` (`backup_pojekt_id`);

";

$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3_2`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_2_ibfk_1` FOREIGN KEY (`backup_szerv_id`) REFERENCES `backup_szerv` (`backup_szerv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_2_ibfk_2` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

";
$sql.="
COMMIT;
SET FOREIGN_KEY_CHECKS=1;
";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;
}

function admin_backup_terv3_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
";

$sql.="
CREATE TABLE `backup_adat_".$ev."_teny_3` (
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `projekt_tervkod` varchar(8) NOT NULL DEFAULT '',
  `projekt_tagv_kod` varchar(4) NOT NULL DEFAULT '',
  `projekt_szolg_kod` varchar(4) NOT NULL DEFAULT '',
  `rogzitett_teny3_ora_egesz` decimal(11,2) DEFAULT 0.00,
  `rogzitett_teny3_ora` mediumint(3) UNSIGNED DEFAULT NULL,
  `rogzitett_teny3_perc` decimal(11,4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

";

/*
-- A tábla indexei `backup_adat_".$ev."_teny_3`
*/
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3`
  ADD PRIMARY KEY (`backup_ver_id`,`projekt_tagv_kod`,`projekt_szolg_kod`),
  ADD KEY `projekt_tervkod` (`projekt_tervkod`),
  ADD KEY `projekt_tagv_kod` (`projekt_tagv_kod`),
  ADD KEY `projekt_szolg_kod` (`projekt_szolg_kod`),
  ADD KEY `backup_ver_id` (`backup_ver_id`);
";

/*
-- Megkötések a táblához `backup_adat_".$ev."_teny_3`
*/
$sql.="
ALTER TABLE `backup_adat_".$ev."_teny_3`
  ADD CONSTRAINT `backup_adat_".$ev."_teny_3_ibfk_1` FOREIGN KEY (`backup_ver_id`) REFERENCES `backup_ver` (`backup_ver_id`) ON DELETE CASCADE ON UPDATE CASCADE;
";

$sql.="
SET FOREIGN_KEY_CHECKS=1;
";

//echo $sql;
//exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	//echo 'oké';
}else{
 echo("Error description mysqli_errno: " . mysqli_errno($GLOBALS['mysqli']));
 echo '<br><br>';
 echo("Error description mysqli_error: " . mysqli_error($GLOBALS['mysqli']));
 echo '<br><br>';
 return false;
}

return true;
}

?>
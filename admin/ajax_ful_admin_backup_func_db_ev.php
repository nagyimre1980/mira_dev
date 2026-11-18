<?php


function db_table_letezik_e($tabla_nev){
 $eredmeny_keres=false;
 $tabla_nev=mysqli_real_escape_string($GLOBALS['mysqli'],$tabla_nev);
 $sql="SHOW TABLES like '".$tabla_nev."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres=true;
 }
 return $eredmeny_keres;
}

function admin_backup_masol_proc_db_letrehoz($ev){

$sql="
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION; ";

/*
--
-- Tábla szerkezet ehhez a táblához `backup_adat_".$ev."`
--
*/
$sql.="
CREATE TABLE `backup_adat_".$ev."` (
  `backup_adat_id` int(8) UNSIGNED NOT NULL,
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_user_id` int(8) UNSIGNED DEFAULT NULL,
  `backup_szerv_id` int(8) UNSIGNED DEFAULT NULL,
  `backup_pojekt_id` int(8) UNSIGNED DEFAULT NULL,
  `backup_tavollet` enum('0','1') DEFAULT NULL,
  `backup_rogzit_nap` date NOT NULL DEFAULT '0000-00-00',
  `backup_rogzit_ora` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `backup_rogzit_perc` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

/*
--
-- Tábla szerkezet ehhez a táblához `backup_adat_reszletek_".$ev."`
--
*/

$sql.="
CREATE TABLE `backup_adat_reszletek_".$ev."` (
  `backup_adat_reszletek_id` mediumint(3) UNSIGNED NOT NULL,
  `backup_ver_id` smallint(2) UNSIGNED NOT NULL,
  `backup_adat_id` int(8) UNSIGNED NOT NULL,
  `backup_adat_user_ad` varchar(17) NOT NULL,
  `backup_adat_user_nev` varchar(255) NOT NULL,
  `backup_rogzit_sor_update_time` datetime DEFAULT NULL,
  `backup_rogzit_megj` text DEFAULT NULL,
  `backup_rogzit_sor_megj` text DEFAULT NULL,
  `backup_helyettes_rogzito` enum('0','1') NOT NULL DEFAULT '0',
  `backup_helyettes_rogzito_nev` varchar(255) DEFAULT NULL,
  `backup_ellenorzesre_lezarva` enum('0','1') NOT NULL DEFAULT '0',
  `backup_ellenorzesre_lezarva_mikor` datetime DEFAULT NULL,
  `backup_ellenorzesre_lezarva_jovahagyo` enum('0','1') NOT NULL DEFAULT '0',
  `backup_ellenorzesre_lezarva_jovahagyo_ki_nev` varchar(255) DEFAULT NULL,
  `backup_projekt_jovahagyo_elutasitva` enum('0','1') NOT NULL DEFAULT '0',
  `backup_projekt_jovahagyo_elutasitva_nev` varchar(255) DEFAULT NULL,
  `backup_projekt_jovahagyo_elutasitva_mikor` datetime DEFAULT NULL,
  `backup_projekt_jovahagyo_jovahagyva` enum('0','1') NOT NULL DEFAULT '0',
  `backup_projekt_jovahagyo_jovahagyva_nev` varchar(255) DEFAULT NULL,
  `backup_projekt_jovahagyo_jovahagyva_mikor` datetime DEFAULT NULL,
  `backup_ellenorzesre_visszakuldve` enum('0','1') NOT NULL DEFAULT '0',
  `backup_ellenorzesre_visszakuldve_ki_nev` varchar(255) DEFAULT NULL,
  `backup_ellenorzesre_visszakuldve_mikor` datetime DEFAULT NULL,
  `backup_ellenorzesre_ok` enum('0','1') NOT NULL DEFAULT '0',
  `backup_ellenorzesre_ok_ki_nev` varchar(255) DEFAULT NULL,
  `backup_ellenorzesre_ok_mikor` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
";

/*
--
-- A tábla indexei `backup_adat_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_".$ev."`
  ADD PRIMARY KEY (`backup_adat_id`),
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_szerv_id` (`backup_szerv_id`),
  ADD KEY `backup_pojekt_id` (`backup_pojekt_id`),
  ADD KEY `backup_user_id` (`backup_user_id`);
";

/*
--
-- A tábla indexei `backup_adat_reszletek_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_reszletek_".$ev."`
  ADD PRIMARY KEY (`backup_adat_reszletek_id`) USING BTREE,
  ADD KEY `backup_ver_id` (`backup_ver_id`),
  ADD KEY `backup_adat_id` (`backup_adat_id`);
";

/*
--
-- A kiírt táblák AUTO_INCREMENT értéke
--


--
-- AUTO_INCREMENT a táblához `backup_adat_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_".$ev."`
  MODIFY `backup_adat_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
";

/*
--
-- AUTO_INCREMENT a táblához `backup_adat_reszletek_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_reszletek_".$ev."`
  MODIFY `backup_adat_reszletek_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
";

/*
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `backup_adat_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_".$ev."`
  ADD CONSTRAINT `backup_adat_".$ev."_ibfk_1` FOREIGN KEY (`backup_ver_id`) REFERENCES `backup_ver` (`backup_ver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_ibfk_2` FOREIGN KEY (`backup_szerv_id`) REFERENCES `backup_szerv` (`backup_szerv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_ibfk_3` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_".$ev."_ibfk_4` FOREIGN KEY (`backup_pojekt_id`) REFERENCES `backup_pojekt` (`backup_pojekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
";
/*
--
-- Megkötések a táblához `backup_adat_reszletek_".$ev."`
--
*/

$sql.="
ALTER TABLE `backup_adat_reszletek_".$ev."`
  ADD CONSTRAINT `backup_adat_reszletek_".$ev."_ibfk_1` FOREIGN KEY (`backup_adat_id`) REFERENCES `backup_adat_".$ev."` (`backup_adat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `backup_adat_reszletek_".$ev."_ibfk_2` FOREIGN KEY (`backup_ver_id`) REFERENCES `backup_ver` (`backup_ver_id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
";

//echo $sql;exit;
if (mysqli_multi_query($GLOBALS['mysqli'], $sql)) {
	while(mysqli_next_result($GLOBALS['mysqli'])){;}
	
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
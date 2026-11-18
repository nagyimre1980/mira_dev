<?php
/*
Figyelmeztetést küld azoknak, akiknek nincs lezárt hónapjuk
Paraméterből futhat, bármikor, vagy csak a hónap első munkanapján.
	Ez a paraméter max akkor lesz használva, ha gond van.
Órát nem kell figyelni, azt majd a meghívó intézi!
*/
include_once("../config_uj.php");
include_once("../function.php");
include_once("../function_mysql.php");
include_once("function_email.php");

nincs_lezarva_fut("kont");

function nincs_lezarva_fut($tagv){

if(honap_elso_munkanapja_mavane($tagv)){//Csak ha ma van az első munkanap
	//echo "<br><br><b>Ma van hónap első munkanapja!</b>";
	$ma_most = date("Y-m",time());
	$elozo_ho = date('Y-m', strtotime('-1 month', (strtotime($ma_most))));
	//echo "Előző hó:".$elozo_ho;
	email_nincs_lezarva_kikuld($tagv,$elozo_ho);
}
}
?>
<?php
/*
Figyelmeztetést küld a jóváhagyóknak,
	- Akiknek van olyan munkavállalójuk, akiknek nincs jóváhagyva a hónapjuk
	- Azoknak is küld, akiknem nincs lezárva, ezt a levélben felsorolással oda is írja.
Paraméterből futhat, bármikor, vagy csak a hónap első munkanapján.
	Ez a paraméter max akkor lesz használva, ha gond van.
Órát nem kell figyelni, azt majd a meghívó intézi!
	Így lehet aznap többször is futtatni. Kézi futtatás Admin felületről.
*/
include_once("../config_uj.php");
include_once("../function_mysql.php");
include_once("function_email.php");
?>
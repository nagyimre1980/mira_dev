<?php

function gen_keress_stat_rogzitett($ev,$ho,$tipus,$excel){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['idoszak_nap']);
if(isset($_POST['szerv_id']))
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['szerv_id']);
else
 $szerv_id="all";

if(isset($_POST['projekt_id']))
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['projekt_id']);
else
 $projekt_id="all";

if($ho!="all"){
 if($ho<10)$ho="0".$ho;
}
if(($nap!="all")and($ho<10))$nap="0".$nap;

$orderby="";
if(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $orderby="order by mira_user.user_nev,rogzit.rogzit_nap,projekt.projekt_nev asc";
}elseif($tipus=="user_napi"){
 $orderby="order by mira_user.user_nev asc";
}elseif($tipus=="napi_user"){
 //$orderby="order by rogzit.rogzit_nap asc";
 $orderby="order by mira_user.user_nev asc";
}elseif($tipus=="projekt_szerv"){
 //$orderby="order by projekt.projekt_nev, mira_szerv.szerv_nev asc";
 //$orderby="order by projekt.projekt_nev, mira_szerv.szerv_nev asc";
 $orderby="order by projekt.projekt_nev asc";//V1.035
}elseif($tipus=="projekt_napi"){
 $orderby="order by projekt.projekt_nev asc";
}elseif($tipus=="szerv_projekt"){
 //$orderby="order by mira_szerv.szerv_nev,projekt.projekt_nev asc";
 $orderby="order by mira_szerv.szerv_nev asc";//V1.035
}elseif($tipus=="szervezet_napi"){
 $orderby="order by mira_szerv.szerv_nev asc";
}

//where - eleje
//$where=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
$where=" mira_user.ful_rogzit='1' ";
//$where=" mira_user.ful_rogzit=1 ";
//Hogy üres ne legyen látható.
/*
$where.=" and ( 
((rogzit.rogzit_id IS NULL)and(mira_user.user_inaktiv='0'))OR
(rogzit.tavollet='1') or (rogzit_sor.rogzit_ora!='0') or (rogzit_sor.rogzit_perc!='0'))";
*/

if(isset($_POST['user']))
if($_POST['user']!="all"){
 $_POST['user']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user']);
 $where.=" and mira_user.user_ad='".$_POST['user']."' ";
}

/*if(($tipus=="szervezet_napi")or($tipus=="szerv_projekt")){
 $where.=" and rogzit_sor.rogzit_id is not null ";
}*/

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")or($tipus=="szerv_projekt")){
$where.=" and rogzit_sor.projekt_id is not null ";
}

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
 //$where.=" and rogzit_sor.projekt_id is not null ";
 $where.=" and rogzit_sor.rogzit_id is not null ";
}

if($szerv_id!="all"){
 $where.=" and mira_szerv.szerv_id='".$szerv_id."' ";
}elseif(($tipus!='reszletes3')and($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']!=1)){//Áll esetén ha nem az összesre van joga
 $tomb_stat_jog_szerv=keres_user_stat_szerv_jogok();
  
  $where_ksz="";
  if(is_array($tomb_stat_jog_szerv)){
  foreach($tomb_stat_jog_szerv as $ert_sz){
	  if($where_ksz!="")$where_ksz.="or";
	  $where_ksz.="(mira_user.szerv_id='".$ert_sz['szerv_id']."')";
  }
  }
  if($where_ksz!="")$where_ksz="and(".$where_ksz.") ";
  $where.=$where_ksz;
 
}

if($projekt_id!="all"){
 $where.=" and rogzit_sor.projekt_id='".$projekt_id."' ";
}elseif(($tipus!='reszletes3')and($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']!=1)){//Áll esetén ha nem az összesre van joga
 $tomb_stat_jog_proj=keres_user_stat_projekt_jogok();
 
   $where_ksz="";
  if(is_array($tomb_stat_jog_proj)){
  foreach($tomb_stat_jog_proj as $ert_sz){
	  if($where_ksz!="")$where_ksz.="or";
	  $where_ksz.="(rogzit_sor.projekt_id='".$ert_sz['projekt_id']."')";
  }
  }
  if($where_ksz!="")$where_ksz="and(".$where_ksz.") ";
  $where.=$where_ksz;
  
}

//Részletes esetén külön kezelünk mindent!
if(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){

if($ho=="all"){
 $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_ho like '".$ev."-%' ";
}elseif($nap=="all"){
 $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
}else{
  $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";
}
/*
 if($_POST['kiuser']=="csak_lezart"){
	$where.=" and rogzit_ho.ellenorzesre_lezarva='1' ";
 }elseif($_POST['kiuser']=="csak_jovahagyott"){
	$where.=" and rogzit_ho.ellenorzesre_ok='1' ";
 }elseif($_POST['kiuser']=="nem_zart_le"){
	 $where.=" and rogzit_ho.ellenorzesre_lezarva='0' ";
 }elseif($_POST['kiuser']=="jova_nem_hagyott"){
	 $where.=" and rogzit_ho.ellenorzesre_ok='0' ";
 }
*/
}//else

if($_POST['kiuser']=="all"){
//ha rögözített bármit akkor lehet iníktív is,
//vagy ha nem rögzített akkor csak az aktívak
 $where.=" and ( ";
 $where.="(rogzit.rogzit_id is not null) ";
 $where.="or ";
 $where.="(mira_user.user_inaktiv='0' and rogzit.rogzit_id is null) ";
 $where.=" ) ";
}elseif(
($_POST['kiuser']=="csak_rogzitett")or
($_POST['kiuser']=="csak_lezart")or
($_POST['kiuser']=="csak_jovahagyott")

){//Csak rögzített

/*if($nap=="all")
 $where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
else
 $where.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";*/

if($_POST['kiuser']=="csak_rogzitett")
 $where.=" and rogzit.rogzit_id is not null ";

 //(rogzit.rogzit_nap BETWEEN '".$ev."-".$ho."-01' and '".$ev."-".$ho."-31')
 if($_POST['kiuser']=="csak_lezart"){
	$where.=" and rogzit_ho.ellenorzesre_lezarva='1' "; 
 }elseif($_POST['kiuser']=="csak_jovahagyott"){
	$where.=" and rogzit_ho.ellenorzesre_ok='1' "; 
 }
 
}elseif($_POST['kiuser']=="le_nem_zart_user"){
 /*$where.=" and 
 (
 (rogzit_ho.ellenorzesre_lezarva='0')or
 (rogzit_ho.rogzit_ho_id is null)
 )
 ";*/
 //$where.=" and mira_user.user_inaktiv='0' ";
 $where.=" and ( ";
 $where.="(rogzit_ho.rogzit_ho_id is null and mira_user.user_inaktiv='0')or(rogzit_ho.ellenorzesre_lezarva='0')";
 $where.=" )  ";
 /*
 $where.=" and ( ";
 $where.="(rogzit.rogzit_id is not null)and(rogzit_ho.ellenorzesre_lezarva='0')";
 $where.="or ";
 $where.="(mira_user.user_inaktiv='0' and rogzit.rogzit_id is null)";
 $where.=" ) ";
 */
}elseif($_POST['kiuser']=="nem_rogzitett"){
 //$where.=" and rogzit.rogzit_id is null ";	
 $where.=" and mira_user.user_inaktiv='0' and rogzit.rogzit_id is null ";
}elseif($_POST['kiuser']=="nem_zart_le"){
//Csak rögzített de le nem zárt hónappal rendelkező felhasználók
/*$where.="(
 (
 (rogzit.rogzit_id is NULL)
 and
 (mira_user.user_inaktiv='0')
 )
 or
 (";*/
 /*
$where.="(
 (
  (rogzit.rogzit_id is not NULL) and 
  (rogzit_ho.rogzit_ho_id is null)
 )
 or
 (";*/

/*
 if($nap=="all")
  $where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
 else
  $where.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";*/
 
 $where.=" and rogzit.rogzit_id is not NULL and
 (
 (rogzit_ho.ellenorzesre_lezarva='0')or
 (rogzit_ho.rogzit_ho_id is null)
 )
 ";

}elseif($_POST['kiuser']=="jova_nem_hagyott"){
//Jóváhagyással nem rendelkező felhasználók
/*$where.="(
 (
 (rogzit.rogzit_id is NULL)
 and
 (mira_user.user_inaktiv='0')
 )
 or
 (";*/
 
 //$where.="(rogzit.rogzit_ho = '".$ev."-".$ho."')and";
 //$where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
 
 //and rogzit.rogzit_id is not NULL
 $where.=" and
 rogzit_ho.ellenorzesre_lezarva='1' and
 rogzit_ho.ellenorzesre_ok='0' ";
 //)
 //)";
}

//Kezdeti rögzítés lekezelése - eleje
if($ho=="all"){
$where.=' and
(
 (mira_user.user_kezd_date="0000-00-00")or
 (mira_user.user_kezd_date <="'.$ev.'-12-31")
) ';
}else{
$where.=' and
(
 (mira_user.user_kezd_date="0000-00-00")or
 (mira_user.user_kezd_date <="'.$ev.'-'.$ho.'-31")
) ';
}
//Kezdeti rögzítés lekezelése - vége

	 //vége rögzítés lekezelése - eleje
	if($ho=="all"){
	$where.=' and
	(
	 (mira_user.user_veg_date="0000-00-00")or
	 (mira_user.user_veg_date>="'.$ev.'-01-01")
	) ';
	}else{
	$where.=' and
	(
	 (mira_user.user_veg_date="0000-00-00")or
	 (mira_user.user_veg_date>="'.$ev.'-'.$ho.'-01")
	) ';
	}
	//vége rögzítés lekezelése - vége

//where - vége



$sql="SELECT
mira_user.user_ad,";

if( ($excel=="1") and (($tipus=="reszletes2")or($tipus=="reszletes3")or($tipus=="user_napi")))
 $sql.="mira_user.user_email,";

if( ($excel=="1") and (($tipus=="user_napi")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")))
 $sql.="mira_user.user_tsz,";

if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="rogzit.tavollet,";
 
 if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="mira_user.user_nev,";

if(
($tipus=="projekt_szerv")
or($tipus=="szervezet_napi")
or($tipus=="szerv_projekt")
)
 $sql.="mira_szerv.szerv_id,";

if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="projekt_szerv")
or($tipus=="szervezet_napi")or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="mira_szerv.szerv_nev,";

if($tipus=="reszletes3")
 $sql.="rogzit.szerv_id as rogzit_szerv_id ,";

if(
($excel=="1")and
(($tipus=="user_napi")or($tipus=="napi_user")
or($tipus=="szervezet_napi")or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
)
 $sql.="mira_szerv.szerv_koltsegkod,mira_szerv.szerv_adkod,";

if(($tipus=="user_napi")or($tipus=="napi_user")
or($tipus=="szervezet_napi")
or($tipus=="projekt_napi")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="DATE_FORMAT(rogzit.rogzit_nap,'%e') AS rogzit_nap,";
 if($ho=="all")
  $sql.="DATE_FORMAT(rogzit.rogzit_nap,'%m') AS rogzit_ho,";

}

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")
or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="projekt.projekt_nev,rogzit_sor.projekt_id,";

}

 //Projekt max idő lekezelése
 if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
  $sql.="IF
( 
( (projekt.projekt_id_max_all_igen='1') ),projekt.projekt_id_max_all_ora, 
IF( projekt_ido.projekt_id_max_ora is not NULL,projekt_ido.projekt_id_max_ora, '' ) 
) AS projekt_id_max_ora,";
 }

if($tipus=="reszletes2")
 $sql.="projekt.projekt_co ,";

if(($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="
 rogzit.rogzit_update_time,
 rogzit.rogzit_megj,
 rogzit_sor.rogzit_sor_megj,
 rogzit_sor.rogzit_sor_update_time,
 rogzit_ho.ellenorzesre_lezarva,
 rogzit_ho.ellenorzesre_lezarva_mikor,
 
 rogzit_ho.ellenorzesre_lezarva_jovahagyo,
 mira_user_ellenorzesre_lezarva_jovahagyo.user_nev as ellenorzesre_lezarva_jovahagyo_ki_nev,
  
 rogzit_ho.ellenorzesre_visszakuldve,
 mira_user_ellenorzesre_visszakuldve.user_nev as ellenorzesre_visszakuldve_ki_nev,
 rogzit_ho.ellenorzesre_visszakuldve_mikor,
 
 rogzit_ho.ellenorzesre_ok,
 rogzit_ho.ellenorzesre_ok_mikor,
 mira_user_jovahagyo.user_nev as ellenorzesre_ok_ki_nev,
 
 rogzit_sor.helyettes_rogzito,
 mira_user_helyettes_rogzito.user_nev as helyettes_rogzito_ki_nev,
 
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva,
 mira_user_projekt_jovahagyo_elutasitva.user_nev as projekt_jovahagyo_elutasitva_nev,
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva_mikor,
 
 rogzit_ho_projekt.projekt_jovahagyo_jovahagyva,
 mira_user_projekt_jovahagyo_jovahagyva.user_nev as projekt_jovahagyo_jovahagyva_nev,
 rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_mikor,
 
 ";
 
 //Társasági SAP kód
 $sql.=" projekt.projekt_tagv_kod, ";
 //Szervezeti szolgáltatás kód
 $sql.=" mira_szerv.szerv_szolg_kod, ";
 //Tevékenységek szolgáltatás kód
 $sql.=" projekt.projekt_szolg_kod, ";
 $sql.=" mira_szerv.szerv_sm_kod, ";

}

$sql.="rogzit_sor.rogzit_ora,
rogzit_sor.rogzit_perc";



$sql.=" FROM `mira_user`
left join rogzit ON rogzit.user_ad = mira_user.user_ad ";
//Hó vagy nap  lekezelése  - eleje
if($ho=="all"){
   $sql.=" and rogzit.rogzit_ho like '".$ev."-%' ";
}elseif($nap=="all"){
  $sql.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
}else{
  $sql.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";
}
//Hó vagy nap  lekezelése  - vége

$sql.=" left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id ";

if(
(($tipus=="user_napi")or($tipus=="napi_user"))
or($szerv_id!="all")
){
 $sql.="left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id ";
}elseif(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")or($tipus=="projekt_szerv")){
 $sql.="left join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id ";
}elseif(($tipus=="szervezet_napi")or($tipus=="szerv_projekt")){
// $sql.="inner join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id ";
  $sql.="left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id ";  
}

$sql.="left join rogzit_ho ON rogzit_ho.rogzit_ho = rogzit.rogzit_ho and rogzit_ho.user_ad = rogzit.user_ad ";
if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")
or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.=" left join projekt ON projekt.projekt_id = rogzit_sor.projekt_id ";
}

  
 //Projekt max idő lekezelése
 if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
  if($ho=="all")
   $sql.=" left join projekt_ido ON projekt_ido.projekt_id=projekt.projekt_id and projekt_ido.projekt_ho_ido='".$ev."-%' ";  
  else
   $sql.=" left join projekt_ido ON projekt_ido.projekt_id=projekt.projekt_id and projekt_ido.projekt_ho_ido='".$ev."-".$ho."' ";
 }

if(($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.=" left join mira_user as mira_user_jovahagyo ON mira_user_jovahagyo.user_ad = rogzit_ho.ellenorzesre_ok_ki ";
 $sql.=" left join mira_user as mira_user_ellenorzesre_visszakuldve ON mira_user_ellenorzesre_visszakuldve.user_ad = rogzit_ho.ellenorzesre_visszakuldve_ki ";
 $sql.=" left join mira_user as mira_user_ellenorzesre_lezarva_jovahagyo ON mira_user_ellenorzesre_lezarva_jovahagyo.user_ad = rogzit_ho.ellenorzesre_lezarva_jovahagyo_ki ";
 
 $sql.=" left join mira_user as mira_user_helyettes_rogzito ON mira_user_helyettes_rogzito.user_ad = rogzit_sor.helyettes_rogzito_ki ";
 
  $sql.=" left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.user_ad = rogzit.user_ad and
	rogzit_ho_projekt.rogzit_ho = rogzit.rogzit_ho and
	rogzit_ho_projekt.projekt_id = rogzit_sor.projekt_id 
	";
  $sql.=" left join mira_user as mira_user_projekt_jovahagyo_jovahagyva ON mira_user_projekt_jovahagyo_jovahagyva.user_ad = rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_ki ";
  $sql.=" left join mira_user as mira_user_projekt_jovahagyo_elutasitva ON mira_user_projekt_jovahagyo_elutasitva.user_ad = rogzit_ho_projekt.projekt_jovahagyo_elutasitva_ki ";
}
$sql.=" WHERE ".$where;

$sql.=$orderby;
 //DATE_FORMAT(rogzit.rogzit_nap,'%Y.%m.%d') AS rogzit_date ,

 //print $sql."<br>";
 //exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 
 // A `yield` kulcsszóval egyesével adjuk vissza a sorokat.
    while ($row = mysqli_fetch_assoc($adat)) {
        yield $row;
    }

    // Felszabadítja az eredményhalmazt.
    mysqli_free_result($adat);
 return true;
 
 $i_resz=0;
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(($tipus=="user_napi")or($tipus=="napi_user")){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['user_ad']]['user_nev']=$adatom['user_nev'];
  
  if(($tipus=="user_napi")and($excel=="1")){
   $eredmeny_keres['sor'][$adatom['user_ad']]['user_tsz']=$adatom['user_tsz'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['user_email']=$adatom['user_email'];
  }
  $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_nev']=$adatom['szerv_nev'];
  if($excel=="1"){
   $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_adkod']=$adatom['szerv_adkod'];
  }
  
  if(!isset($eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if(($adatom['rogzit_perc']!="")and($adatom['rogzit_perc']<10))$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	//echo $adatom['rogzit_nap']."-".$adatom['user_ad']."-".$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']."<br>";
	$ora=$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }
  
  $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['tavollet']=$adatom['tavollet'];
  
 }elseif($tipus=="szervezet_napi"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_nev']=$adatom['szerv_nev']; 
  if($excel=="1"){
   $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod']; 
   $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_adkod']=$adatom['szerv_adkod']; 
  }
   if(!isset($eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	$ora=$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];
	
	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];


  }
  
 }elseif($tipus=="szerv_projekt"){

  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];

  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_nev']]=$adatom['projekt_id']; 
  //$eredmeny_keres['sor_szerv_nev'][$adatom['szerv_nev']]=$adatom['szerv_id']; 
  $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_nev']=$adatom['szerv_nev']; 
  if($excel=="1"){
   $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod']; 
   $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_adkod']=$adatom['szerv_adkod'];
  }
  
  if(!isset($eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora'])){
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
   $ora=$eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']+$adatom['rogzit_ora'];
   $perc=$eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']+$adatom['rogzit_perc'];
   $tomb_ora=ora_perc_osszead($ora,$perc);
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

   if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }

 }elseif($tipus=="projekt_napi"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];  
  $eredmeny_keres['sor'][$adatom['projekt_id']]['projekt_id_max_ora']=$adatom['projekt_id_max_ora'];  
  
  if(!isset($eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	$ora=$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];
	
	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];


  }

 }elseif($tipus=="projekt_szerv"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  //$eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]=$adatom['projekt_nev']; 
  //$eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]=$adatom['szerv_nev'];
  
  //$eredmeny_keres['sor_projekt_nev'][$adatom['projekt_nev']]=$adatom['projekt_id'];
  
  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];
  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]['projekt_id_max_ora']=$adatom['projekt_id_max_ora'];
  
  $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_nev']]=$adatom['szerv_id']; 
  
  if(!isset($eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora'])){
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
   $ora=$eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']+$adatom['rogzit_ora'];
   $perc=$eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']+$adatom['rogzit_perc'];
   $tomb_ora=ora_perc_osszead($ora,$perc);
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

   if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }
  
 }elseif(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
	 $i_resz++;
	 $eredmeny_keres[$i_resz]['user_ad']=$adatom['user_ad'];
	 $eredmeny_keres[$i_resz]['user_nev']=$adatom['user_nev'];
	 $eredmeny_keres[$i_resz]['user_tsz']=$adatom['user_tsz'];
	 $eredmeny_keres[$i_resz]['szerv_nev']=$adatom['szerv_nev'];
	 $eredmeny_keres[$i_resz]['szerv_koltsegkod']=$adatom['szerv_koltsegkod'];
	 $eredmeny_keres[$i_resz]['szerv_adkod']=$adatom['szerv_adkod'];
	 $eredmeny_keres[$i_resz]['projekt_nev']=$adatom['projekt_nev'];
	 
	 if($ho=="all")
	  $eredmeny_keres[$i_resz]['rogzit_ho']=$adatom['rogzit_ho'];
	 
	 $eredmeny_keres[$i_resz]['rogzit_nap']=$adatom['rogzit_nap'];
	 $eredmeny_keres[$i_resz]['rogzit_ora']=$adatom['rogzit_ora'];
	 $eredmeny_keres[$i_resz]['rogzit_perc']=$adatom['rogzit_perc'];
	 $eredmeny_keres[$i_resz]['tavollet']=$adatom['tavollet'];
	
	if(($tipus=="reszletes2")or($tipus=="reszletes3")){
	 $eredmeny_keres[$i_resz]['projekt_tagv_kod']=$adatom['projekt_tagv_kod'];
	 $eredmeny_keres[$i_resz]['szerv_szolg_kod']=$adatom['szerv_szolg_kod'];
	 $eredmeny_keres[$i_resz]['projekt_szolg_kod']=$adatom['projekt_szolg_kod'];
	 $eredmeny_keres[$i_resz]['szerv_sm_kod']=$adatom['szerv_sm_kod'];
	 
	 $eredmeny_keres[$i_resz]['user_email']=$adatom['user_email'];
   	 $eredmeny_keres[$i_resz]['rogzit_update_time']=$adatom['rogzit_update_time'];
   	 $eredmeny_keres[$i_resz]['rogzit_megj']=$adatom['rogzit_megj'];
   	 $eredmeny_keres[$i_resz]['rogzit_sor_megj']=$adatom['rogzit_sor_megj'];
   	 $eredmeny_keres[$i_resz]['rogzit_sor_update_time']=$adatom['rogzit_sor_update_time'];
   	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva']=$adatom['ellenorzesre_lezarva'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_mikor']=$adatom['ellenorzesre_lezarva_mikor'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_jovahagyo']=$adatom['ellenorzesre_lezarva_jovahagyo'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_jovahagyo_ki_nev']=$adatom['ellenorzesre_lezarva_jovahagyo_ki_nev'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve']=$adatom['ellenorzesre_visszakuldve'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve_ki_nev']=$adatom['ellenorzesre_visszakuldve_ki_nev'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve_mikor']=$adatom['ellenorzesre_visszakuldve_mikor'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok']=$adatom['ellenorzesre_ok'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok_ki_nev']=$adatom['ellenorzesre_ok_ki_nev'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok_mikor']=$adatom['ellenorzesre_ok_mikor'];
	 
	 $eredmeny_keres[$i_resz]['helyettes_rogzito']=$adatom['helyettes_rogzito'];
	 $eredmeny_keres[$i_resz]['helyettes_rogzito_ki_nev']=$adatom['helyettes_rogzito_ki_nev'];
	 
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva']=$adatom['projekt_jovahagyo_elutasitva'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva_nev']=$adatom['projekt_jovahagyo_elutasitva_nev'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva_mikor']=$adatom['projekt_jovahagyo_elutasitva_mikor'];
	 
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva']=$adatom['projekt_jovahagyo_jovahagyva'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva_nev']=$adatom['projekt_jovahagyo_jovahagyva_nev'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva_mikor']=$adatom['projekt_jovahagyo_jovahagyva_mikor'];
    }
	
	if($tipus=="reszletes2"){
	 $eredmeny_keres[$i_resz]['projekt_co']=$adatom['projekt_co'];
	}
	
	if($tipus=="reszletes3"){
		$eredmeny_keres[$i_resz]['szerv_id']=$adatom['rogzit_szerv_id'];
		$eredmeny_keres[$i_resz]['projekt_id']=$adatom['projekt_id'];
	}
 }
  
 }
 //error_log("Peak memory: " . (memory_get_usage()) / 1024 / 1024 . " MB");
 mysqli_free_result($adat);
 //error_log("Peak memory: " . (memory_get_usage()) / 1024 / 1024 . " MB");
 return $eredmeny_keres;
}

?>
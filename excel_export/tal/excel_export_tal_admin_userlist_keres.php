<?php

function excel_export_admin_userlist_keres(){
$_POST['user_userlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

//egyeni_id1
if(
(isset($_POST['egyeni_id1']))and
($_POST['egyeni_id1']!="")
){
 //$tomb_p=explode("&",urldecode($_POST['egyeni_id1']));
 $tomb_p=explode("&",$_POST['egyeni_id1']);
 if(is_array($tomb_p)){
 foreach($tomb_p as $ert){
  $tomb_pegy=explode("=",$ert);
  if(
  (isset($tomb_pegy[0]))and(isset($tomb_pegy[1]))and($tomb_pegy[0]!="")and($tomb_pegy[1]!="")
  ){
	  //$_POST[$tomb_pegy[0]]=$tomb_pegy[1];
	  //$_POST[$tomb_pegy[0]]=urldecode($tomb_pegy[1]);
	  $_POST[urldecode($tomb_pegy[0])]=urldecode($tomb_pegy[1]);
	  
  }
 }
 }
}

$tomb=keres_admin_user_uj();
$tomb_user_projektszam=keres_user_hozzarend_projektszam($tomb);
$tomb_user_jovahagyoszam=keres_user_hozzarend_jovahagyoszam($tomb);
$tomb_user_helyettesszam=keres_user_hozzarend_helyettesszam($tomb);

$i=0;
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>AD</b>";
$adat[$i][]="<b>Email</b>";
$adat[$i][]="<b>Törzsszám</b>";
$adat[$i][]="<b>Szervezet</b>";
$adat[$i][]="<b>Hozzárendelt tevékenységek száma</b>";
$adat[$i][]="<b>Max rögzíthető</b>";
$adat[$i][]="<b>Helyettesek száma</b>";
$adat[$i][]="<b>Szervezet jóváhgyási jogok száma</b>";

$adat[$i][]="<b>Rögzítési jog</b>";
$adat[$i][]="<b>Rögzítés kezdete</b>";
$adat[$i][]="<b>Rögzítés vége</b>";
$adat[$i][]="<b>Jóváhagyó fül</b>";
$adat[$i][]="<b>Statisztika fül</b>";
$adat[$i][]="<b>Riport fül</b>";
$adat[$i][]="<b>Admin</b>";
$adat[$i][]="<b>Rendszer admin</b>";
$adat[$i][]="<b>Inaktív</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['user_email'];
 $adat[$i][]=$ert['user_tsz'];
 $adat[$i][]=$ert['szerv_nev'];
 
 if(isset($tomb_user_projektszam[$ert['user_ad']]))
  $user_projektszam=$tomb_user_projektszam[$ert['user_ad']];
 else $user_projektszam=0;
 $adat[$i][]=$user_projektszam;
 
 //Max rögzíthető óra
 if($ert['user_napi_ido_max_ora']!=0){
  //$adat[$i][]=$ert['user_napi_ido_max_ora'].":00";
  
  if($ert['user_napi_ido_max_perc']<10){
	  $perc='0'.$ert['user_napi_ido_max_perc'];
  }else $perc=$ert['user_napi_ido_max_perc'];
  $adat[$i][]=$ert['user_napi_ido_max_ora'].":".$perc;
 }else{
  $adat[$i][]="";
 }
 
 if(isset($tomb_user_helyettesszam[$ert['user_ad']]))
  $user_helyettesszam=$tomb_user_helyettesszam[$ert['user_ad']];
 else $user_helyettesszam=0;
 $adat[$i][]=$user_helyettesszam;
 
 
 if(isset($tomb_user_jovahagyoszam[$ert['user_ad']]))
  $user_jovahagyoszam=$tomb_user_jovahagyoszam[$ert['user_ad']];
 else $user_jovahagyoszam=0;
 $adat[$i][]=$user_jovahagyoszam;
 
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_rogzit']);
 
 if($ert['user_kezd_date']!='0000-00-00')
  $adat[$i][]=$ert['user_kezd_date'];
 else $adat[$i][]='';
	
 if($ert['user_veg_date']!='0000-00-00')
  $adat[$i][]=$ert['user_veg_date'];
 else $adat[$i][]='';
 
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_jovahagy']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_stat']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_riport']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_admin']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['ful_admin_all']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['user_inaktiv']);
}
}

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Admin jogosultság lista excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Jogosultságok');
unset($adat);
unset($tomb);

//2. munkalap: Admin jogok
$adat_admin=array();
$i=0;
$adat_admin[$i][]="<b>Név</b>";
$adat_admin[$i][]="<b>AD azonosító</b>";
$adat_admin[$i][]="<b>Rendszer Admin jog</b>";
$adat_admin[$i][]="<b>Jogosultság</b>";
$adat_admin[$i][]="<b>Szervezet</b>";
$adat_admin[$i][]="<b>Szervezet csoportosítás</b>";
$adat_admin[$i][]="<b>Tevékenység</b>";
$adat_admin[$i][]="<b>Árazási relevancia mező</b>";
$adat_admin[$i][]="<b>Önköltség kategória</b>";
$adat_admin[$i][]="<b>Szolgáltatás kód</b>";
$adat_admin[$i][]="<b>Munkanap áthelyezés globálisan</b>";
$adat_admin[$i][]="<b>Munkanap áthelyezés felhasználóra</b>";
$adat_admin[$i][]="<b>Hónap végleges lezárása</b>";

$adat_admin[$i][]="<b>Hibajavítás</b>";
$adat_admin[$i][]="<b>Log</b>";
$adat_admin[$i][]="<b>Terv betöltés</b>";
$adat_admin[$i][]="<b>Ténybetöltő - MIRA-n kívüli adatok</b>";

$adat_admin[$i][]="<b>Társasági adatok</b>";
$adat_admin[$i][]="<b>Tulajdonosi joggyakorló lista</b>";
$adat_admin[$i][]="<b>Kapcsolattartó törzsadatok</b>";
$adat_admin[$i][]="<b>Társasági szolgáltatási kapcsolattartók</b>";

$adat_admin[$i][]="<b>Szerződés típus</b>";
$adat_admin[$i][]="<b>Szolgáltatás csoport</b>";
$adat_admin[$i][]="<b>Elszámolás típusa</b>";
$adat_admin[$i][]="<b>Naturália típus</b>";
$adat_admin[$i][]="<b>Szerződés alapadatok</b>";
$adat_admin[$i][]="<b>Szerződés feltöltése</b>";
$adat_admin[$i][]="<b>Társaság kategória</b>";
$adat_admin[$i][]="<b>Szolgáltatáshoz kapcsolódó adatok</b>";
$adat_admin[$i][]="<b>Szolgáltatás módosításhoz kapcsolódó adatok</b>";
//$adat_admin[$i][]="<b>Szolgáltatás megszüntetése</b>";
$adat_admin[$i][]="<b>Integrációs adatok</b>";
$adat_admin[$i][]="<b>Szerződésgazda</b>";
$adat_admin[$i][]="<b>Devizanem és árfolyam</b>";
$adat_admin[$i][]="<b>CO objektum</b>";
$adat_admin[$i][]="<b>SAP szerződésszám</b>";
$adat_admin[$i][]="<b>Vevő azonosító</b>";
$adat_admin[$i][]="<b>Nem szerződés alapján TIG-elendő tételek</b>";
$adat_admin[$i][]="<b>KPI szolgáltatás kód</b>";
$adat_admin[$i][]="<b>KPI típusok</b>";
$adat_admin[$i][]="<b>KPI típus - szerződés összerendelés</b>";

$tomb_admin=excel_keres_admin_jogok();

if(is_array($tomb_admin)){
foreach($tomb_admin as $ert){
 $i++;
 $adat_admin[$i][]="\0".$ert['user_nev'];
 $adat_admin[$i][]="\0".$ert['user_ad'];
 $adat_admin[$i][]="\0".igennem_kod_ki($ert['ful_admin_all']);
 if($ert['ful_admin_all']=="0"){
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_user_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerv_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_csop_nev_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_proj_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_arazasref_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kat_nev_mod']);
	
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szolg_kod_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_munkanapglobal_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_munkanapuser_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_honapzaras_mod']);
	
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_hibajavitas_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_log']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_tervezes_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_tenypotlas_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_tenypotlastig_mod']);
	
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_tagv_kod_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kapcstulaj_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kapcstorzs_mod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kapcsossze_mod']);
	
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szerztipus']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szolgcsop']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_elsztipus']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_nattipus']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tarskat']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szerzalapadat']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szerzfeltolt']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szolgkapadat']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szolgmodadat']);
//	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_szerz_szolgmegszun']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_integadat']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_szerzusergazda']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tigadat_penznem']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tigadat_co']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tigadat_sapszam']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tigadat_vevoazon']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_szerz_tigadat_nemszerz']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kpi_szolgkod']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kpi_tipus']);
	$adat_admin[$i][]="\0".igennem_kod_ki($ert['admin_jog_admin_kpi_osszekap']);
 }
}
}

$xlsx->addSheet($adat_admin,'Admin jogok');
unset($adat_admin);
unset($tomb_admin);

//3. munkalap: Riport jogok
$adat_riport=array();
$i=0;
$adat_riport[$i][]="<b>Név</b>";
$adat_riport[$i][]="<b>AD azonosító</b>";
$adat_riport[$i][]="<b>Teljes riport jog</b>";
$adat_riport[$i][]="<b>Riport jog</b>";

$tomb_riport=excel_keres_riport_jogok();
if(is_array($tomb_riport)){
foreach($tomb_riport as $ert){
 $i++;
 $adat_riport[$i][]="\0".$ert['user_nev'];
 $adat_riport[$i][]="\0".$ert['user_ad_fo'];
 $adat_riport[$i][]="\0".igennem_kod_ki($ert['ful_riport_all']);
 if($ert['ful_riport_all']=="0"){
	 	$adat_riport[$i][]="\0".riport_nev_ki($ert['riport_tipus']);
 }
}
}

$xlsx->addSheet($adat_riport,'Riport jogok');
unset($adat_riport);
unset($tomb_riport);

//4 munkalap: Statisztika teljes jogok
$adat_stat_ful=array();
$i=0;
$adat_stat_ful[$i][]="<b>Név</b>";
$adat_stat_ful[$i][]="<b>AD azonosító</b>";
$adat_stat_ful[$i][]="<b>Teljes statisztika jog</b>";
$tomb_stat_ful=excel_keres_statisztika_jogok();

if(is_array($tomb_stat_ful)){
foreach($tomb_stat_ful as $ert){
 $i++;
 $adat_stat_ful[$i][]="\0".$ert['user_nev'];
 $adat_stat_ful[$i][]="\0".$ert['user_ad'];
 $adat_stat_ful[$i][]="\0".igennem_kod_ki('1');
}
}

$xlsx->addSheet($adat_stat_ful,'Statisztika teljes jogok');
unset($adat_stat_ful);
unset($tomb_stat_ful);


//5 munkalap: Statisztika szervezet jogok
$adat_stat_szerv=array();
$i=0;
$adat_stat_szerv[$i][]="<b>Név</b>";
$adat_stat_szerv[$i][]="<b>AD azonosító</b>";
$adat_stat_szerv[$i][]="<b>Szervezet jog</b>";
$tomb_stat_szerv=excel_keres_statisztika_szervezet_jogok();

if(is_array($tomb_stat_szerv)){
foreach($tomb_stat_szerv as $ert){
 $i++;
 $adat_stat_szerv[$i][]="\0".$ert['user_nev'];
 $adat_stat_szerv[$i][]="\0".$ert['user_ad'];
 $adat_stat_szerv[$i][]="\0".$ert['szerv_nev'];
}
}

$xlsx->addSheet($adat_stat_szerv,'Statisztika szervezet jogok');
unset($adat_stat_szerv);
unset($tomb_stat_szerv);

//6 munkalap: Statisztika tevékenységek jogok
$adat_stat_proj=array();
$i=0;
$adat_stat_proj[$i][]="<b>Név</b>";
$adat_stat_proj[$i][]="<b>AD azonosító</b>";
$adat_stat_proj[$i][]="<b>Tevékenység jog</b>";
$tomb_stat_proj=excel_keres_statisztika_proj_jogok();

if(is_array($tomb_stat_proj)){
foreach($tomb_stat_proj as $ert){
 $i++;
 $adat_stat_proj[$i][]="\0".$ert['user_nev'];
 $adat_stat_proj[$i][]="\0".$ert['user_ad'];
 $adat_stat_proj[$i][]="\0".$ert['projekt_nev'];
}
}

$xlsx->addSheet($adat_stat_proj,'Statisztika tevékenység jogok');
unset($adat_stat_proj);
unset($tomb_stat_proj);

//Letöltés
if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
 exit;
}

}

function riport_nev_ki($riport_tipus){
$ret=$riport_tipus;

switch($riport_tipus){
 case'nonp':$ret="Nonproduktív riport";break;
 case'tervteny':$ret="Terv-tény";break;
 case'teny3_1_1_szervcsop':$ret="Felhasználónkénti tevékenység összesítés - 3.1.1 Szervezet csoportosítás";break;
 case'teny3_1_1':$ret="Felhasználónkénti tevékenység összesítés - 3.1.1";break;
 case'teny3_2':$ret="Szervezetenkénti tevékenység összesítés - 3.2";break;
 case'teny3_3':$ret="Tevékenység összesítés - 3.2";break;
 case'teny3':$ret="Aktuális tevékenység kód - Társaság kód összesítés - 3";break;
 case'kapcs_ossze':$ret="Tény-terv eltérés - 3";break;
 case'teny3_elteres':$ret="Kapcsolattartó adatok";break;
 case'szerznyilv':$ret="Szerződésnyilvántartó - teljes";break;
 case'szerznyilv_elo':$ret="Szerződésnyilvántartó - élő szerződések";break;
 case'proj_k99':$ret="KK99 tevékenységek";break;
 case'proj_beszkoz':$ret="Beszerzési és közbeszerzési tevékenységek";break;
 case'kpi_riport':$ret="KPI riport";break;
 case'admin_user':$ret="Jogosultság";break;
 case'admin_szerv':$ret="Szervezet";break;
 case'admin_proj':$ret="Tevékenység";break;
 case'tig_tabla':$ret="TIG tábla";break;
}
return $ret;
}

function excel_keres_statisztika_proj_jogok(){
$eredmeny_keres='';
$sql='SELECT 
mira_user.user_ad,
mira_user.user_nev,
projekt.projekt_nev 
FROM `mira_user`
inner join mira_user_stat_proj ON mira_user_stat_proj.user_ad = mira_user.user_ad
left join projekt ON projekt.projekt_id = mira_user_stat_proj.projekt_id
where 
mira_user.ful_stat="1" and
mira_user.ful_stat_all="1" and
mira_user.ful_stat_projekt_all="0" and 
mira_user.user_inaktiv="0"
order by mira_user.user_nev asc, projekt.projekt_nev asc';
//echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function excel_keres_statisztika_szervezet_jogok(){
$eredmeny_keres='';
$sql='SELECT 
mira_user.user_ad,
mira_user.user_nev,
mira_szerv.szerv_nev
FROM `mira_user`
inner join mira_user_stat ON mira_user_stat.user_ad = mira_user.user_ad
left join mira_szerv ON mira_szerv.szerv_id = mira_user_stat.szerv_id
where 
mira_user.ful_stat="1" and
mira_user.ful_stat_all="0" and
mira_user.ful_stat_projekt_all="1" and 
mira_user.user_inaktiv="0"
order by mira_user.user_nev asc, mira_szerv.szerv_nev asc';
//echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function excel_keres_statisztika_jogok(){
$eredmeny_keres='';
$sql='SELECT 
mira_user.user_ad,
mira_user.user_nev
FROM `mira_user`
where 
mira_user.ful_stat="1" and
mira_user.ful_stat_all="1" and
mira_user.ful_stat_projekt_all="1" and
mira_user.user_inaktiv="0"
order by mira_user.user_nev asc';
//echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function excel_keres_riport_jogok(){
$eredmeny_keres='';
$sql='SELECT 
mira_user.user_ad as user_ad_fo,
mira_user.user_nev,
mira_user.ful_riport_all,
mira_user_riport.*
FROM `mira_user`
left join mira_user_riport ON mira_user_riport.user_ad = mira_user.user_ad
where 
mira_user.ful_riport="1" and
mira_user.user_inaktiv="0"
order by mira_user.user_nev asc, mira_user_riport.riport_tipus asc';
//echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function excel_keres_admin_jogok(){
$eredmeny_keres='';
$sql='SELECT 
mira_user.user_ad,
mira_user.user_nev,
mira_user.ful_admin_all,
mira_user_admin_jog.*
FROM `mira_user`
left join mira_user_admin_jog ON mira_user_admin_jog.admin_jog_user_ad = mira_user.user_ad
where 
mira_user.ful_admin="1" and
mira_user.user_inaktiv="0"
order by mira_user.user_nev asc';
//echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
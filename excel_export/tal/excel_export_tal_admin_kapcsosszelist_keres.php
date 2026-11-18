<?php

function excel_export_admin_kapcsosszelist_keres(){
$_POST['admin_kapcsosszelist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcsossze_uj_excel();
$tomb2=keres_admin_kapcsossze_uj_excel_csakmvms();

/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
exit;
*/

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Társaság SAP kód</b>";
$adat[$i][]="<b>Társaság neve</b>";
$adat[$i][]="<b>Szolgáltatás kód</b>";
$adat[$i][]="<b>Szolgáltatás neve</b>";

$adat[$i][]="<b>Kapcsolattartó típusa</b>";
$adat[$i][]="<b>Kapcsolattartó neve</b>";
//$adat[$i][]="<b>Kapcsolattartó általános ügyekben</b>";
//$adat[$i][]="<b>Kapcsolattartó szolgáltatás specifikus ügyekben</b>";

//$adat[$i][]="<b>MVMS kapcsolattartó szolgáltatás specifikus ügyekben</b>";
//$adat[$i][]="<b>MVMS kapcsolattartó SLA/KPIn</b>";

if(is_array($tomb)){

$tomb_tagvkod_nev=keres_tagvkod_nev_tomb();
$tomb_szolgkod_nev=keres_szolgkod_nev_tomb();
$tomb_nev=keres_tagv_kapcsolattartok_nev_all();

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;

 $adat[$i][]=$ert['kapcs_ossze_id'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$tomb_tagvkod_nev[$ert['tagv_kod']];
 $adat[$i][]=$ert['szolg_kod'];
 $adat[$i][]=$tomb_szolgkod_nev[$ert['szolg_kod']];
 
 //Kapcsolattartó típusa
 if($ert['kapcs_ossze_kapcs_tipus']=='kapcs1')
  $adat[$i][]='általános ügyekben';
 else $adat[$i][]="szolgáltatás specifikus ügyekben";

 //Kapcsolattartó neve
 if($ert['kapcs_torzs_nev']!='')
  $adat[$i][]=$ert['kapcs_torzs_nev'];
 else $adat[$i][]="";
 
 //MVMS kapcsolattartó szolgáltatás specifikus ügyekben
 /*if($ert['kapcs_ossze_kapcs_torzs_id_mvms']!='')
  $adat[$i][]=$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['tagv_kod'].')';
 else $adat[$i][]='';*/

 //MVMS kapcsolattartó SLA
 /*if($ert['kapcs_ossze_kapcs_torzs_id_sla']!='')
  $adat[$i][]=$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['tagv_kod'].')';
 else $adat[$i][]='';
 */
}
}
}

$date=date("Y_m_d-H_i_s",time());
$filename="Társasági szolgáltatási kapcsolattartó összerendelés excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,$GLOBALS['rend_nev'].' kapcsolattartók export');
unset($adat);

$i=0;
$adat2[$i][]="<b>ID</b>";
$adat2[$i][]="<b>Társaság SAP kód</b>";
$adat2[$i][]="<b>Társaság neve</b>";
$adat2[$i][]="<b>Szolgáltatás kód</b>";
$adat2[$i][]="<b>Szolgáltatás neve</b>";

$adat2[$i][]="<b>MVMS kapcsolattartó szolgáltatás specifikus ügyekben</b>";
$adat2[$i][]="<b>MVMS kapcsolattartó SLA/KPIn</b>";

if(is_array($tomb2)){
foreach($tomb2 as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;

 $adat2[$i][]=$ert['kapcs_ossze_id'];
 $adat2[$i][]=$ert['tagv_kod'];
 $adat2[$i][]=$tomb_tagvkod_nev[$ert['tagv_kod']];
 $adat2[$i][]=$ert['szolg_kod'];
 $adat2[$i][]=$tomb_szolgkod_nev[$ert['szolg_kod']];

 //MVMS kapcsolattartó szolgáltatás specifikus ügyekben
 if($ert['kapcs_ossze_kapcs_torzs_id_mvms']!='')
  $adat2[$i][]=$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['tagv_kod'].')';
 else $adat2[$i][]='';

 //MVMS kapcsolattartó SLA
 if($ert['kapcs_ossze_kapcs_torzs_id_sla']!='')
  $adat2[$i][]=$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['tagv_kod'].')';
 else $adat2[$i][]='';
 
}
}
}

$xlsx->addSheet($adat2,$GLOBALS['rend_nev'].' MVM kapcsolattartók export');
unset($adat2);
$xlsx->downloadAs(rawurlencode($filename));

}


function keres_admin_kapcsossze_uj_excel_csakmvms(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_kapcsosszelist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod');
$sql_order.=', kapcs_ossze.szolg_kod asc ';
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']."'";
 }
 
   
  $join="
  left join kapcs_torzs as kapcs_torzs_mvms ON kapcs_torzs_mvms.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms 
  left join kapcs_torzs as kapcs_torzs_sla ON kapcs_torzs_sla.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla  
  left join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
  left join kapcs_torzs as kapcs_torzs_kapcs ON kapcs_torzs_kapcs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id
  ";
  
 //$join="";
 $group="group by kapcs_ossze.kapcs_ossze_id";
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="(";
  $where.="(kapcs_torzs_mvms.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_sla.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')";
  $where.=")";

  //$group=' group by kapcs_ossze.kapcs_ossze_id';
 }

 $sql1="";
 
 if($group!=''){
  $sql1.="SELECT COUNT(*) as tal FROM (";
  $sql1.="SELECT kapcs_ossze.kapcs_ossze_id ";
 }else{
  $sql1.="SELECT count(kapcs_ossze.kapcs_ossze_id) as tal ";
 }
 
 $sql1.="FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql1.=" where ".$where;
 
 $sql1.=$group;
 if($group!=''){
  $sql1.=") t";
 }
 
 $sql="SELECT kapcs_ossze.*

 
 ,kapcs_torzs_mvms.kapcs_torzs_nev as kapcs_torzs_nev_mvms
,kapcs_torzs_sla.kapcs_torzs_nev as kapcs_torzs_nev_sla


 FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql.=" where ".$where;
 $sql.=$group;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
  //$eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['tagv_kod']][$adatom['szolg_kod']]''[$adatom['kapcs_ossze_kapcs_tipus']]=$adatom['kapcs_torzs_nev'];//$adatom['']
  //$eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['tagv_kod']][$adatom['szolg_kod']]''[$adatom['kapcs_ossze_kapcs_tipus']]=$adatom['kapcs_torzs_nev'];//$adatom['']
 }
 return $eredmeny_keres;
}

function keres_admin_kapcsossze_uj_excel(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_kapcsosszelist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod');
$sql_order.=', kapcs_ossze.szolg_kod asc ';
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']."'";
 }
 
   
  $join="
  left join kapcs_torzs as kapcs_torzs_mvms ON kapcs_torzs_mvms.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms 
  left join kapcs_torzs as kapcs_torzs_sla ON kapcs_torzs_sla.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla  
  left join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
  left join kapcs_torzs as kapcs_torzs_kapcs ON kapcs_torzs_kapcs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id
  ";
  
 //$join="";
 $group="";
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="(";
  $where.="(kapcs_torzs_mvms.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_sla.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')";
  $where.=")";

  //$group=' group by kapcs_ossze.kapcs_ossze_id';
 }

 $sql1="";
 
 if($group!=''){
  $sql1.="SELECT COUNT(*) as tal FROM (";
  $sql1.="SELECT kapcs_ossze.kapcs_ossze_id ";
 }else{
  $sql1.="SELECT count(kapcs_ossze.kapcs_ossze_id) as tal ";
 }
 
 $sql1.="FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql1.=" where ".$where;
 
 $sql1.=$group;
 if($group!=''){
  $sql1.=") t";
 }
 
 $sql="SELECT kapcs_ossze.*

 
 ,kapcs_torzs_mvms.kapcs_torzs_nev as kapcs_torzs_nev_mvms
,kapcs_torzs_sla.kapcs_torzs_nev as kapcs_torzs_nev_sla
,kapcs_ossze_kapcs.kapcs_ossze_kapcs_tipus
,kapcs_torzs_kapcs.kapcs_torzs_nev

 FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql.=" where ".$where;
 $sql.=$group;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
  //$eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['tagv_kod']][$adatom['szolg_kod']]''[$adatom['kapcs_ossze_kapcs_tipus']]=$adatom['kapcs_torzs_nev'];//$adatom['']
  //$eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['tagv_kod']][$adatom['szolg_kod']]''[$adatom['kapcs_ossze_kapcs_tipus']]=$adatom['kapcs_torzs_nev'];//$adatom['']
 }
 return $eredmeny_keres;
}

?>
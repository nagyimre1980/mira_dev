<?php

function riport_teny33(){
$tomb=keres_riport_teny33($_POST['date1_ev'],$_POST['date1_ho']);
$tomb_tagv=keress_riport_teny33_tagvkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
//$tomb_szolgkod=keress_riport_teny32_szolgkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
$tomb_szolgkod=keress_riport_teny33_szolgkod_nev_eles();
mysqli_close($GLOBALS['mysqli']);

$i=0;
$adat[$i][]='<b>'."Hó".'</b>';

$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Tásaság kód".'</b>';
$adat[$i][]='<b>'."Tásaság neve".'</b>';

$adat[$i][]='<b>'."Tevékenység kód".'</b>';//Aktuálisra átállítás - kész

$adat[$i][]='<b>'."Árazási szempontból releváns".'</b>';

$adat[$i][]='<b>'."CO objektum".'</b>';//Aktuálisra átállítás - kész ez volt

$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';


foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['backup_ver_ho'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];

  if(isset($tomb_tagv[$ert['projekt_tagv_kod']]))
  $adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];//tagv_kod_nev
 else
  $adat[$i][]='';
 
  $adat[$i][]=$ert['projekt_szolg_kod'];//Tevékenység kód
  
 //Árazási szempontból releváns
 $adat[$i][]=igennem_kod_ki_0nalis($ert['projekt_arazasref']);

 $adat[$i][]=$ert['projekt_co'];
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
//$filename='Teny3_2 '.$date.'.xlsx';
$filename='Teny3_3_'.$_POST['date1_ev'].'evi_'.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.3 export');
unset($adat);
$xlsx->autoFilter('A1:J1');
$xlsx->downloadAs(rawurlencode($filename));
}

function igennem_kod_ki_0nalis($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'':$ret="";break;
	case'0':$ret="Nem";break;
	case'1':$ret="Igen";break;
}
return $ret;
}

function keress_riport_teny33_szolgkod_nev_eles(){
$eredmeny_keres='';

$sql="SELECT 
mira_szolg_kod.szolg_kod,
mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
return $eredmeny_keres;
}

function keress_riport_teny33_tagvkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny33_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_tagv_kod.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
	 exit;
 }
 
$sql="SELECT 
backup_tagv_kod.tagv_kod,
backup_tagv_kod.tagv_kod_nev
FROM `backup_tagv_kod`

".$where;
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
return $eredmeny_keres;
}

function keres_riport_teny33($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny33_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_adat_".$ev."_teny_3_3.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
	 exit;
 }

//backup_pojekt.projekt_szolg_kod,
//backup_szerv.szerv_szolg_kod,
//backup_szerv.szerv_sm_kod,

/*
left join projekt_szerv ON projekt_szerv.projekt_id = backup_pojekt.projekt_id
	and projekt_szerv.szerv_id =  backup_szerv.szerv_id
left join projekt_kat as projekt_kat_szerv ON projekt_kat_szerv.projekt_kat_id = projekt_szerv.projekt_kat_id_kivetel
*/

/* kivettek 3.2 képest
backup_szerv.szerv_nev,
backup_szerv.szerv_adkod,
mira_szerv.szerv_szolg_kod,
mira_szerv.szerv_sm_kod,
mira_szerv_csoport.mira_szerv_csoport_nev,
projekt_kat.projekt_kat_nev,
projekt_kat.projekt_kat_nev_h,

projekt_kat_szerv.projekt_kat_nev as projekt_kat_szerv_nev,
projekt_kat_szerv.projekt_kat_nev_h as projekt_kat_szerv_nev_h
*/
$sql="SELECT 

backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,

backup_adat_".$ev."_teny_3_3.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_3.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_3.rogzitett_teny3_perc,
backup_ver.backup_ver_ho,
projekt.projekt_co,

projekt.projekt_szolg_kod,
projekt.projekt_arazasref

FROM `backup_adat_".$ev."_teny_3_3` 

left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_3.backup_pojekt_id
left join backup_ver ON backup_ver.backup_ver_id = backup_adat_".$ev."_teny_3_3.backup_ver_id 

left join projekt ON projekt.projekt_id = backup_pojekt.projekt_id

".$where."
order by backup_ver.backup_ver_ho asc,backup_pojekt.projekt_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny33_excelhez($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_3 = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_id'];
 }
 return $eredmeny_keres;
}
?>
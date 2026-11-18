<?php

function riport_teny3(){

$tomb=keres_riport_teny3($_POST['date1_ev'],$_POST['date1_ho']);
$tomb_tagv=keress_riport_teny3_tagvkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
$tomb_szolgkod=keress_riport_teny3_szolgkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
mysqli_close($GLOBALS['mysqli']);
$i=0;
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Tásaság kód".'</b>';
$adat[$i][]='<b>'."Tásaság neve".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Szolgáltatás név".'</b>';

$adat[$i][]='<b>'."Összesen egész óra".'</b>';


foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['backup_ver_ho'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 //Tásaság neve - eleje
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']])){
	$adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];
 }else{
	 $adat[$i][]="";
 }
 //Tásaság neve - vége
  
 $adat[$i][]=$ert['projekt_szolg_kod'];
 
  //Szolgáltatás név - eleje
  if(isset($tomb_szolgkod[$ert['projekt_szolg_kod']])){
	$adat[$i][]=$tomb_szolgkod[$ert['projekt_szolg_kod']];
 }else{
	 $adat[$i][]="";
 }
 //Szolgáltatás név - vége
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 //$adat[$i][]=$ert['rogzitett_teny3_ora'];
 //$adat[$i][]=$ert['rogzitett_teny3_perc'];
 //$adat[$i][]=$ert['projekt_tervkod'];
 
 //Tervadat
 //$adat[$i][]=$ert['backup_terv_osszeg'];
 
 //Problémás - vége
 
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
//$filename='Teny3 '.$date.'.xlsx';
$filename='Teny3_'.$_POST['date1_ev'].'evi_'.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3 export');
unset($adat);
//$xlsx->autoFilter('A1:E1');
$xlsx->downloadAs(rawurlencode($filename));
}

function keres_riport_teny3($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';


if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny3_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_adat_".$ev."_teny_3.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }

$sql="SELECT 

backup_adat_".$ev."_teny_3.projekt_tervkod,
backup_adat_".$ev."_teny_3.projekt_tagv_kod,
backup_adat_".$ev."_teny_3.projekt_szolg_kod,
backup_adat_".$ev."_teny_3.rogzitett_teny3_ora_egesz,
backup_ver.backup_ver_ho

FROM `backup_adat_".$ev."_teny_3` 
left join backup_ver ON backup_ver.backup_ver_id = backup_adat_".$ev."_teny_3.backup_ver_id 

".$where."
order by backup_adat_".$ev."_teny_3.projekt_tagv_kod asc";

//and backup_terv.backup_terv_tipus ='terv' 

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}


function keress_riport_teny3_szolgkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny3_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_szolg_kod.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }
 
$sql="SELECT 
backup_szolg_kod.szolg_kod,
backup_szolg_kod.szolg_kod_nev
FROM `backup_szolg_kod`
".$where;
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
return $eredmeny_keres;
}

function keress_riport_teny3_tagvkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny3_excelhez($ev);
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


function keress_riport_ful_ki_evho_teny3_excelhez($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3 = '1' 
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
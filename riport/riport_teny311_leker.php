<?php

function riport_teny311(){

//print_r($_POST);
//Array ( [tipus] => teny3_1_1 [date1_ev] => 2024 [date1_ho] => all )

if(!isset($_POST['szervcsop_id']))$_POST['szervcsop_id']='';

$tomb=keres_riport_teny311($_POST['date1_ev'],$_POST['date1_ho'],$_POST['szervcsop_id']);

$tomb_tagv=keress_riport_teny311_tagvkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
//$tomb_szolgkod=keress_riport_teny311_szolgkod_nev($_POST['date1_ev'],$_POST['date1_ho']);
$tomb_szolgkod=keress_riport_teny311_szolgkod_nev_eles();
mysqli_close($GLOBALS['mysqli']);

$i=0;
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Felhasználó neve".'</b>';
$adat[$i][]='<b>'."Szervezet neve".'</b>';
$adat[$i][]='<b>'."Költséghely".'</b>';
$adat[$i][]='<b>'."Kategória".'</b>';
$adat[$i][]='<b>'."Törzsszám".'</b>';
$adat[$i][]='<b>'."AD azonosító".'</b>';
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Társaság kód".'</b>';
$adat[$i][]='<b>'."Társaság neve".'</b>';

$adat[$i][]='<b>'."Tevékenység kód".'</b>';//Aktuálisra átállítás - kész
$adat[$i][]='<b>'."Szervezet Tevékenység kód".'</b>';//Aktuálisra átállítás - kész
$adat[$i][]='<b>'."Aktuális tevékenység kód".'</b>';//Aktuálisra átállítás - kész
$adat[$i][]='<b>'."Aktuális tevékenység kód neve".'</b>';//Aktuálisra átállítás - kész

$adat[$i][]='<b>'."Önköltség kategória kód".'</b>';
$adat[$i][]='<b>'."Önköltség kategória név".'</b>';
$adat[$i][]='<b>'."Árazási szempontból releváns".'</b>';

$adat[$i][]='<b>'."SAP SM kód".'</b>';//Aktuálisra átállítás - kész
$adat[$i][]='<b>'."CO objektum".'</b>';//Aktuálisra átállítás - kész ez volt

$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

//$adat[$i][]='<b>'."Egyedi ár".'</b>';
//$adat[$i][]='<b>'."Önköltség kategória név".'</b>';

foreach($tomb as $is => $ert){
 $i++;
 $adat[$i][]=$ert['backup_ver_ho'];
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['szerv_adkod'];//Költséghely
 $adat[$i][]=$ert['mira_szerv_csoport_nev'];//Kategória
 $adat[$i][]=$ert['user_tsz'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['projekt_nev'];//Tevékenység neve
 $adat[$i][]=$ert['projekt_tagv_kod'];//Társaság kód
 
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']]))
  $adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];//tagv_kod_nev
 else
  $adat[$i][]='';

 $adat[$i][]=$ert['projekt_szolg_kod'];//Tevékenység kód
 $adat[$i][]=$ert['szerv_szolg_kod'];//Szervezet Tevékenység kód
 
 //Aktuális tevékenység kód és neve
 if($ert['projekt_szolg_kod']==''){
	 $adat[$i][]=$ert['szerv_szolg_kod'];
	 
	 if(isset($tomb_szolgkod[$ert['szerv_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['szerv_szolg_kod']];
	 else
	  $adat[$i][]='';
  
 }else{
	 $adat[$i][]=$ert['projekt_szolg_kod'];
	  
	 if(isset($tomb_szolgkod[$ert['projekt_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['projekt_szolg_kod']];
	 else
	  $adat[$i][]='';
 }
 
 //Önköltség kategória kód
 if($ert['projekt_kat_user_nev']!=''){
	 $adat[$i][]=$ert['projekt_kat_user_nev'];
	 $adat[$i][]=$ert['projekt_kat_user_nev_h'];
 }elseif($ert['projekt_kat_szerv_nev']!=''){
	 $adat[$i][]=$ert['projekt_kat_szerv_nev'];
	 $adat[$i][]=$ert['projekt_kat_szerv_nev_h'];
 }else{
	 $adat[$i][]=$ert['projekt_kat_nev'];
	 $adat[$i][]=$ert['projekt_kat_nev_h'];
 }
 
 //Árazási szempontból releváns
 $adat[$i][]=igennem_kod_ki_0nalis($ert['projekt_arazasref']);
 
 //SAP SM kód
 $adat[$i][]=$ert['szerv_sm_kod'];
 $adat[$i][]=$ert['projekt_co'];
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];

/*
 if(
 ($ert['szerz_egyediar_projekt_id_1']==$ert['projekt_id'])or
 ($ert['szerz_egyediar_projekt_id_2']==$ert['projekt_id'])or
 ($ert['szerz_egyediar_projekt_id_3']==$ert['projekt_id'])or
 (
  ($ert['szerz_egyediar_projekt_id_1']=='')and
  ($ert['szerz_egyediar_projekt_id_2']=='')and
  ($ert['szerz_egyediar_projekt_id_3']=='')
 )
 ){
  $adat[$i][]=igennem_kod_ki($ert['szerz_egyediar_egyedi_ar']);
  $adat[$i][]=igennem_kod_ki($ert['szerz_egyediar_kozzszolgaltatas']);
 }else{
	 $adat[$i][]='';
	 $adat[$i][]='';
 }
 */

//unset($tomb[$is]);
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
//$filename='Teny3_1_1 '.$date.'.xlsx';
$filename='Teny3_1_1_'.$_POST['date1_ev'].'evi_'.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.1.1 export');
unset($adat);
$xlsx->autoFilter('A1:V1');
$xlsx->downloadAs(rawurlencode($filename));
}

function igennem_kod_ki($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'':$ret="";break;
	case'0':$ret="";break;
	case'1':$ret="Igen";break;
}
return $ret;
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

function keress_riport_teny311_szolgkod_nev_eles(){
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

function keress_riport_teny311_tagvkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez($ev);
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

function keress_riport_ful_ki_evho_teny3_1_1_szervcsop_k(){
$eredmeny_keres="";
 $sql="SELECT 
 mira_szerv_csoport.mira_szerv_csoport_id
 FROM `mira_user_riport_311_szervcsop`
 inner join mira_szerv_csoport ON mira_szerv_csoport.mira_szerv_csoport_id = mira_user_riport_311_szervcsop.mira_szerv_csoport_id
 where 
 mira_user_riport_311_szervcsop.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['mira_szerv_csoport_id'];
 }
 return $eredmeny_keres;
}

function keres_riport_teny311($ev,$ho,$szervcsop_id){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_adat_".$ev."_teny_3_1_1.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }

if($szervcsop_id=='all'){
 $tomb_szerv_csop_jogok=keress_riport_ful_ki_evho_teny3_1_1_szervcsop_k();
 if(is_array($tomb_szerv_csop_jogok)){
  $where_t='';
  foreach($tomb_szerv_csop_jogok as $mira_szerv_csoport_id){
	if($where_t!='')$where_t.='or';
	$where_t.='(mira_szerv_csoport.mira_szerv_csoport_id="'.$mira_szerv_csoport_id.'")';
  }
  if($where_t!='')$where.=' and('.$where_t.')';
 }
}elseif($szervcsop_id!=''){
 $where.=' and mira_szerv_csoport.mira_szerv_csoport_id="'.$szervcsop_id.'"';
}

$sql="SELECT 
backup_user.user_nev,
backup_user.user_tsz,
backup_user.user_ad,
backup_szerv.szerv_nev,
backup_szerv.szerv_adkod,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_perc,
backup_pojekt.projekt_id,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,

projekt.projekt_co,

backup_ver.backup_ver_ho,

mira_szerv_csoport.mira_szerv_csoport_nev,
projekt.projekt_szolg_kod,
projekt.projekt_arazasref,
mira_szerv.szerv_szolg_kod,
mira_szerv.szerv_sm_kod,

projekt_kat.projekt_kat_nev,
projekt_kat.projekt_kat_nev_h,
projekt_kat_szerv.projekt_kat_nev as projekt_kat_szerv_nev,
projekt_kat_szerv.projekt_kat_nev_h as projekt_kat_szerv_nev_h,

projekt_kat_user.projekt_kat_nev as projekt_kat_user_nev,
projekt_kat_user.projekt_kat_nev_h as projekt_kat_user_nev_h



FROM `backup_adat_".$ev."_teny_3_1_1` 
left join backup_user ON backup_user.backup_user_id = backup_adat_".$ev."_teny_3_1_1.backup_user_id
left join backup_szerv ON backup_szerv.backup_szerv_id  = backup_adat_".$ev."_teny_3_1_1.backup_szerv_id 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_1_1.backup_pojekt_id
left join backup_ver ON backup_ver.backup_ver_id = backup_adat_".$ev."_teny_3_1_1.backup_ver_id 

left join projekt ON projekt.projekt_id = backup_pojekt.projekt_id

left join mira_szerv ON mira_szerv.szerv_id = backup_szerv.szerv_id
left join mira_szerv_csoport ON mira_szerv_csoport.mira_szerv_csoport_id = mira_szerv.szerv_csoport_id

left join projekt_kat ON projekt_kat.projekt_kat_id = projekt.projekt_kat_id


left join projekt_szerv_katkivetel ON projekt_szerv_katkivetel.projekt_id = backup_pojekt.projekt_id
	and projekt_szerv_katkivetel.szerv_id =  backup_szerv.szerv_id
left join projekt_kat as projekt_kat_szerv ON projekt_kat_szerv.projekt_kat_id = projekt_szerv_katkivetel.projekt_kat_id_kivetel

left join projekt_user_katkivetel ON projekt_user_katkivetel.user_ad = backup_user.user_ad 
	and projekt_user_katkivetel.projekt_id = projekt.projekt_id
left join projekt_kat as projekt_kat_user ON projekt_kat_user.projekt_kat_id = projekt_user_katkivetel.projekt_user_kat_id_kivetel 


	
".$where."
order by backup_ver.backup_ver_ho asc,backup_user.user_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;

}

function keress_riport_ful_ki_evho_teny311_excelhez($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1 = '1' 
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
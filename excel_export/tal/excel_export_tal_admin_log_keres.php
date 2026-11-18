<?php

function excel_export_admin_loglist_keres(){
$_POST['admin_loglist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$i=0;
$adat=array();
$adat[$i][]='<b>ID</b>';
$adat[$i][]='<b>Típus</b>';
$adat[$i][]='<b>Tábla</b>';
$adat[$i][]='<b>Hol</b>';
$adat[$i][]='<b>Előzmény</b>';
$adat[$i][]='<b>Adat</b>';
$adat[$i][]='<b>Ki</b>';
$adat[$i][]='<b>Mikor</b>';

$tomb=keres_admin_log_uj();


if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 
 $adat[$i][]="\0".$ert['log_id'];
 $adat[$i][]="\0".admin_loglist_tipus_tipus_nevki($ert['log_mod']);
 $adat[$i][]="\0".$ert['log_muvelet'];

 $hol='';
 $vanh=false;
 if($ert['log_hol']!=''){
  $vanh=true;
  $hol.=$ert['log_hol'];
  $hol.=' - ';
  $hol.=$ert['log_ertek'];
 }
 

 if($ert['log_hol2']!=''){
 if($vanh) $hol.=', ';
  $hol.=$ert['log_hol2'];
  $hol.=' - ';
  $hol.=$ert['log_ertek2'];
 }
 
 if($ert['log_hol3']!=''){
 if($vanh) $hol.=', ';
  $hol.=$ert['log_hol3'];
  $hol.=' - ';
  $hol.=$ert['log_ertek3'];
 }
 $adat[$i][]=$hol;
 //HOL - vége
 
 $adat[$i][]="\0".$ert['log_adat_elozmeny'];
 $adat[$i][]="\0".$ert['log_adat'];
 $adat[$i][]="\0".$ert['user_nev'];
 $adat[$i][]="\0".kidate_format($ert['ment_log_mikor']);
 
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin log excel export '.$date.'.xlsx';

//Letöltés
if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 //$xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
 (string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 (string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
}

}

function admin_loglist_tipus_tipus_nevki($tipus){
switch($tipus){
 case'bevitel':
  $ret='Bevitel';
 break;
 case'mod':
  $ret='Módosítás';
 break;
 case'del':
  $ret='Törlés';
 break;
 default:
  $ret='';
 break;
}
return $ret;
}

?>
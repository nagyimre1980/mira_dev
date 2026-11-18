<?php

function excel_export_admin_integadatlist_keres(){
$_POST['admin_integadatlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_integadat_uj();

$i=0;
$adat[$i][]="<b>Szolgátatás ID</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Keretszerződés</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szerződés hatályba lépésének időpontja</b>";
$adat[$i][]="<b>SAP szerződésszám</b>";
$adat[$i][]="<b>Hatályos szerződésmódosítás száma</b>";
$adat[$i][]="<b>Aktuális szerződésmódosítás</b>";
$adat[$i][]="<b>Szolgáltatás csoport</b>";
$adat[$i][]="<b>Szolgáltatás kód</b>";
$adat[$i][]="<b>Integrációs többlet FTE</b>";
$adat[$i][]="<b>Integrációs naturália többlet havonta</b>";
$adat[$i][]="<b>Megjegyzéls</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_tetel_id'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_keret']);
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szerz_date_hatalybelep'];

 $adat[$i][]=$ert['szerz_sapszam'];
  
 $adat[$i][]=$ert['szerz_tetel_modszam'];
 
 if(($ert['szerz_tetel_akt']=='1')and($ert['szerz_tetel_akt_folyamatban']=='0')){
  $adat[$i][]='Aktuális';
 }elseif($ert['szerz_tetel_akt_folyamatban']=='1'){
  $adat[$i][]='Folyamatban';
 }else $adat[$i][]='';
 
 $adat[$i][]=$ert['szerz_csop_nev'];
 $adat[$i][]=$ert['szolg_kod'];
 
 $adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_integ_tobblet']);
 $adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_integ_tobblet_ho']);
 $adat[$i][]=$ert['szerz_tetel_integ_megj'];
 
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin integrációs adatok excel export '.$date.'.xlsx';
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Adatok');
unset($adat);

//Letöltés
$xlsx->downloadAs(rawurlencode($filename));

}

?>
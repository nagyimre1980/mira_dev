<?php

function excel_export_admin_tigadatnemszerzlist_keres(){
$_POST['admin_tigadatnemszerzlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatnemszerz_uj();
$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Év-Hó</b>";
$adat[$i][]="<b>Hó</b>";
$adat[$i][]="<b>Megrendelő</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szolgáltatás</b>";
$adat[$i][]="<b>Szerződés</b>";
$adat[$i][]="<b>Elszámolás módja</b>";
$adat[$i][]="<b>Szerződéses összeg EUR-ban</b>";
$adat[$i][]="<b>Havi összeg forintban</b>";
$adat[$i][]="<b>Havi összeg forintban 1. módosítás</b>";
$adat[$i][]="<b>Havi összeg forintban 2. módosítás</b>";
$adat[$i][]="<b>Devizanem</b>";
$adat[$i][]="<b>CO objektum</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['id'];
 $adat[$i][]="\0".$ert['evho'];
 $adat[$i][]=$ert['tagv_kod'].' - '.$ert['tagv_kod_nev'];
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];
 $adat[$i][]=szerz_tigadatnemszerz_szerzodes_ki($ert['szerz_tig_nemszerz_szerzodes']);
 $adat[$i][]=$ert['szerz_elsz_tipus_nev'];
 $adat[$i][]=$ert['szerzosszeg'];
 $adat[$i][]=$ert['haviosszeg'];
 $adat[$i][]=$ert['haviosszeg_mod1'];
 $adat[$i][]=$ert['haviosszeg_mod2'];
 $adat[$i][]=$ert['penznem'];
 $adat[$i][]=$ert['co'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin Új nem szerződés alapján TIG-elendő tétel excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

function szerz_tigadatnemszerz_szerzodes_ki($a){
switch($a){
 case'van':$ret='Van';break;
 case'nincs':$ret='Nincs';break;
 case'megszunt':$ret='Megszünt';break;
 default:$ret=$a;break;
}
return $ret;
}
?>
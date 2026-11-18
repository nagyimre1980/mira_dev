<?php

function excel_export_admin_kapcstorzslist_keres(){
$_POST['admin_kapcstorzslist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcstorzs_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>Társaság SAP kód</b>";
$adat[$i][]="<b>Társaság neve</b>";
$adat[$i][]="<b>Beosztás</b>";
$adat[$i][]="<b>Telefonszám</b>";
$adat[$i][]="<b>Email</b>";
$adat[$i][]="<b>Inaktiv</b>";

if(is_array($tomb)){

$tomb_tagvkod_nev=keres_tagvkod_nev_tomb();

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;

 $adat[$i][]=$ert['kapcs_torzs_id'];
 $adat[$i][]=$ert['kapcs_torzs_nev'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$tomb_tagvkod_nev[$ert['tagv_kod']];
 $adat[$i][]=$ert['kapcs_torzs_beosztas'];
 $adat[$i][]=$ert['kapcs_torzs_tel'];
 $adat[$i][]=$ert['kapcs_torzs_email'];
 $adat[$i][]=igennem_kod_ki($ert['kapcs_torzs_inaktiv']);
 
 
 
}
}
}

$date=date("Y_m_d-H_i_s",time());
$filename="Kapcsolattartó törzsadatok excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>
<?php

function excel_export_admin_szolgcsoplist_keres(){
$_POST['admin_szolgcsoplist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szolgcsop_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Szolgáltatás csoport név</b>";
$adat[$i][]="<b>Szolgáltatás kódok</b>";
$adat[$i][]="<b>KPI Szolgáltatás kód</b>";
$adat[$i][]="<b>Közszolgáltatói KPI szolgáltatás kód</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_csop_id'];
 $adat[$i][]=$ert['szerz_csop_nev'];
 $adat[$i][]=$ert['szolg_kod_szam'];
 $adat[$i][]=$ert['kpi_szolg_kod'];
 $adat[$i][]=$ert['kpi_szolg_kod_kozszolg'];
}
}

unset($tomb);
$date=date("Y_m_d-H_i_s",time());
$filename='Admin szolgátlatás csooortok excel export '.$date.'.xlsx';
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Adatok');
unset($adat);

$tomb2=keres_excel_csop_szolg_kod();

$i=0;
$adat2[$i][]="<b>ID</b>";
$adat2[$i][]="<b>Szolgáltatás csoport név</b>";
$adat2[$i][]="<b>Szolgáltatás kod</b>";
$adat2[$i][]="<b>Szolgáltatás neve</b>";
foreach($tomb2 as $ert){
 $i++;
 $adat2[$i][]=$ert['szerz_csop_id'];
 $adat2[$i][]=$ert['szerz_csop_nev'];
 $adat2[$i][]=$ert['szolg_kod'];
 $adat2[$i][]=$ert['szolg_kod_nev'];
}

$xlsx->addSheet($adat2,'Szolgáltatás kódok');
unset($adat2);
//Letöltés
$xlsx->downloadAs(rawurlencode($filename));

}

function keres_excel_csop_szolg_kod(){
 $eredmeny_keres="";
 $sql="SELECT mira_szolg_kod.szolg_kod_nev
 ,szerz_csop_szolgkod.szolg_kod
 ,szerz_csop_szolgkod.szerz_csop_id
 ,szerz_csop.szerz_csop_nev
 FROM `szerz_csop_szolgkod` 
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_csop_szolgkod.szerz_csop_id
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_csop_szolgkod.szolg_kod
 order by szerz_csop_szolgkod.szerz_csop_id asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;	
}
?>
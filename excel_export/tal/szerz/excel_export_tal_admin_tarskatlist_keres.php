<?php

function excel_export_admin_tarskatlist_keres(){
$_POST['admin_tarskatlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tarskat_uj();

$i=0;
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Társasági kategória</b>";
$adat[$i][]="<b>Hatályos eleje</b>";
$adat[$i][]="<b>Hatályos vége</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tagvkat_date_kezd']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tagvkat_date_veg']);
}
}

unset($tomb);
$date=date("Y_m_d-H_i_s",time());
$filename='Admin társaság kategória excel export '.$date.'.xlsx';
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Adatok');
unset($adat);

$tomb2=keres_admin_tarskat_uj_full();
$i=0;
$adat2[$i][]="<b>Társaság</b>";
$adat2[$i][]="<b>Társasági kategória</b>";
$adat2[$i][]="<b>Hatályos eleje</b>";
$adat2[$i][]="<b>Hatályos vége</b>";

foreach($tomb2 as $isor => $ert){
 $i++;
 $adat2[$i][]=$ert['tagv_kod'];
 $adat2[$i][]=kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
 $adat2[$i][]=kidate_format_ev($ert['szerz_tagvkat_date_kezd']);
 $adat2[$i][]=kidate_format_ev($ert['szerz_tagvkat_date_veg']);
}

unset($tomb2);
$xlsx->addSheet($adat2,'Adatok teljes');
unset($adat2);

//Letöltés
$xlsx->downloadAs(rawurlencode($filename));
}

function keres_admin_tarskat_uj_full(){
$eredmeny_keres="";
 $sql="SELECT mira_tagv_kod.tagv_kod
 ,mira_tagv_kod.tagv_kod_nev
 ,szerz_tagvkat.szerz_tagvkat_kat
 ,szerz_tagvkat.szerz_tagvkat_date_kezd
 ,szerz_tagvkat.szerz_tagvkat_date_veg
 FROM `mira_tagv_kod` 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = mira_tagv_kod.tagv_kod 
 order by mira_tagv_kod.tagv_kod ASC, szerz_tagvkat.szerz_tagvkat_id ASC
 ";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
?>
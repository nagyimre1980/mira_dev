<?php

function riport_kpi_riport(){

$tomb=keres_riport_kpi_riport();

$i=0;
$style='<style bgcolor="#FFE699">';
$adat[$i][]=$style."<center><b>BUKRS</b></center></style>";
$adat[$i][]=$style."<center><b>Név</b></center></style>";
$adat[$i][]=$style."<center><b>SZKOD</b></center></style>";
$adat[$i][]=$style."<center><b>KPI</b></center></style>";
$adat[$i][]=$style."<center><b>Kategória</b></center></style>";
$adat[$i][]=$style."<center><b>Mutatószám megnevezése</b></center></style>";
$adat[$i][]=$style."<center><b>Mutatószám számítás módja</b></center></style>";
$adat[$i][]=$style."<center><b>Célérték</b></center></style>";
$adat[$i][]=$style."<center><b>Szankció mértéke*</b></center></style>";
$adat[$i][]=$style."<center><b>KPI tip</b></center></style>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
 $i++;
 
if($i % 2 === 0){//páros szám
 $style='<style bgcolor="#FFFFFF">';
}else{//páratlan szám
 $style='<style bgcolor="#D9E1F2">';
}
 
 $adat[$i][]=$style.$ert['tagv_kod']."</style>";
 $adat[$i][]=$style.$ert['tagv_kod_nev']."</style>";
 $adat[$i][]=$style.$ert['kpi_szolg_kod']."</style>";
 
 $adat[$i][]=$style.$ert['kpi_tipus_kpi']."</style>";
 $adat[$i][]=$style.$ert['szerz_tagvkat_kat']."</style>";
 $adat[$i][]=$style.$ert['kpi_tipus_mutmegn']."</style>";
 $adat[$i][]=$style.$ert['kpi_tipus_mutszmod']."</style>";
 
 if($ert['kpi_tipus_ck']!='')
  $adat[$i][]=$style.$ert['kpi_tipus_ck'].'</style>%';
 else $adat[$i][]=$style.'</style>';
 
 if($ert['kpi_tipus_szm']!='')
  $adat[$i][]=$style.$ert['kpi_tipus_szm'].'</style>%';
 else $adat[$i][]=$style.'</style>';
 
 $adat[$i][]=$style.$ert['kpi_tipus_tipus']."</style>";
  
}
}

/*
echo 'alma<pre>';
print_r($tomb);
echo '</pre>';
exit;
*/

$date=date("Y_m_d-H_i_s",time());
$filename="KPI riport excel export ".$date.".xlsx";

if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
	(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')
	->setColWidth(1,11)//BUKS
	->setColWidth(3,11)//SZKOD
	->setColWidth(5,14)//Kategória
	->setColWidth(6,28)//Mutatószám megnevezése
	->setColWidth(7,29)//Mutatószám számítás módja
	->setColWidth(8,13)//Célérték
	->setColWidth(9,20)//Szankció mértéke*
	->setColWidth(10,10)//KPI tip
	->autoFilter('A1:J1')->saveAs($GLOBALS['excel_auto_mappa'].$filename);

}else{
	(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')
	->setColWidth(1,11)//BUKS
	->setColWidth(3,11)//SZKOD
	->setColWidth(5,14)//Kategória
	->setColWidth(6,28)//Mutatószám megnevezése
	->setColWidth(7,29)//Mutatószám számítás módja
	->setColWidth(8,13)//Célérték
	->setColWidth(9,20)//Szankció mértéke*
	->setColWidth(10,10)//KPI tip
	->autoFilter('A1:J1')->downloadAs(rawurlencode($filename));
}
}

function keres_riport_kpi_riport(){

$eredmeny_keres='';
//inner join szerz_tetel ON szerz_tetel.szerz_tetel_id = szerz_tetel_adat.szerz_tetel_id 

/*
$sql="SELECT szerz.tagv_kod
,mira_tagv_kod.tagv_kod_nev
,szerz_tetel_adat.szolg_kod
,kpi_tipus.kpi_szolg_kod
,kpi_tipus.kpi_tipus_kpi
,IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) AS szerz_tagvkat_kat
,kpi_tipus.kpi_tipus_mutmegn
,kpi_tipus.kpi_tipus_mutszmod

,CASE
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 1 THEN kpi_tipus.kpi_tipus_ck_1
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 2 THEN kpi_tipus.kpi_tipus_ck_2
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 3 THEN kpi_tipus.kpi_tipus_ck_3
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 4 THEN kpi_tipus.kpi_tipus_ck_4
        ELSE NULL
    END AS kpi_tipus_ck

,kpi_tipus.kpi_tipus_szm
,kpi_tipus.kpi_tipus_tipus
FROM `kpi_osszekapcs`
left join kpi_tipus ON kpi_tipus.kpi_tipus_id = kpi_osszekapcs.kpi_tipus_id
inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_adat_id = kpi_osszekapcs.szerz_tetel_adat_id 
	and szerz_tetel_adat.szerz_tetel_akt='1' 
inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
left join mira_tagv_kod on mira_tagv_kod.tagv_kod = szerz.tagv_kod 
left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod 
	and szerz_tagvkat.szerz_tagvkat_akt='1' 
order by szerz.tagv_kod asc, szerz_tetel_adat.szolg_kod asc, kpi_tipus.kpi_tipus_kpi asc 
";
*/

$sql="SELECT szerz.tagv_kod
,mira_tagv_kod.tagv_kod_nev
,szerz_tetel_adat.szolg_kod
,kpi_tipus.kpi_szolg_kod
,kpi_tipus.kpi_tipus_kpi
,IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) AS szerz_tagvkat_kat
,kpi_tipus.kpi_tipus_mutmegn
,kpi_tipus.kpi_tipus_mutszmod

,CASE
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 1 THEN kpi_tipus.kpi_tipus_ck_1
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 2 THEN kpi_tipus.kpi_tipus_ck_2
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 3 THEN kpi_tipus.kpi_tipus_ck_3
        WHEN IF(szerz_tagvkat.szerz_tagvkat_kat = 0, 4, szerz_tagvkat.szerz_tagvkat_kat) = 4 THEN kpi_tipus.kpi_tipus_ck_4
        ELSE NULL
    END AS kpi_tipus_ck

,kpi_tipus.kpi_tipus_szm
,kpi_tipus.kpi_tipus_tipus
FROM `szerz_kpi_osszekapcs`

left join kpi_tipus ON kpi_tipus.kpi_tipus_id = szerz_kpi_osszekapcs.kpi_tipus_id
inner join szerz_kpi ON szerz_kpi.szerz_kpi_id = szerz_kpi_osszekapcs.szerz_kpi_id
inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_id = szerz_kpi.szerz_id
	and szerz_tetel_adat.szerz_csop_id = szerz_kpi.szerz_csop_id
	and szerz_tetel_adat.szerz_tetel_modszam_kezi = szerz_kpi.szerz_tetel_modszam_kezi
	and szerz_tetel_adat.szerz_tetel_akt='1'
inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
left join mira_tagv_kod on mira_tagv_kod.tagv_kod = szerz.tagv_kod 
left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod 
	and szerz_tagvkat.szerz_tagvkat_akt='1' 
GROUP BY szerz.tagv_kod, kpi_tipus.kpi_tipus_kpi
order by szerz.tagv_kod asc, szerz_tetel_adat.szolg_kod asc, kpi_tipus.kpi_tipus_kpi asc 
";
 //echo $sql."<br>";//exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
?>
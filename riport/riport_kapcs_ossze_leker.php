<?php

function riport_kapcs_ossze(){

$i=0;
$adat[$i][]='<b>'."Társaság".'</b>';
$adat[$i][]='<b>'."Inaktív".'</b>';
$adat[$i][]='<b>'."Tulajdonosi joggyakorló".'</b>';
$adat[$i][]='<b>'."Adószám".'</b>';
$adat[$i][]='<b>'."Cím".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó szerepe".'</b>';
$adat[$i][]='<b>'."Szolgáltatás".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó neve".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó 1. számú munkáltatója".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó beosztása".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó telefonszáma".'</b>';
$adat[$i][]='<b>'."Kapcsolattartó emailcíme".'</b>';

$tomb=keres_riport_kapcs_ossze();//Társaság cuccai, ami általános
$tomb2=keres_riport_kapcs_ossze2();//Társasáág nevezetői
$tomb3=keres_riport_kapcs_ossze3();//MVMS-es dolgok

/*
echo '<pre>';
print_r($tomb2);
echo '</pre>';
exit;
*/

if((isset($tomb))and(is_array($tomb))){
 foreach($tomb as $tagv_kod => $ert){
  
  if((isset($ert['adat']['vezeto_1']))and(is_array($ert['adat']['vezeto_1']))){
	$i++;
	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='1. számú vezető';
	$adat[$i][]='Általános';
	$adat[$i][]=$ert['adat']['vezeto_1']['nev'];
	$adat[$i][]=$ert['adat']['vezeto_1']['tagv_kod'].' - '.$ert['adat']['vezeto_1']['tagv_kod_nev'];;
	$adat[$i][]=$ert['adat']['vezeto_1']['beosztas'];
	$adat[$i][]=$ert['adat']['vezeto_1']['tel'];
	$adat[$i][]=$ert['adat']['vezeto_1']['email'];
  }

  if((isset($ert['adat']['vezeto_1_t']))and(is_array($ert['adat']['vezeto_1_t']))){
	$i++;
	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='1. számú vezető';
	$adat[$i][]='Általános';
	$adat[$i][]=$ert['adat']['vezeto_1_t']['nev'];
	$adat[$i][]=$ert['adat']['vezeto_1_t']['tagv_kod'].' - '.$ert['adat']['vezeto_1_t']['tagv_kod_nev'];
	$adat[$i][]=$ert['adat']['vezeto_1_t']['beosztas'];
	$adat[$i][]=$ert['adat']['vezeto_1_t']['tel'];
	$adat[$i][]=$ert['adat']['vezeto_1_t']['email'];
  }

  if((isset($ert['adat']['vezeto_2']))and(is_array($ert['adat']['vezeto_2']))){
	$i++;
	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='2. számú vezető/gazdasági vezető';
	$adat[$i][]='Általános';
	$adat[$i][]=$ert['adat']['vezeto_2']['nev'];
	$adat[$i][]=$ert['adat']['vezeto_2']['tagv_kod'].' - '.$ert['adat']['vezeto_2']['tagv_kod_nev'];;
	$adat[$i][]=$ert['adat']['vezeto_2']['beosztas'];
	$adat[$i][]=$ert['adat']['vezeto_2']['tel'];
	$adat[$i][]=$ert['adat']['vezeto_2']['email'];
  }

  if((isset($ert['adat']['kapcstarto']))and(is_array($ert['adat']['kapcstarto']))){
	$i++;
	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='Kapcsolattartó (gazdasági ügyekben)';
	$adat[$i][]='Általános';
	$adat[$i][]=$ert['adat']['kapcstarto']['nev'];
	$adat[$i][]=$ert['adat']['kapcstarto']['tagv_kod'].' - '.$ert['adat']['kapcstarto']['tagv_kod_nev'];
	$adat[$i][]=$ert['adat']['kapcstarto']['beosztas'];
	$adat[$i][]=$ert['adat']['kapcstarto']['tel'];
	$adat[$i][]=$ert['adat']['kapcstarto']['email'];
  } 

if((isset($tomb2[$tagv_kod]))and(is_array($tomb2[$tagv_kod]))){
 foreach($tomb2[$tagv_kod] as $szolg_kod => $ert2){
	foreach($ert2 as $ert2_1){
	 $i++;
  	 $adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	 $adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	 $adat[$i][]=$ert['kapcs_tulaj_nev'];
	 $adat[$i][]=$ert['adoszam'];
	 $adat[$i][]=$ert['cim'];
	 
	 if($ert2_1['tipus']=='kapcs1'){
	  $adat[$i][]='Kapcsolattartó általános ügyekben';
	 }else{
	  $adat[$i][]='Kapcsolattartó szolgáltatás specifikus ügyekben';
	 }
	 
	 $adat[$i][]=$szolg_kod.' - '.$ert2_1['szolg_kod_nev'];
	 
	 $adat[$i][]=$ert2_1['nev'];
	 $adat[$i][]=$ert2_1['tagv_kod_torzs'].' - '.$ert2_1['tagv_kod_torzs_nev'];
	 $adat[$i][]=$ert2_1['beosztas'];
	 $adat[$i][]=$ert2_1['tel'];
	 $adat[$i][]=$ert2_1['email'];
	}
	
 }
}

if((isset($tomb3[$tagv_kod]))and(is_array($tomb3[$tagv_kod]))){
 foreach($tomb3[$tagv_kod] as $szolg_kod => $ert3){
   
   if((isset($ert3['mvms']))and($ert3['mvms'])){
	$i++;
  	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='MVMS kapcsolattartó szolgáltatás specifikus ügyekben';
	$adat[$i][]=$szolg_kod.' - '.$ert3['mvms']['szolg_kod_nev'];
	$adat[$i][]=$ert3['mvms']['nev'];
	$adat[$i][]=$ert3['mvms']['tagv_kod'].' - '.$ert3['mvms']['tagv_kod_nev'];
	$adat[$i][]=$ert3['mvms']['beosztas'];
	$adat[$i][]=$ert3['mvms']['tel'];
	$adat[$i][]=$ert3['mvms']['email'];
   }

   if((isset($ert3['sla']))and($ert3['sla'])){
	$i++;
  	$adat[$i][]=$tagv_kod.' - '.$ert['tagv_kod_nev'];
	$adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
	$adat[$i][]=$ert['kapcs_tulaj_nev'];
	$adat[$i][]=$ert['adoszam'];
	$adat[$i][]=$ert['cim'];
	
	$adat[$i][]='MVMS kapcsolattartó SLA/KPI';

	$adat[$i][]=$szolg_kod.' - '.$ert3['sla']['szolg_kod_nev'];
	
		
	$adat[$i][]=$ert3['sla']['nev'];
	$adat[$i][]=$ert3['sla']['tagv_kod'].' - '.$ert3['sla']['tagv_kod_nev'];
	$adat[$i][]=$ert3['sla']['beosztas'];
	$adat[$i][]=$ert3['sla']['tel'];
	$adat[$i][]=$ert3['sla']['email'];
   }   
 }
}

 }
}

$date=date("Y_m_d-H_i_s",time());
$filename='Kapcsolattartó adatok '.$date.'.xlsx';
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,'Kapcsolattartó adatok export')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Kapcsolattartó adatok export');
//$xlsx->addSheet($adat,'Kapcsolattartó adatok export');
$xlsx->autoFilter('A1:K1');
//$alphabet = range('A','Z');
//$xlsx->autoFilter('A1:'.$alphabet[(sizeof($adat[$i])-1)].'1');
//$xlsx->addSheet($adat,'export');//Kapcsolattartó adatok export

if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
}

}

function keres_riport_kapcs_ossze3(){
$eredmeny_keres='';

$sql="SELECT 
mira_tagv_kod.tagv_kod,
mira_tagv_kod.tagv_kod_inaktiv,
kapcs_ossze.szolg_kod,
mira_szolg_kod.szolg_kod_nev,

kapcs_torzs_mvms.kapcs_torzs_nev as kapcs_torzs_nev_mvms,
kapcs_torzs_mvms.tagv_kod as tagv_kod_mvms,
kapcs_torzs_mvms.kapcs_torzs_beosztas as kapcs_torzs_beosztas_mvms,
kapcs_torzs_mvms.kapcs_torzs_tel as kapcs_torzs_tel_mvms,
kapcs_torzs_mvms.kapcs_torzs_email as kapcs_torzs_email_mvms,

kapcs_torzs_sla.kapcs_torzs_nev as kapcs_torzs_nev_sla,
kapcs_torzs_sla.tagv_kod as tagv_kod_sla,
kapcs_torzs_sla.kapcs_torzs_beosztas as kapcs_torzs_beosztas_sla,
kapcs_torzs_sla.kapcs_torzs_tel as kapcs_torzs_tel_sla,
kapcs_torzs_sla.kapcs_torzs_email as kapcs_torzs_email_sla,

kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms,
kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla,

mira_tagv_kod_mvms.tagv_kod_nev as tagv_kod_nev_mvms,
mira_tagv_kod_sla.tagv_kod_nev as tagv_kod_nev_sla

FROM `mira_tagv_kod`
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod
left join kapcs_torzs as kapcs_torzs_mvms ON kapcs_torzs_mvms.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms
left join kapcs_torzs as kapcs_torzs_sla ON kapcs_torzs_sla.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla
left join mira_tagv_kod as mira_tagv_kod_mvms ON mira_tagv_kod_mvms.tagv_kod = kapcs_torzs_mvms.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_sla ON mira_tagv_kod_sla.tagv_kod = kapcs_torzs_sla.tagv_kod
";

//echo $sql.'<br><br>';exit;

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){  
  
  if($adatom['kapcs_ossze_kapcs_torzs_id_mvms']!=''){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   $i++;
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['szolg_kod_nev']=$adatom['szolg_kod_nev'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['nev']=$adatom['kapcs_torzs_nev_mvms'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tagv_kod']=$adatom['tagv_kod_mvms'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tagv_kod_nev']=$adatom['tagv_kod_nev_mvms'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['beosztas']=$adatom['kapcs_torzs_beosztas_mvms'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tel']=$adatom['kapcs_torzs_tel_mvms'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['email']=$adatom['kapcs_torzs_email_mvms'];
  }
  
  if($adatom['kapcs_ossze_kapcs_torzs_id_sla']!=''){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   $i++;
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['szolg_kod_nev']=$adatom['szolg_kod_nev'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['nev']=$adatom['kapcs_torzs_nev_sla'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tagv_kod']=$adatom['tagv_kod_sla'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tagv_kod_nev']=$adatom['tagv_kod_nev_sla'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['beosztas']=$adatom['kapcs_torzs_beosztas_sla'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tel']=$adatom['kapcs_torzs_tel_sla'];
   $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['email']=$adatom['kapcs_torzs_email_sla'];
  }
  
 }
/*
echo '<pre>';
print_r($eredmeny_keres['EGDG']['SLSI']);
echo '</pre>';
exit;
*/
return $eredmeny_keres;
}

function keres_riport_kapcs_ossze2(){
$eredmeny_keres='';

$sql="SELECT 
mira_tagv_kod.tagv_kod,
kapcs_ossze.szolg_kod,
mira_szolg_kod.szolg_kod_nev,

kapcs_ossze_kapcs.kapcs_ossze_kapcs_tipus,

kapcs_torzs.kapcs_torzs_nev,
kapcs_torzs.tagv_kod as tagv_kod_torzs,
kapcs_torzs.kapcs_torzs_beosztas,
kapcs_torzs.kapcs_torzs_tel,
kapcs_torzs.kapcs_torzs_email,

mira_tagv_kod_ossze.tagv_kod_nev as tagv_kod_torzs_nev

FROM `mira_tagv_kod`
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod
inner join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
left join kapcs_torzs ON kapcs_torzs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id 

left join mira_tagv_kod as mira_tagv_kod_ossze ON mira_tagv_kod_ossze.tagv_kod = kapcs_torzs.tagv_kod

order by mira_tagv_kod.tagv_kod asc,kapcs_ossze.szolg_kod asc, kapcs_torzs.kapcs_torzs_nev asc 

";

//echo $sql.'<br><br>';exit;

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  //$eredmeny_keres[$adatom['tagv_kod']][$i]['szolg_kod']=$adatom['szolg_kod'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['szolg_kod']=$adatom['szolg_kod'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['szolg_kod_nev']=$adatom['szolg_kod_nev'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tipus']=$adatom['kapcs_ossze_kapcs_tipus'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['nev']=$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tagv_kod_torzs']=$adatom['tagv_kod_torzs'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tagv_kod_torzs_nev']=$adatom['tagv_kod_torzs_nev'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['beosztas']=$adatom['kapcs_torzs_beosztas'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tel']=$adatom['kapcs_torzs_tel'];
  $eredmeny_keres[$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['email']=$adatom['kapcs_torzs_email'];
 }
return $eredmeny_keres;
}

function keres_riport_kapcs_ossze(){
$eredmeny_keres='';

$sql="SELECT 
mira_tagv_kod.tagv_kod,
mira_tagv_kod.tagv_kod_inaktiv,
mira_tagv_kod.tagv_kod_nev,
mira_tagv_kod.tagv_kod_adoszam,
mira_tagv_kod.tagv_kod_cim,
mira_tagv_kod.kapcs_tulaj_kod,
kapcs_tulaj.kapcs_tulaj_nev,

kapcs_torzs_vezeto_1.kapcs_torzs_nev as kapcs_torzs_vezeto_1_nev,
kapcs_torzs_vezeto_1.tagv_kod as kapcs_torzs_vezeto_1_tagv_kod,
kapcs_torzs_vezeto_1.kapcs_torzs_beosztas as kapcs_torzs_vezeto_1_beosztas,
kapcs_torzs_vezeto_1.kapcs_torzs_tel as kapcs_torzs_vezeto_1_tel,
kapcs_torzs_vezeto_1.kapcs_torzs_email as kapcs_torzs_vezeto_1_email,

kapcs_torzs_vezeto_1_t.kapcs_torzs_nev as kapcs_torzs_vezeto_1_t_nev,
kapcs_torzs_vezeto_1_t.tagv_kod as kapcs_torzs_vezeto_1_t_tagv_kod,
kapcs_torzs_vezeto_1_t.kapcs_torzs_beosztas as kapcs_torzs_vezeto_1_t_beosztas,
kapcs_torzs_vezeto_1_t.kapcs_torzs_tel as kapcs_torzs_vezeto_1_t_tel,
kapcs_torzs_vezeto_1_t.kapcs_torzs_email as kapcs_torzs_vezeto_1_t_email,

kapcs_torzs_vezeto_2.kapcs_torzs_nev as kapcs_torzs_vezeto_2_nev,
kapcs_torzs_vezeto_2.tagv_kod as kapcs_torzs_vezeto_2_tagv_kod,
kapcs_torzs_vezeto_2.kapcs_torzs_beosztas as kapcs_torzs_vezeto_2_beosztas,
kapcs_torzs_vezeto_2.kapcs_torzs_tel as kapcs_torzs_vezeto_2_tel,
kapcs_torzs_vezeto_2.kapcs_torzs_email as kapcs_torzs_vezeto_2_email,

kapcs_torzs_kapcstarto.kapcs_torzs_nev as kapcs_torzs_kapcstarto_nev,
kapcs_torzs_kapcstarto.tagv_kod as kapcs_torzs_kapcstarto_tagv_kod,
kapcs_torzs_kapcstarto.kapcs_torzs_beosztas as kapcs_torzs_kapcstarto_beosztas,
kapcs_torzs_kapcstarto.kapcs_torzs_tel as kapcs_torzs_kapcstarto_tel,
kapcs_torzs_kapcstarto.kapcs_torzs_email as kapcs_torzs_kapcstarto_email,

mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto,

mira_tagv_kod_vezeto_1.tagv_kod_nev as tagv_kod_nev_vezeto_1,
mira_tagv_kod_vezeto_1_t.tagv_kod_nev as tagv_kod_nev_vezeto_1_t,
mira_tagv_kod_vezeto_2.tagv_kod_nev as tagv_kod_nev_vezeto_2,
mira_tagv_kod_kapcstarto.tagv_kod_nev as tagv_kod_nev_kapcstarto

FROM `mira_tagv_kod`

left join kapcs_tulaj ON kapcs_tulaj.kapcs_tulaj_kod = mira_tagv_kod.kapcs_tulaj_kod

left join kapcs_torzs as kapcs_torzs_vezeto_1 ON kapcs_torzs_vezeto_1.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1
left join kapcs_torzs as kapcs_torzs_vezeto_1_t ON kapcs_torzs_vezeto_1_t.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t
left join kapcs_torzs as kapcs_torzs_vezeto_2 ON kapcs_torzs_vezeto_2.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2
left join kapcs_torzs as kapcs_torzs_kapcstarto ON kapcs_torzs_kapcstarto.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto

left join mira_tagv_kod as mira_tagv_kod_vezeto_1 ON mira_tagv_kod_vezeto_1.tagv_kod = kapcs_torzs_vezeto_1.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_vezeto_1_t ON mira_tagv_kod_vezeto_1_t.tagv_kod = kapcs_torzs_vezeto_1_t.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_vezeto_2 ON mira_tagv_kod_vezeto_2.tagv_kod = kapcs_torzs_vezeto_2.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_kapcstarto ON mira_tagv_kod_kapcstarto.tagv_kod = kapcs_torzs_kapcstarto.tagv_kod

where
(
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1 is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2 is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto is not null

)
order by mira_tagv_kod.tagv_kod ASC
";

//echo $sql.'<br><br>';exit;

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();

  if(!isset($eredmeny_keres[$adatom['tagv_kod']])){
   $eredmeny_keres[$adatom['tagv_kod']]['tagv_kod_nev']=$adatom['tagv_kod_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['tagv_kod_inaktiv']=$adatom['tagv_kod_inaktiv'];
   $eredmeny_keres[$adatom['tagv_kod']]['kapcs_tulaj_nev']=$adatom['kapcs_tulaj_kod'].' - '.$adatom['kapcs_tulaj_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['adoszam']=$adatom['tagv_kod_adoszam'];
   $eredmeny_keres[$adatom['tagv_kod']]['cim']=$adatom['tagv_kod_cim'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_1']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['szerep']='vezeto_1';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['szolg_kod_nev']='Általános';
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['nev']=$adatom['kapcs_torzs_vezeto_1_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['tagv_kod']=$adatom['kapcs_torzs_vezeto_1_tagv_kod'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_1'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['beosztas']=$adatom['kapcs_torzs_vezeto_1_beosztas'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['tel']=$adatom['kapcs_torzs_vezeto_1_tel'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['email']=$adatom['kapcs_torzs_vezeto_1_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_1_t']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat'][$i]['szerep']='vezeto_1_t';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['szolg_kod_nev']='Általános';
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['nev']=$adatom['kapcs_torzs_vezeto_1_t_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['tagv_kod']=$adatom['kapcs_torzs_vezeto_1_t_tagv_kod'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_1_t'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['beosztas']=$adatom['kapcs_torzs_vezeto_1_t_beosztas'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['tel']=$adatom['kapcs_torzs_vezeto_1_t_tel'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['email']=$adatom['kapcs_torzs_vezeto_1_t_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_2']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['szerep']='vezeto_2';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['szolg_kod_nev']='Általános';
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['nev']=$adatom['kapcs_torzs_vezeto_2_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['tagv_kod']=$adatom['kapcs_torzs_vezeto_2_tagv_kod'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_2'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['beosztas']=$adatom['kapcs_torzs_vezeto_2_beosztas'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['tel']=$adatom['kapcs_torzs_vezeto_2_tel'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['email']=$adatom['kapcs_torzs_vezeto_2_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_kapcstarto']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['szerep']='kapcstarto';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['szolg_kod_nev']='Általános';
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['nev']=$adatom['kapcs_torzs_kapcstarto_nev'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['tagv_kod']=$adatom['kapcs_torzs_kapcstarto_tagv_kod'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['tagv_kod_nev']=$adatom['tagv_kod_nev_kapcstarto'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['beosztas']=$adatom['kapcs_torzs_kapcstarto_beosztas'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['tel']=$adatom['kapcs_torzs_kapcstarto_tel'];
   $eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['email']=$adatom['kapcs_torzs_kapcstarto_email'];
  }

 }

return $eredmeny_keres;

}

?>
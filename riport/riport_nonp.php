<?php

function riport_nonp(){

$tomb=keres_riport_nonp($_POST['date1_ev'],$_POST['date1_ho']);
mysqli_close($GLOBALS['mysqli']);
/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
*/
//exit;



$i=0;
$adat[$i][]="<b>Szervezet</b>";
$adat[$i][]="<b>SAP KÓD</b>";
$adat[$i][]="<b>Társaság</b>";
natcasesort($tomb['tagv_nev']);

$tmp=array();
if(isset($tomb['tagv_nev']['NKMH'])) $tmp['NKMH']=$tomb['tagv_nev']['NKMH'];
if(isset($tomb['tagv_nev']['MVRT'])) $tmp['MVRT']=$tomb['tagv_nev']['MVRT'];
foreach($tomb['tagv_nev'] as $tagv => $tagv_h){
 if(($tagv!='NKMH')and($tagv!='MVRT')){
	 $tmp[$tagv]=$tagv_h;
 }
}

$tomb['tagv_nev']=$tmp;
unset($tmp);

/*
echo '<pre>';
print_r($tomb['tagv_nev']);
echo '</pre>';
exit;
*/

natcasesort($tomb['kat_nev']);

//Óra érték - vége
foreach($tomb['kat_nev'] as $projekt_kat_id => $projekt_kat_nev){
 
 if($projekt_kat_nev!='')
  $adat[$i][]="<b>".$projekt_kat_nev."</b>";
 else
  $adat[$i][]='<b>Nincs</b>'; 
 $tomb_kat_id[]=$projekt_kat_id;
}
$adat[$i][]='<b>Összesen</b>';
//óra érték - vége

//Százalék érték - eleje
foreach($tomb['kat_nev'] as $projekt_kat_id => $projekt_kat_nev){
 
 if($projekt_kat_nev!='')
  $adat[$i][]="<b>".$projekt_kat_nev."</b>";
 else
  $adat[$i][]='<b>Nincs</b>'; 
}
//Százalék érték - vége


natcasesort($tomb['szerv_nev']);

foreach($tomb['szerv_nev'] as $szerv_csoport_id => $szerv_nev){
 $i++;
 if($szerv_nev!=''){
  $adat[$i][]="<b>".$szerv_nev."</b>";
  $szerv_nev_ki=$szerv_nev;
 }else{
  $adat[$i][]='<b>Nincs</b>';
  $szerv_nev_ki='Nincs';
 }

 //Csoport kategória összege - eleje
 $adat[$i][]="<b>SZUM</b>";
 $adat[$i][]="<b>".$szerv_nev_ki." összesen</b>";
 
 foreach($tomb_kat_id as $projekt_kat_id){
 if(isset($tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg'])){
	//$adat[$i][]="<b>".$tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg']."</b>";
	$adat[$i][]="<b>".osszeg_ezres_csop_ret($tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg'])."</b>";
 }else{
	$adat[$i][]=''; 
 }
 }
 //Csoport kategória összege - vége
 
 //Csoport összeg - eleje
 if(isset($tomb['adat'][$szerv_csoport_id]['osszeg'])){
	//$adat[$i][]="<b>".$tomb['adat'][$szerv_csoport_id]['osszeg']."</b>"; 
	$adat[$i][]="<b>".osszeg_ezres_csop_ret($tomb['adat'][$szerv_csoport_id]['osszeg'])."</b>"; 
 }else{
	 $adat[$i][]="<b>0</b>";
 }
 //Csoport összeg - vége
 
 //Százalék csoport összeg - eleje
 foreach($tomb_kat_id as $projekt_kat_id){
	if(
	(isset($tomb['adat'][$szerv_csoport_id]['osszeg']))and
	(isset($tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg']))
	){
	 //$szaz_ki=($tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg']/$tomb['adat'][$szerv_csoport_id]['osszeg'])*100;
	 $szaz_ki=$tomb['adat'][$szerv_csoport_id]['kat'][$projekt_kat_id]['osszeg']/$tomb['adat'][$szerv_csoport_id]['osszeg'];
	}else{
	 $szaz_ki=0;	
	}
	//$adat[$i][]=str_replace('.',',',round($szaz_ki,2)).'%';
	//////$adat[$i][]=round($szaz_ki,2).'%';
	//$adat[$i][]='<style nf="0.000%">'.$szaz_ki.'</style>';
	$adat[$i][]=osszeg_szazalek_ret($szaz_ki);
 }
 //Százalék csoport összeg - vége

 //Tagv adatait
 if(isset($tomb['adat'][$szerv_csoport_id]['tagv'])){
 //foreach($tomb['adat'][$szerv_csoport_id]['tagv'] as $projekt_tagv_kod => $ert){
   foreach($tomb['tagv_nev'] as $projekt_tagv_kod => $tagv_nev){
   if(isset($tomb['adat'][$szerv_csoport_id]['tagv'][$projekt_tagv_kod])){
	$ert=$tomb['adat'][$szerv_csoport_id]['tagv'][$projekt_tagv_kod];
	$i++;
	$adat[$i][]="<b>".$szerv_nev_ki."</b>";
	
	$adat[$i][]=$projekt_tagv_kod;
	$adat[$i][]=$tomb['tagv_nev'][$projekt_tagv_kod];
	
	foreach($tomb_kat_id as $projekt_kat_id){
		if(isset($ert[$projekt_kat_id]['osszeg']))
			//$adat[$i][]=$ert[$projekt_kat_id]['osszeg'];
			$adat[$i][]=osszeg_ezres_csop_ret($ert[$projekt_kat_id]['osszeg']);
		else
			$adat[$i][]='';
	}

  
 //Csoport tagv összesen - eleje
 if(isset($ert['osszeg'])){
	 $adat[$i][]=$ert['osszeg'];
 }else{
	 $adat[$i][]='';
 }
 //Csoport tagv összesen - vége

 //Százalék tagv - eleje
 foreach($tomb_kat_id as $projekt_kat_id){
	 	if(isset($ert[$projekt_kat_id]['osszeg'])){
			//$szaz_ki=($ert[$projekt_kat_id]['osszeg']/$tomb['adat'][$szerv_csoport_id]['osszeg'])*100;
			//$adat[$i][]=round($szaz_ki,2).'%';
			$szaz_ki=$ert[$projekt_kat_id]['osszeg']/$tomb['adat'][$szerv_csoport_id]['osszeg'];
			//$adat[$i][]='<style nf="0.000%">'.$szaz_ki.'</style>';
			$adat[$i][]=osszeg_szazalek_ret($szaz_ki);
		}else{
			$adat[$i][]='';
		}
 }
 //Százalék tagv - vége


 }
 }
 }

}

/*
echo '<pre>';
print_r($adat);
echo '</pre>';
exit;
*/

$date=date("Y_m_d-H_i_s",time());
$filename="Riport NOPRODUKTÍV excel export ".$date.".xlsx";
//$xlsx->autoFilter('A1:B10');
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' riport')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,$GLOBALS['rend_nev'].' riport');
//$alphabet = range('A','Z');
//$xlsx->autoFilter('A1:'.$alphabet[(sizeof($adat[$i])-1)].'1');
//$xlsx->autoFilter('A1:'.excelOszlopKod(sizeof($adat[$i])).'1');
$xlsx->autoFilter('A1:C1');
//Letöltés
$xlsx->downloadAs(rawurlencode($filename));

}
/*
function excelOszlopKod($szam) {
    $oszlopKod = '';
    
    while ($szam > 0) {
        // Mivel az Excel 1-től indexel, de a matematika 0-tól (maradékos osztás),
        // kivonunk 1-et a számból a ciklus elején.
        $szam--;
        
        // Megnézzük a 26-tal való osztási maradékot
        $maradek = $szam % 26;
        
        // Hozzáadjuk a karaktert az elejére. 
        // A 'chr(65)' az 'A' betű. Ha a maradék 0, akkor 'A', ha 1, akkor 'B', stb.
        $oszlopKod = chr(65 + $maradek) . $oszlopKod;
        
        // Elosztjuk a számot 26-tal (lefelé kerekítve), hogy a következő helyiértékre lépjünk
        $szam = intval($szam / 26);
    }
    
    return $oszlopKod;
}
*/
function osszeg_szazalek_ret($ret){
return '<style nf="0.000%">'.$ret.'</style>';
}

function osszeg_ezres_csop_ret($ret){
return '<style nf="#,##0.00">'.$ret.'</style>';
}

function keres_riport_nonp($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_nonp_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$_POST['date1_ho']);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_adat_".$ev."_teny_3_2.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }

$sql="SELECT
backup_szerv_csoport.mira_szerv_csoport_id,
backup_szerv_csoport.mira_szerv_csoport_nev,
if(backup_projekt_szerv.projekt_kat_id_kivetel !='', backup_projekt_szerv.projekt_kat_id_kivetel,backup_pojekt.projekt_kat_id) as projekt_kat_id,
if(backup_projekt_szerv.projekt_kat_id_kivetel !='', backup_projekt_kat_kivetel.projekt_kat_nev,backup_projekt_kat.projekt_kat_nev) as projekt_kat_nev,
backup_pojekt.projekt_tagv_kod,
backup_tagv_kod.tagv_kod_nev,
backup_adat_".$ev."_teny_3_2.rogzitett_teny3_ora_egesz

FROM `backup_adat_".$ev."_teny_3_2` 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_2.backup_pojekt_id 
left join backup_projekt_kat ON backup_projekt_kat.projekt_kat_id = backup_pojekt.projekt_kat_id
	and backup_projekt_kat.backup_ver_id = backup_pojekt.backup_ver_id 

left join backup_projekt_szerv ON backup_projekt_szerv.projekt_id = backup_adat_".$ev."_teny_3_2.backup_pojekt_id 
	and backup_projekt_szerv.szerv_id = backup_adat_".$ev."_teny_3_2.backup_szerv_id
	and backup_projekt_szerv.backup_ver_id = backup_adat_".$ev."_teny_3_2.backup_ver_id
	and backup_projekt_szerv.projekt_kat_id_kivetel is not null	
left join backup_projekt_kat as backup_projekt_kat_kivetel ON  backup_projekt_kat_kivetel.projekt_kat_id=backup_projekt_szerv.projekt_kat_id_kivetel 
	and backup_projekt_kat_kivetel.backup_ver_id = backup_projekt_szerv.backup_ver_id

left join backup_szerv ON backup_szerv.backup_szerv_id  = backup_adat_".$ev."_teny_3_2.backup_szerv_id
left join backup_szerv_csoport ON backup_szerv_csoport.mira_szerv_csoport_id = backup_szerv.szerv_csoport_id
	and backup_szerv_csoport.backup_ver_id = backup_szerv.backup_ver_id

left join backup_tagv_kod ON backup_tagv_kod.tagv_kod = backup_pojekt.projekt_tagv_kod 
	and backup_tagv_kod.backup_ver_id = backup_pojekt.backup_ver_id 

".$where;
//order by mira_szerv_csoport_nev asc, projekt_kat_nev asc,backup_tagv_kod.tagv_kod_nev asc

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
	
	//Ha nincs szerv, akkor legyen értéke
	if($adatom['mira_szerv_csoport_id']=='')$adatom['mira_szerv_csoport_id']=0;
	
	if($adatom['mira_szerv_csoport_nev']!='')
	 $eredmeny_keres['szerv_nev'][$adatom['mira_szerv_csoport_id']]=$adatom['mira_szerv_csoport_nev'];
	else
	 $eredmeny_keres['szerv_nev'][$adatom['mira_szerv_csoport_id']]='';//nincs
	
	if($adatom['projekt_kat_nev']!='')
	$eredmeny_keres['kat_nev'][$adatom['projekt_kat_id']]=$adatom['projekt_kat_nev'];
	else
	 $eredmeny_keres['kat_nev'][$adatom['projekt_kat_id']]='';//nincs
 
	//Tagvállalat név
	if($adatom['tagv_kod_nev']!='')
	  $eredmeny_keres['tagv_nev'][$adatom['projekt_tagv_kod']]=$adatom['tagv_kod_nev'];
	else
	 $eredmeny_keres['tagv_nev'][$adatom['projekt_tagv_kod']]='';//nincs

 
	if(!isset($eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']])){
	 $eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['osszeg']=0;
	}
	
	//Csoport összeg
	$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['osszeg']+=$adatom['rogzitett_teny3_ora_egesz'];
	
	//Csoport kategória összege
	if(!isset($eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['kat'][$adatom['projekt_kat_id']])){
	 $eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['kat'][$adatom['projekt_kat_id']]['osszeg']=0;
	}
	$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['kat'][$adatom['projekt_kat_id']]['osszeg']+=$adatom['rogzitett_teny3_ora_egesz'];
	
	//Csoport tagv összesen

	if(!isset($eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']])){
		$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']]['osszeg']=0;
	}
	$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']]['osszeg']+=$adatom['rogzitett_teny3_ora_egesz'];
	
	//Csoport tagv kategória összesen
	if(!isset($eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']][$adatom['projekt_kat_id']])){
		$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']][$adatom['projekt_kat_id']]['osszeg']=0;
	}
	
	$eredmeny_keres['adat'][$adatom['mira_szerv_csoport_id']]['tagv'][$adatom['projekt_tagv_kod']][$adatom['projekt_kat_id']]['osszeg']+=$adatom['rogzitett_teny3_ora_egesz'];
 }
return $eredmeny_keres; 
}

function keress_riport_ful_ki_evho_nonp_excelhez($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_2 = '1' 
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
<?php

function excel_export_reszletes($ev,$ho,$tipus){
if(($ho!="all")and($ho<10))$ho_ki="0".$ho;
else $ho_ki=$ho;

$date=date("Y_m_d-H_i_s",time());

if($tipus=="reszletes"){
 $filename_str="részletes";
}else{
 $filename_str="részletesebb";
}

$filename=$GLOBALS['rend_nev']." statisztika ".$filename_str." ".$date.".xlsx";

$csv_uft8="\xEF\xBB\xBF";
$elv_oszlop=';';
$elv_sor=PHP_EOL;
$csv_adat=$csv_uft8;
if($ho=='all'){
 $csv=1;
}else{
 $csv=0;
}

if($csv==1){	
	
	if($tipus=="reszletes"){
	 $filename_str="reszletes";
	}else{
	 $filename_str="reszletesebb";
	}
	
	$filename_csv=$GLOBALS['rend_nev']." statisztika ".$filename_str." ".$date.".csv";
	
	if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
		$f = fopen($GLOBALS['excel_auto_mappa'].$filename_csv, 'w');
		fwrite($f,$csv_uft8);
	}else{
		//header("Content-Type: application/octet-stream");
		header("Content-Type: text/csv; charset=utf-8");
		
		header("Content-Disposition: attachment; filename=\"".$filename_csv."\";" );

		header("Content-Transfer-Encoding: binary");
		$f = fopen('php://output', 'w');
		fwrite($f,$csv_uft8);
	
	}
}

$tomb=keress_stat_rogzitett($ev,$ho,$tipus,"1");

mysqli_close($GLOBALS['mysqli']);
/*echo "<pre>";
print_r($tomb);
echo "</pre>";
exit;*/

$i=0;
if($csv==1)
 $adat[$i][]='Név';
else
 $adat[$i][]='<b>Név</b>';

if($csv==1)
 $adat[$i][]='AD azonosító';
else
 $adat[$i][]='<b>AD azonosító</b>';

if($csv==1)
 $adat[$i][]='Törzsszám';
else
 $adat[$i][]='<b>Törzsszám</b>';

if($tipus=="reszletes2"){
 if($csv==1)
  $adat[$i][]='Email cím';
 else
  $adat[$i][]='<b>Email cím</b>';
}

if($csv==1)
 $adat[$i][]='Szervezet';
else
 $adat[$i][]='<b>Szervezet</b>';

if($csv==1)
 $adat[$i][]='Statisztika költséghely';
else 
 $adat[$i][]='<b>Statisztika költséghely</b>';

if($csv==1)
 $adat[$i][]='AD költséghely';
else
 $adat[$i][]='<b>AD költséghely</b>';

if($csv==1)
 $adat[$i][]='Tevékenység neve';
else
 $adat[$i][]='<b>Tevékenység neve</b>';

if($tipus=="reszletes2"){

//Társasági SAP kód
if($csv==1)
 $adat[$i][]='Társasági SAP kód';
else
 $adat[$i][]='<b>Társasági SAP kód</b>';

//Szervezeti szolgáltatás kód
if($csv==1)
 $adat[$i][]='Szervezeti szolgáltatás kód';
else
 $adat[$i][]='<b>Szervezeti szolgáltatás kód</b>';

//Tevékenységek szolgáltatás kód
if($csv==1)
 $adat[$i][]='Tevékenységek szolgáltatás kód';
else
 $adat[$i][]='<b>Tevékenységek szolgáltatás kód</b>';

//Aktuális szolgáltatás kód
if($csv==1)
 $adat[$i][]='Aktuális szolgáltatás kód';
else
 $adat[$i][]='<b>Aktuális szolgáltatás kód</b>';

//SM SAP kód
if($csv==1)
 $adat[$i][]='SM SAP kód';
else
 $adat[$i][]='<b>SM SAP kód</b>';

if($csv==1)
 $adat[$i][]='CO Objektum';
else
 $adat[$i][]='<b>CO Objektum</b>';

}

if($csv==1)
 $adat[$i][]='Dátum';
else
 $adat[$i][]='<b>Dátum</b>';

if($tipus=="reszletes2"){
if($csv==1)
 $adat[$i][]='Hónap';
else
 $adat[$i][]='<b>Hónap</b>';
}

if($csv==1)
 $adat[$i][]='Rögzített munkaidő';
else
 $adat[$i][]="<b>Rögzített munkaidő</b>";

if($tipus=="reszletes2"){
 
 if($csv==1)
  $adat[$i][]='Rögzített munkaidő - egészszám';
 else
  $adat[$i][]='<b>Rögzített munkaidő - egészszám</b>';

 if($csv==1)
  $adat[$i][]='Rögzített munkaidő - óra';
 else
  $adat[$i][]='<b>Rögzített munkaidő - óra</b>';

 if($csv==1)
  $adat[$i][]='Rögzített munkaidő - perc';
 else
  $adat[$i][]='<b>Rögzített munkaidő - perc</b>';
}

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 if($csv==1)
  $adat[$i][]='Távollét';
 else
  $adat[$i][]='<b>Távollét</b>';
}

if($tipus=="reszletes2"){
 if($csv==1)
  $adat[$i][]='Rögzítés ideje';
 else
  $adat[$i][]="<b>Rögzítés ideje</b>";

 if($csv==1)
  $adat[$i][]='Rögzítő megjegyzése';
 else
  $adat[$i][]='<b>Rögzítő megjegyzése</b>';

 if($csv==1)
  $adat[$i][]='Rögzítő tevékenység megjegyzése';
 else
  $adat[$i][]='<b>Rögzítő tevékenység megjegyzése</b>';
 
 if($csv==1)
  $adat[$i][]='Rögzítő helyettes-e';
 else
  $adat[$i][]='<b>Rögzítő helyettes-e</b>';
 
 if($csv==1)
  $adat[$i][]='Rögzítő helyettes neve';
 else
  $adat[$i][]='<b>Rögzítő helyettes neve</b>';
 
 if($csv==1)
  $adat[$i][]='Lezárva';
 else
  $adat[$i][]='<b>Lezárva</b>';
 
 if($csv==1)
  $adat[$i][]='Lezárás ideje';
 else
  $adat[$i][]='<b>Lezárás ideje</b>';

 if($csv==1)
  $adat[$i][]='Lezáró jóváhagyó-e';
 else
  $adat[$i][]='<b>Lezáró jóváhagyó-e</b>';
 
 if($csv==1)
  $adat[$i][]='Lezáró jóváhagyó neve';
 else
  $adat[$i][]='<b>Lezáró jóváhagyó neve</b>';
 
  //Projekt jóváhagyások, előbb a visszaküldés
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyó által visszaküldve';
 else
  $adat[$i][]='<b>Projekt jóváhagyó által visszaküldve</b>';
 
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyó visszaküldő';
 else
  $adat[$i][]='<b>Projekt jóváhagyó visszaküldő</b>';
 
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyó visszaküldés ideje';
 else
  $adat[$i][]='<b>Projekt jóváhagyó visszaküldés ideje</b>';
 
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyás';
 else
  $adat[$i][]='<b>Projekt jóváhagyás</b>';
 
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyó';
 else
  $adat[$i][]='<b>Projekt jóváhagyó</b>';
 
 if($csv==1)
  $adat[$i][]='Projekt jóváhagyás ideje';
 else
  $adat[$i][]='<b>Projekt jóváhagyás ideje</b>';
 
 if($csv==1)
  $adat[$i][]='Szervezet által visszaküldve';//Visszaküldve
 else
  $adat[$i][]='<b>Szervezet által visszaküldve</b>';//Visszaküldve

 if($csv==1)
  $adat[$i][]='Szervezeti visszaküldő';//Visszaküldő
 else
  $adat[$i][]='<b>Szervezeti visszaküldő</b>';//Visszaküldő
 
 if($csv==1)
  $adat[$i][]='Szervezet visszaküldés ideje';//Visszaküldés ideje
 else
  $adat[$i][]='<b>Szervezet visszaküldés ideje</b>';//Visszaküldés ideje
 
 if($csv==1)
  $adat[$i][]='Szervezeti jóváhagyás';//Jóváhagyva
 else
  $adat[$i][]='<b>Szervezeti jóváhagyás</b>';//Jóváhagyva
 
 if($csv==1)
  $adat[$i][]='Szervezeti jóváhagyó';//Jóváhagyó
 else
  $adat[$i][]='<b>Szervezeti jóváhagyó</b>';//Jóváhagyó
 
 if($csv==1)
  $adat[$i][]='Szervezeti jóváhagyás ideje';//Jóváhagyás ideje
 else
  $adat[$i][]='<b>Szervezeti jóváhagyás ideje</b>';//Jóváhagyás ideje
}

if($csv==1){
 foreach($adat[$i] as $s_adat){
  //$csv_adat.=$s_adat.$elv_oszlop;
  fwrite($f,$s_adat.$elv_oszlop);
 }
 //$csv_adat.=$elv_sor;
 fwrite($f,$elv_sor);
 unset($adat[$i]);
}

if(is_array($tomb)){
foreach($tomb as $is => $ert){
 $i++;
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['user_tsz'];
 if($tipus=='reszletes2')
  $adat[$i][]=$ert['user_email'];
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['szerv_koltsegkod'];
 $adat[$i][]=$ert['szerv_adkod'];
 $adat[$i][]=$ert['projekt_nev'];
 
 if($tipus=='reszletes2'){
 //Társasági SAP kód
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 //Szervezeti szolgáltatás kód
 $adat[$i][]=$ert['szerv_szolg_kod'];
 
 //Tevékenységek szolgáltatás kód
 $adat[$i][]=$ert['projekt_szolg_kod'];
 
 //Aktuális szolgáltatás kód - eleje
 if($ert['projekt_szolg_kod']!="")
  $adat[$i][]=$ert['projekt_szolg_kod'];
 else
  $adat[$i][]=$ert['szerv_szolg_kod'];
 
 //Aktuális szolgáltatás kód - vége
 
 //SM SAP kód - eleje
 $adat[$i][]=$ert['szerv_sm_kod'];
 //SM SAP kód - vége
 
 //CO objektum - eleje
  $adat[$i][]=$ert['projekt_co'];
 //CO objektum - vége
}

 //Rögzített nap - eleje
 if($ert['rogzit_nap']<10)$nap_ki='0'.$ert['rogzit_nap'];
 else $nap_ki=$ert['rogzit_nap'];
 //$rog_ido_ki=$ev.".".$ho_ki.".".$nap_ki;
 
 if($ho_ki=='all')
  $rog_ido_ki=$ev.'-'.$ert['rogzit_ho'].'-'.$nap_ki;
 else
  $rog_ido_ki=$ev.'-'.$ho_ki.'-'.$nap_ki;
 
 
 $adat[$i][]=$rog_ido_ki;
 //Rögzített nap - vége
 
 //Hónap (Dátum után) - eleje
 if($tipus=="reszletes2"){
  if($ho_ki=='all')
   $adat[$i][]=$ert['rogzit_ho'];
  else
   $adat[$i][]=$ho;
 }
 //Hónap (Dátum után) - vége
 
 //Rögzített munkaidő - eleje
 if($ert['projekt_nev']!=''){
 $ora=$ert['rogzit_ora'];
 if($ert['rogzit_perc']<10)
  $perc='0'.$ert['rogzit_perc'];
 else
  $perc=$ert['rogzit_perc'];
 if(($ora=='0')and($perc=='00'))
  //$adat[$i][]="<right>0:00</right>";
  $adat[$i][]='0:00';
 else
  $adat[$i][]=$ora.':'.$perc;
 }else{//Ekkor távvolét van!
	 $adat[$i][]='';
 }
 //Rögzített munkaidő - vége
 
 //Rögzített munkaidő óra - eleje
 if($tipus=="reszletes2"){
	 
  //egészszám
  $egeszzam_ora=$ert['rogzit_ora'];
  $egeszzam_ora+=$ert['rogzit_perc']/60;
  if($csv==1)
   $adat[$i][]=str_replace('.',',',round($egeszzam_ora,2));
  else
   $adat[$i][]=round($egeszzam_ora,2);
  
  if($ert['rogzit_ora']=='0')
   $adat[$i][]=0;
  else
   $adat[$i][]=$ert['rogzit_ora'];

  if($ert['rogzit_perc']=='0')
   $adat[$i][]=0;
  else
   $adat[$i][]=$ert['rogzit_perc'];
 }
 //Rögzített munkaidő óra - vége
 
 //Távollét - eleje
 //Távollét oszlop idő elrejtése
 if(tavollet_lathato_e($ev,$ho)){
  if($ert['tavollet']=='1')
   $adat[$i][]='Igen';
  else
   $adat[$i][]='';
 }
 //Távollét - vége
 
if($tipus=='reszletes2'){

//Rögzítés ideje - eleje
if($ert['tavollet']=='1')//Távvolét esetén máshol van.
 $adat[$i][]=$ert['rogzit_update_time'];
else
 $adat[$i][]=$ert['rogzit_sor_update_time'];
//Rögzítés ideje - vége

//Rögzítő megjegyzése - eleje
 //$adat[$i][]=$ert['rogzit_megj'];
 if(($csv==1)and($ert['rogzit_megj']!='')){
  $ert['rogzit_megj']=str_replace(';',',',$ert['rogzit_megj']);
 }
 if($ert['rogzit_megj']!='')
  $ert['rogzit_megj']=str_replace(["\r\n", "\r", "\n"],' ',$ert['rogzit_megj']);
 $adat[$i][]=$ert['rogzit_megj'];
//Rögzítő megjegyzése - vége

//Rögzítő tevékenység megjegyzése - eleje
 if(($csv==1)and($ert['rogzit_sor_megj']!=''))
  $ert['rogzit_sor_megj']=str_replace(';',',',$ert['rogzit_sor_megj']);
if($ert['rogzit_sor_megj']!='')
 $ert['rogzit_sor_megj']=str_replace(["\r\n", "\r", "\n"],' ',$ert['rogzit_sor_megj']);
 $adat[$i][]=$ert['rogzit_sor_megj'];
//Rögzítő tevékenység megjegyzése - vége

//Helyettes-e a kitöltő és neve - eleje
 if($ert['helyettes_rogzito']=='1'){
  $adat[$i][]='Igen';
  $adat[$i][]=$ert['helyettes_rogzito_ki_nev'];
 }else{
  $adat[$i][]='';
  $adat[$i][]='';
 }
//Helyettes-e a kitöltő és neve - vége

 //Lezárva - eleje
 if($ert['ellenorzesre_lezarva']=='1'){
  $adat[$i][]='Igen';
  $adat[$i][]=$ert['ellenorzesre_lezarva_mikor'];
 }else{
  $adat[$i][]='';
  $adat[$i][]='';
 }
 //Lezárva - vége
 
 //Lezáró jóváhagyó-e és név - eleje
 if($ert['ellenorzesre_lezarva_jovahagyo']=='1'){
  $adat[$i][]='Igen';
  $adat[$i][]=$ert['ellenorzesre_lezarva_jovahagyo_ki_nev'];
 }else{
  $adat[$i][]='';
  $adat[$i][]='';
 }
 //Lezáró jóváhagyó-e és név - vége

	//Projekt jóváhagyó által visszaküldve - eleje
	if($ert['projekt_jovahagyo_elutasitva']=='1'){
		$adat[$i][]='Igen';
		$adat[$i][]=$ert['projekt_jovahagyo_elutasitva_nev'];////Projekt jóváhagyó visszaküldő
		$adat[$i][]=$ert['projekt_jovahagyo_elutasitva_mikor'];////Projekt jóváhagyó visszaküldés ideje
	}else{
		$adat[$i][]='';
		$adat[$i][]='';
		$adat[$i][]='';
	}
	//Projekt jóváhagyó által visszaküldve - vége

	//Projekt jóváhagyás  - eleje
	if($ert['projekt_jovahagyo_jovahagyva']=='1'){
		$adat[$i][]='Igen';
		$adat[$i][]=$ert['projekt_jovahagyo_jovahagyva_nev'];////Projekt jóváhagyó
		$adat[$i][]=$ert['projekt_jovahagyo_jovahagyva_mikor'];////Projekt jóváhagyás ideje
	}else{
		$adat[$i][]='';
		$adat[$i][]='';
		$adat[$i][]='';
	}
	//Projekt jóváhagyás  - vége

 //Visszaküldés - eleje
  if($ert['ellenorzesre_visszakuldve']=='1'){
  $adat[$i][]='Igen';
  $adat[$i][]=$ert['ellenorzesre_visszakuldve_ki_nev'];
  $adat[$i][]=$ert['ellenorzesre_visszakuldve_mikor'];
 }else{
  $adat[$i][]='';
  $adat[$i][]='';
  $adat[$i][]='';
 }
 //Visszaküldés - vége
 
 //Jóváhagyva - eleje
  if($ert['ellenorzesre_ok']=='1'){
  $adat[$i][]='Igen';
  $adat[$i][]=$ert['ellenorzesre_ok_ki_nev'];
  $adat[$i][]=$ert['ellenorzesre_ok_mikor'];
 }else{
  $adat[$i][]='';
  $adat[$i][]='';
  $adat[$i][]='';
 }
 //Jóváhagyva - vége

}

if($csv==1){
 foreach($adat[$i] as $s_adat){
  //$csv_adat.=$s_adat.$elv_oszlop;
  fwrite($f,$s_adat.$elv_oszlop);
 }
 unset($adat[$i]);
 //$csv_adat.=$elv_sor;
 fwrite($f,$elv_sor);
}

unset($tomb[$is]);
}
}

/*
echo 'Memory in use: ' . memory_get_usage() . ' ('. ((memory_get_usage() / 1024) / 1024) .'M) <br>';
unset($tomb);
//echo 'Memory in use: ' . memory_get_usage() . ' ('. ((memory_get_usage() / 1024) / 1024) .'M) <br>';

echo 'Memory in use: ' . memory_get_usage() . ' ('. ((memory_get_usage() / 1024) / 1024) .'M) <br>';
exit;
*/



if($csv==1){
	/*
	$filename_csv=$GLOBALS['rend_nev']." statisztika ".$filename_str." ".$date.".csv";
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename_csv."\";" );
	header("Content-Transfer-Encoding: binary");
	//echo $csv_adat;
	
	$f = fopen('php://output', 'w');
	fwrite($f,$csv_adat);
	*/
	unset($adat);
	fclose($f);
	
	//exit;
}else{

/*
echo "<pre>";
print_r($adat);
echo "</pre>";
exit;*/

//Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export');
unset($adat);

if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
}

}

//(string)(new SimpleXLSXGen)->addSheet($adat,'MIRA export')->downloadAs(rawurlencode($filename));
}

?>
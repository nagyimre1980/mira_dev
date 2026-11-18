<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");
require_once "../simplexlsx/xlsx_simple.php";
use Shuchkin\SimpleXLSX;

tenypotlas_betolt();

function tenypotlas_betolt(){
$tomb=xlsx_read($_FILES['datafile']['tmp_name']);

if(
 (isset($tomb['fejlec']))and
 (isset($tomb['adat']))and
 (isset($tomb['fejlec'][0]))and
 (isset($tomb['fejlec'][1]))and
 (isset($tomb['fejlec'][2]))and
 (isset($tomb['fejlec'][3]))and
 ($tomb['fejlec'][0]=='Szolgáltatás ID')and
 ($tomb['fejlec'][1]=='Év')and
 ($tomb['fejlec'][2]=='Hó')and
 ($tomb['fejlec'][3]=='Egyéb naturália')
){//Ekkor ok az excel

$tomb_ok_id='';
$oksor=0;
$hibaidsor=0;
$hiba_nincs_id='';
$hiba_nincs_kitoltve=0;

 foreach($tomb['adat'] as $ert){
  if(
  (isset($ert[0]))and
  (isset($ert[1]))and
  (isset($ert[2]))and
  (isset($ert[3]))and
  ($ert[0]!='')and
  ($ert[1]!='')and
  ($ert[2]!='')and
  ($ert[3]!='')
  ){//Ekkor van minden adat
  $szolg_id=$ert[0];
  $evho=$ert[1].'-'.$ert[2].'-01';
  $vane_lementve=keres_mit2_mit1_csak_ertek('szerz_tenybe_egyebnat','szerz_tetel_id',$szolg_id,'tenybe_egyebnat_evho',$evho,'szerz_tetel_id');
  if($vane_lementve==''){
	  $hibaidsor++;
	 if(!is_array($hiba_nincs_id))$hiba_nincs_id=array();
	  $hiba_nincs_id[$hibaidsor]['szolg_id']=$szolg_id;
	  $hiba_nincs_id[$hibaidsor]['evho']=$ert[1].'-'.$ert[2];
  }else{
	 $oksor++;
	 if(!is_array($tomb_ok_id))$tomb_ok_id=array();
	 $tomb_ok_id[$oksor]['szerz_tetel_id']=$szolg_id;
	 $tomb_ok_id[$oksor]['tenybe_egyebnat_evho']=$evho;
	 $tomb_ok_id[$oksor]['egyebnat']=$ert[3];
  }
 }else{
		 $hiba_nincs_kitoltve++;
 }

}

 if(($hiba_nincs_kitoltve>0)and(!is_array($hiba_nincs_id)))
  return_vissza(1,$hiba_nincs_kitoltve." sor hiányos!<br> Betöltés megszakítva!");
 elseif(is_array($hiba_nincs_id)){
  $ki_hianyzo='<ul style=\'margin:0px\'>';
  foreach($hiba_nincs_id as $ert){
		$ki_hianyzo.='<li>'.$ert['szolg_id'].' ('.$ert['evho'].')';
  }
  $ki_hianyzo.='</ul>';
  return_vissza(1,"Nincs minden szolgáltatás ID felvéve!<br>Betöltés megszakítva!<br><br>Hiányzó Szolgáltatás ID: ".$ki_hianyzo);
 }else{
  be_visz_replace("szerz_tenybe_egyebnat",$tomb_ok_id);
  return_vissza(0,"<br><br>Felvitt sorok száma: ".$oksor);
 }
 

}else{
 return_vissza(1,"Hibás az excel felépítése!");
}
}

function return_vissza($result,$hiba){
echo '<!DOCTYPE HTML>';
echo '<script language="javascript" type="text/javascript">';
if($result==0){//ok
  echo 'window.top.window.stopok_Upload_tenypotlastig_file(\''.$hiba.'\');';
}else{
  echo 'window.top.window.stop_Upload_tenypotlastig_file("'.$result.'","'.$hiba.'");';
}
echo '</script>';
exit;
}

function xlsx_read($file){
$adat=array();
if ( $xlsx = SimpleXLSX::parse($file)) {
$xlsx->setDateTimeFormat('Ymd');
//echo $xlsx->getCell(0,"D4");
$oszlopok=array();
//$sorokszam_max=0;
	$fejlec=$header_values = $rows = [];

	
	foreach ( $xlsx->rows() as $sorszam => $r ) {
	
	if ( $sorszam === 0 ) {
	 //$header_values = $r;

	 foreach($r as $olszlopszam => $value){
	  //$fej_str=func_trim_kisbetu($value);
	  $fej_str=trim($value);

	  //$fejlec[$fej_str]=$olszlopszam;
	  $fejlec[$olszlopszam]=$fej_str;
	  //$fejlec_orig[$value]=$olszlopszam;
	  //$header_values[]=$fej_str;
	  $header_values[]=$olszlopszam;
	 }
	 
	 continue;	 
	}else{
		//print_r($r);
		//$rows[] = array_combine( $header_values, $r );
		$rows[] = array_combine( $header_values,array_map('trim',$r));
	}
	
	}

}

$adat=array();
if(isset($fejlec)){
 $adat['fejlec']=$fejlec;
 //$adat['fejlec_orig']=$fejlec_orig;
}
if(isset($rows)){
 $adat['adat']=$rows;
}
return $adat;
}

?>
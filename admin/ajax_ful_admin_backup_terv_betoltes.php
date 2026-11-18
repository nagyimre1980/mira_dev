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

if(
 (isset($_POST['backup_ver_id']))and
 (isset($_POST['tipus']))and
 ($_POST['backup_ver_id']!="")and
 ($_POST['tipus']=="projekt_szetbontas")
){
 terv_projekt_szetbontas_betolt();
}else{
 return_vissza(1,"Ismeretlen típus érték!");
}

function terv_projekt_szetbontas_betolt(){
//Nézzük meg, hogy jó-e az első sor.

$tomb=xlsx_read($_FILES['datafile']['tmp_name']);

/*echo '<pre>';
print_r($tomb);
echo '</pre>';*/
if(
 (isset($tomb['fejlec']))and
 (isset($tomb['adat']))and
 (isset($tomb['fejlec'][0]))and
 (isset($tomb['fejlec'][1]))and
 (isset($tomb['fejlec'][2]))and
 ($tomb['fejlec'][0]=='Miről Tevékenység ID')and
 ($tomb['fejlec'][1]=='Mire Tevékenység ID')and
 ($tomb['fejlec'][2]=='Arány')
){
 //Töröljük ami van
 //echo 'backup_ver_id:'.$_POST['backup_ver_id'];
 torles('backup_projekt_szetbontas','backup_ver_id',$_POST['backup_ver_id']);
 //De törölni kell a kalkulációkat is!
 include_once('ajax_ful_admin_backup_terv_func.php');
 admin_backup_terv_3_1_1_del();
  
 $hiba_kiahgyva=0;
 $oksor=0;
 foreach($tomb['adat'] as $ert){
	 if(
	 (isset($ert[0]))and
	 (isset($ert[1]))and
	 (isset($ert[2]))and
	 ($ert[0]!='')and
	 ($ert[1]!='')and
	 ($ert[2]!='')
	 ){//Ekkor van minden adat
		 $mirol=keres_mit2_mit1_csak_ertek('backup_pojekt',"backup_ver_id",$_POST['backup_ver_id'],'projekt_id',$ert[0],'backup_pojekt_id');
		 $mire=keres_mit2_mit1_csak_ertek('backup_pojekt',"backup_ver_id",$_POST['backup_ver_id'],'projekt_id',$ert[1],'backup_pojekt_id');
		 if(($mirol!='')and($mire!='')){
			$tmp_adat_ver=array();
			$tmp_adat_ver[0]['backup_ver_id']=$_POST['backup_ver_id'];
			$tmp_adat_ver[0]['backup_pojekt_id']=$mirol;
			$tmp_adat_ver[0]['szetbont_backup_pojekt_id']=$mire;
			$tmp_adat_ver[0]['szetbont_arany']=$ert[2];
			be_visz_insert_simabackup("backup_projekt_szetbontas",$tmp_adat_ver);
			$oksor++;
		 }else{
			 $hiba_kiahgyva++;
		 }
	 }else{
		 $hiba_kiahgyva++;
	 }
 }
 
 if($hiba_kiahgyva>0)
  return_vissza(1,$hiba_kiahgyva."Sor kihagyva!<br>Beszúrt sok száma: ".$oksor);
 else
  return_vissza(0,"<br><br>Beszúrt sok száma: ".$oksor." <br><br>Figyelem: Kalkulációkat újra kell generálni!");
  //return_vissza(0,"Beszúrt sok száma: ".$oksor.". Figyelem: Kalkulációkat újra kell generálni!");
 
}else{
 return_vissza(1,"hibás az excel felépítése!");
}

}

function return_vissza($result,$hiba){
echo '<!DOCTYPE HTML>';
echo '<script language="javascript" type="text/javascript">';
if($result==0){//ok
 $tomb_evho=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);
  echo 'window.top.window.stopok_Upload_terv_file(\''.$hiba.'\',\''.$tomb_evho[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\');';
}else{
  echo 'window.top.window.stop_Upload_terv_file("'.$result.'","'.$hiba.'");';
}
echo '</script>';
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
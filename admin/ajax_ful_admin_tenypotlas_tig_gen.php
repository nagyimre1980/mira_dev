<?php

function ajax_keres_admin_szerz_tenypotlastig_generalas(){

torles('szerz_tenybe_egyebnat','tenybe_egyebnat_evho',$_POST['ev'].'-'.$_POST['ho'].'-01');

$tomb=ajax_keres_admin_szerz_tenypotlastig_generalas_sql();
if(is_array($tomb)){
 $tmp_bk=array();
 foreach($tomb as $i => $ert){
   $tmp_bk[$i]['szerz_tetel_id']=$ert['szerz_tetel_id'];	 
   $tmp_bk[$i]['tenybe_egyebnat_evho']=$_POST['ev'].'-'.$_POST['ho'].'-01';
 }

 be_visz_insert('szerz_tenybe_egyebnat',$tmp_bk);
}
}

function ajax_keres_admin_szerz_tenypotlastig_generalas_sql(){
$eredmeny_keres="";

$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ho']);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['nap']);
if(
 (isset($_POST['miraorakelle']))and
 ($_POST['miraorakelle']=='1')
){//Ekkor szerz_elsz_tipus_id=1 nem kell legenerálni
 //$sql_egyesne=" szerz_tetel_adat.szerz_elsz_tipus_id!='1' and ";
 $sql_egyesne=" szerz_tetel_adat.szerz_naturalia_id!='6' and ";
}else $sql_egyesne='';

$sql="SELECT szerz_tetel.szerz_tetel_id

 FROM `szerz_tetel` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 where".$sql_egyesne."
  szerz_tetel.szerz_tetel_vege='0' and 
  (
   (szerz_tetel.szerz_tetel_szolg_origveg_date is null)
   or
   (szerz_tetel.szerz_tetel_szolg_origveg_date>='".$ev."-".$ho."-".$nap."')
  )
  and
  (
   (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='1')
   or
   (
    (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0')and
	(szerz_tetel_adat.szerz_tetel_akt='1')and
	(szerz_tetel_adat.szerz_tetel_akt_folyamatban='0')
   )
  ) 
";
//echo $sql;exit;
 return mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC);
}

?>
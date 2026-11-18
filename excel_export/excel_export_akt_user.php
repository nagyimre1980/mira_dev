<?php

function excel_export_akt_user($user_ad,$ev,$ho){

//Jogosultság kezelés - eleje
if($_POST['mod_egyedi']=='xlsx_export_akt_user'){//Ha sima user
 if(
 (($user_ad!=$_SESSION[$GLOBALS['sessionname']]['login_ad'])and($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']==''))
  and
 (($user_ad!=$_SESSION[$GLOBALS['sessionname']]['login_ad'])and($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!=''))
 )
 {
	 echo 'Jogosultság hiba2!';
	 exit;
 }
}elseif(
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user')
  and
 (!keres_jovahagyo_vanejogom_szerv($user_ad))
){//Jóváhagy
//Meg kell nézni, hogy van-e jóvéhagyási jogom erre a userre.
	 echo 'Jogosultság hiba!';
	 exit;
}elseif(
 ($_POST['mod_egyedi']=='xlsx_export_akt_user')
 and
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user')
 ){//Ilyen nem lehet
	 echo 'Általános jogosultság hiba!';
	 exit;
}elseif(
 ($_POST['mod_egyedi']!='xlsx_export_akt_user')
 and
 ($_POST['mod_egyedi']!='xlsx_export_jovahagy_user')
 ){
	echo 'Általános rendszer jogosultság hiba!';
	exit;
}
//Jogosultság kezelés - vége

$tomb_mentve=keres_rogzit_egyho($user_ad,$ev,$ho);
$tomb_user=keres_mit1('mira_user','user_ad',$user_ad);

if($ho>10)
 $ev2=$ev.'_'.$ho;
else
 $ev2=$ev."_0".$ho;

$date=date("Y_m_d-H_i_s",time());
$filename_alap=$GLOBALS['rend_nev']." statisztika ".$tomb_user['0']['user_nev']." ".$ev2." rögzítése ".$date;
$filename=$filename_alap.".xlsx";

/*echo '<pre>';
print_r($tomb_mentve);
echo '</pre>';*/

 $adat=array();
 //$szerv_nev=keres_mit1_mit1_csak_ertek('mira_szerv','szerv_id',$tomb_user['0']['szerv_id'],'szerv_nev');
  $i=0;
  $adat[$i][]='<b>Név</b>';
  $adat[$i][]='<b>AD azonosító</b>';
  $adat[$i][]='<b>Törzsszám</b>';
  $adat[$i][]='<b>Email cím</b>';
  $adat[$i][]='<b>Szervezet</b>';
  $adat[$i][]='<b>Tevékenység neve</b>';
  $adat[$i][]='<b>Dátum</b>';
  $adat[$i][]='<b>Rögzített munkaidő</b>';
  $adat[$i][]='<b>Rögzített munkaidő - egészszám</b>';
  $adat[$i][]='<b>Rögzített munkaidő - óra</b>';
  $adat[$i][]='<b>Rögzített munkaidő - perc</b>';
  $adat[$i][]='<b>Rögzítés ideje</b>';
  $adat[$i][]='<b>Rögzítő megjegyzése</b>';
  $adat[$i][]='<b>Rögzítő tevékenység megjegyzése</b>';
  
if(
(is_array($tomb_user))and
(is_array($tomb_mentve))and
(is_array($tomb_mentve['adat']))
){

 foreach($tomb_mentve['adat'] as $nap => $tomb_tmp){
 foreach($tomb_tmp as $projekt_id => $ert){
  $i++;

  $adat[$i][]=$tomb_user['0']['user_nev'];
  $adat[$i][]=$tomb_user['0']['user_ad'];
  $adat[$i][]=$tomb_user['0']['user_tsz'];
  $adat[$i][]=$tomb_user['0']['user_email'];
  
  //$adat[$i][]=$szerv_nev;//szervezet nev
  $adat[$i][]=$tomb_mentve['nap_foadat'][$nap]['szerv_nev'];//szervezet nev
  
  $adat[$i][]=$ert['projekt_nev'];
  
  //$adat[$i][]=str_replace("-",".",$nap).'.';
  $adat[$i][]=$nap;
  
 if($ert['rogzit_perc']<10)
  $perc='0'.$ert['rogzit_perc'];
 else
  $perc=$ert['rogzit_perc'];
  $adat[$i][]=$ert['rogzit_ora'].':'.$perc;//8:01
  
  //egész óra eleje
   $egeszzam_ora=$ert['rogzit_ora'];
   $egeszzam_ora+=$ert['rogzit_perc']/60;
   $adat[$i][]=round($egeszzam_ora,2);////8,01
  //egész óra vége
  
  $adat[$i][]=$ert['rogzit_ora'];//8,01
  $adat[$i][]=$ert['rogzit_perc'];//8,01
  //$adat[$i][]='<style nf="YYYY-mm-dd hh:mm:ss">'.$ert['rogzit_sor_update_time'].'</style>';
  
  $ert['rogzit_sor_update_time']=str_replace("-",".",$ert['rogzit_sor_update_time']);
  $adat[$i][]="\0".$ert['rogzit_sor_update_time'];
  //$adat[$i][]='<style nf="yyyy.mm.dd hh:mm:ss">'.$ert['rogzit_sor_update_time'].'</style>';
  
  //$adat[$i][]=$ert['rogzit_megj'];
  $adat[$i][]=$tomb_mentve['nap_foadat'][$nap]['rogzit_megj'];
  
  $adat[$i][]=$ert['rogzit_sor_megj_adat'];

 }
 }
 

}


 unset($tomb_mentve);
 unset($tomb_user);
 $xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));

}
?>

<?php

function tig_kezdveg_hokitalal($ev_most,$ho_ig,$tomb,$elso_modositas,$utolso_modositas){
//Kezdő és vége hó kitalálása
//Eleje	AB oszlop az eleje, ha az üres, akkor az U. Első módosítás kell figyelmbe venni
//Vége	AC-AD-AE ilyen sorrendben. Utolsó módosítást kell figyelembe venni
//Vége	AD-AC-AE ilyen sorrendben. Utolsó módosítást kell figyelembe venni

/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
*/
$ret=array();

$ab=$tomb[$elso_modositas]['ab'];
$u=$tomb[$elso_modositas]['u'];
$ac=$tomb[$utolso_modositas]['ac'];
$ad=$tomb[$utolso_modositas]['ad'];
$ae=$tomb[$utolso_modositas]['ae'];

$kezd=$veg='';

//Kezdő
//echo 'id: '.$szerz_tetel_id.','.$u.'-';
 if($u!=''){
  $u_ev=(int)substr($u,0,4);
  $ret['tulfutas_nincs_u']=0;
 }else{
  $u_ev='0000';
  $ret['tulfutas_nincs_u']=1;
 }
 if($ev_most>$u_ev){//Kezdő év korábbi mint a mai, akkor január
  $kezd=1;
  }elseif($ev_most==$u_ev){//Kezdő év a mai, akkor a kezdő hó ez, különben üres, kimarad..
   $kezd=(int)substr($u,5,2); 
  }



//Vége
//Vége év meghatározása
if($ad!='')$veg_ev=(int)substr($ad,0,4);
elseif($ac!='')$veg_ev=(int)substr($ac,0,4);
elseif($ae!='')$veg_ev=(int)substr($ae,0,4);
else $veg_ev=$ev_most;

if($veg_ev<$ev_most){
 $kezd=$veg='';
}elseif($veg_ev>$ev_most){//Ha a vége év későbbi mint a mostani év
 $veg=12;
}else{//Ha az aktuális év a véges
 if($ad!='') $veg=(int)substr($ad,5,2);
 else if($ac!='') $veg=(int)substr($ac,5,2);
 else if($ae!='') $veg=(int)substr($ae,5,2);
 else $veg=12;
}


//Biztonsági ellenőrzés, hogy ne legyen hiba, túlfotás
if($kezd>$veg){
 $kezd=$veg;
 $ret['tulfutas']=1;
}else{
 $ret['tulfutas']=0;
}

if($ho_ig<$veg){
 $veg=$ho_ig;
}

/*
echo 'Kezd: '.$kezd;
echo 'Vég: '.$veg;
exit;
*/

/*
echo 'aa: '.$aa.'<br>';
echo 'u: '.$u.'<br>';
echo 'Kezd: '.$kezd.'<br>';
echo 'ab: '.$ab.'<br>';
echo 'ac: '.$ac.'<br>';
echo 'ad: '.$ad.'<br>';
echo '<br>';
echo ' Vég: '.$veg;
exit;
*/


$ret['kezd']=$kezd;
$ret['veg']=$veg;
$ret['adat']['ab']=$ab;
$ret['adat']['u']=$u;
$ret['adat']['ac']=$ac;
$ret['adat']['ad']=$ad;
$ret['adat']['ae']=$ae;
return $ret;
}

function projekt_osszead($projekt_id_tomeges){
if($projekt_id_tomeges!=''){
$tomb_projekt_id=explode(',',$projekt_id_tomeges);
$ret=0;
foreach($tomb_projekt_id as $projekt_id){
 if(isset($GLOBALS['tigtabla_proj33'][$projekt_id]))$ret+=$GLOBALS['tigtabla_proj33'][$projekt_id];
}
if($ret!=0) return $ret;
else return '';
}else return '';
}
?>
<?php

function honap_elso_munkanapja_mavane($tagv){
$ma_nap=date("j",time());//d(01) helyett j(1)
$ma_ev=date("Y",time());//01 hó
$ma_ho=date("m",time());//01 hó
$ma_evho=$ma_ev."-".$ma_ho;//01 hó
$ma=date("Y-m-d",time());//d(01) helyett j(1)

$ho_elso_munkanap="";
$munkanap_athelyezesek=keres_munkanap_ho_athelyezesek($tagv,$ma_evho);
//Végigmegyünk a napokon, megnézzük melyik az első munkanap
for($i=1;$i<=$ma_nap;$i++){
 if($i<10)$i_n="0".$i;
 else $i_n=$i;
 $vizsg_nap=$ma_evho."-".$i_n;
 $vizsg_time=mktime("1","1","1",$ma_ho,$i,$ma_ev);
 $naptipus=date("N",$vizsg_time);//1 hétfő, 7 vasárnap
 
 if(isset($munkanap_athelyezesek[$i])){//Ekkor van áthelyezés
	 if((($naptipus==6)or($naptipus==7))
	 and($munkanap_athelyezesek[$i]=="MN")and($ho_elso_munkanap=="")
	 ){
		$ho_elso_munkanap=$i; 
	 }elseif(
	  (($naptipus==1)or($naptipus==2)or($naptipus==3)or($naptipus==4)or($naptipus==5))
	  and($munkanap_athelyezesek[$i]=="MN")and($ho_elso_munkanap=="")
	 ){
	   $ho_elso_munkanap=$i;
	 }
 }elseif(
 ($ho_elso_munkanap=="")and
 (($naptipus==1)or($naptipus==2)or($naptipus==3)or($naptipus==4)or($naptipus==5))
 ){//Ha nincs áthelyezés, és hétköznap, akkor ez munkanap
   $ho_elso_munkanap=$i; 
 }
}
if(($ho_elso_munkanap!="")and($ho_elso_munkanap==$ma_nap)){
 return true;
}else{
 return false;
}
}

/*
function ma_munkanap_e($tagv){

$ma=date("Y-m-d",time());//d(01) helyett j(1)
$naptipus=date("N",time());//1 hétfő, 7 vasárnap
//echo $ma;

$tomb=keres_mit2_mit1("munkanap","munkanap_tagv",$tagv,"munkanap",$ma,"munkanap_tipus");

print_r($tomb);

return true;
}
*/

function email_nincs_lezarva_kikuld($tagv,$ev_ho){
$tomb_user=keres_user_nincs_lezarva($tagv,$ev_ho);
$tmp_ev=explode("-",$ev_ho);
$ev=$tmp_ev[0];
$ho=$tmp_ev[1];

chdir('../');
//echo getcwd() . "\n";
//$cimtargy="MIRA".$GLOBALS['tesztdevmod']." ".$ev.". ".ho_ki($ho)." hónap nincs lezárva";
$cimtargy=$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']." ".$ev.". ".ho_ki($ho)." hónap nincs lezárva";
foreach($tomb_user as $ert){
 $cimzes[0]['nev']=$ert['user_nev'];
 $cimzes[0]['email']=$ert['user_email'];
 $level_html="Kedves ".$ert['user_nev']."!";
 //$level_html.="<br><br>".$ev.". ".ho_ki($ho)." hónapod nincs lezárva a <a href='".$GLOBALS['url']."'>MIRA".$GLOBALS['tesztdevmod']."</a> rendszerben";
 $level_html.="<br><br>".$ev.". ".ho_ki($ho)." hónapod nincs lezárva a <a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."</a> rendszerben";
 $level_html.="<br><br>Kérlek, lépj be a rendszerbe és végezd el a szükséges lezárást!";
 mail_passrec_uj($cimtargy,$cimzes,$level_html,"");
}
}

function keres_user_nincs_lezarva($tagv,$ev_ho){
$eredmeny_keres="";
$sql="SELECT mira_user.user_nev,mira_user.user_email
FROM `mira_user`
left join rogzit_ho ON 
	rogzit_ho.user_ad = mira_user.user_ad and
	rogzit_ho.rogzit_ho = '".$ev_ho."'
where 
 mira_user.user_tagv='".$tagv."' and 
 mira_user.user_inaktiv='0' and 
 mira_user.ful_rogzit ='1' 
 
 and (
mira_user.user_kezd_date='0000-00-00'
or
mira_user.user_kezd_date<='".$ev_ho."-31'
)
 
and (
mira_user.user_veg_date='0000-00-00'
or
mira_user.user_veg_date>='".$ev_ho."-01'
)

 and(
(rogzit_ho.rogzit_ho_id is NULL)
or
(rogzit_ho.ellenorzesre_lezarva='0')
)";
//echo $sql;exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_munkanap_ho_athelyezesek($tagv,$ho){
 $eredmeny_keres="";
 $sql="SELECT  DATE_FORMAT( munkanap, '%e' ) AS nap,munkanap_tipus 
 FROM `munkanap` 
 where 
 `munkanap_tagv`='".$tagv."' 
 and `munkanap` like '".$ho."%'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['nap']]=$adatom['munkanap_tipus'];
 }
 return $eredmeny_keres;
}
?>
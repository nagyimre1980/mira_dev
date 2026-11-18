<?php

function keres_ma_munkanape($ev,$ho,$nap,$tomb3_munkanap_global){
//Adott nap munkanap-e, csak globálisan. Haigen true, amugy false

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;
if($nap<10)$nap2='0'.$nap;
else $nap2=$nap;
$tdate=$ev.'-'.$ho2.'-'.$nap2;
$het_napja=date('w',strtotime($tdate));

 if(
 (
  (
   (!isset($tomb3_munkanap_global[$nap]))and($het_napja!=0)and($het_napja!=6)
  )
  or
  (
   (isset($tomb3_munkanap_global[$nap]))and
   ($tomb3_munkanap_global[$nap]=='MN')
  )
 )
 ){
	return true;
 }else{
	return false;
 }
}

function keres_most_munkanap($ev,$ho,$nap_eddig,$tomb3_munkanap_global){
//Adott hónapban ez hányadik munkanap

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;

$ev2=$ev.'-'.$ho2;
$date=$ev2.'-01';
$honap_utolso_napja = date('t',strtotime($date));

$most_munkanap=0;
for($nap=1;$nap<=$nap_eddig;$nap++){
 if($nap<10)$nap2='0'.$nap;
 else $nap2=$nap;
 $tdate=$ev2.'-'.$nap2;
 $het_napja=date('w',strtotime($tdate));
 
  if(
 (
  (
   (!isset($tomb3_munkanap_global[$nap]))and($het_napja!=0)and($het_napja!=6)
  )
  or
  (
   (isset($tomb3_munkanap_global[$nap]))and
   ($tomb3_munkanap_global[$nap]=='MN')
  )
 )
 ){
	 $most_munkanap++;
 }
 
}
return $most_munkanap;
}

function keres_vissza_munkanap($ev,$ho,$nap_eddig,$tomb3_munkanap_global){
//Adott hónapban ez a nap visszafelé hányadik munkanap
//Ha 31 napos a hónap és 31 munkanap, akkor 31. futtatva ez 0 nap

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;

$ev2=$ev.'-'.$ho2;
$date=$ev2.'-01';
$honap_utolso_napja = date('t',strtotime($date));

/*echo '<pre>';
print_r($tomb3_munkanap_global);
echo '</pre>';*/

$vissza_munkanap=0;
for($nap=$honap_utolso_napja;$nap>=$nap_eddig;$nap--){
 if($nap<10)$nap2='0'.$nap;
 else $nap2=$nap;
 $tdate=$ev2.'-'.$nap2;
 $het_napja=date('w',strtotime($tdate));
 
 if(
 (
  (
   (!isset($tomb3_munkanap_global[$nap]))and($het_napja!=0)and($het_napja!=6)
  )
  or
  (
   (isset($tomb3_munkanap_global[$nap]))and
   ($tomb3_munkanap_global[$nap]=='MN')
  )
 )
 ){
	 $vissza_munkanap++;
 }
 
}

return $vissza_munkanap;
}

function keres_user_max($ev,$ho,$nap_vege,$tomb,$tomb2_munkanap_user,$tomb3_munkanap_global){//User-hez az adott hónapban max kitölthető munkaidőt számolja

/*
echo '<pre>';
print_r($tomb2_munkanap_user);
print_r($tomb3_munkanap_global);
echo '</pre>';
*/

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;

$ev2=$ev.'-'.$ho2;
$date=$ev2.'-01';
$honap_utolso_napja = date('t',strtotime($date));
$global_munkanapszam=0;
$tomb_global_munkanap=array();
for($nap=$honap_utolso_napja;$nap>=1;$nap--){
 
 //Ha van a usernek kivétele
 if((isset($tomb3_munkanap_global[$nap]))and($tomb3_munkanap_global[$nap]=='MN')){
  $global_munkanapszam++;
  $tomb_global_munkanap[$nap]='MN';
 }elseif(
  (!isset($tomb3_munkanap_global[$nap]))
  or
  (
   (isset($tomb3_munkanap_global[$nap]))and
   $tomb3_munkanap_global[$nap]!='PN'
  )
 ){
  if($nap<10)$nap2='0'.$nap;
  else $nap2=$nap;
  $tdate=$ev2.'-'.$nap2;
  $het_napja=date('w',strtotime($tdate));
  if( ($het_napja!=0)and($het_napja!=6) ){
   $global_munkanapszam++; 
   $tomb_global_munkanap[$nap]='MN';
  }else{//szombat vasárnap ekkor pihenőnap!
	 $tomb_global_munkanap[$nap]='PN'; 
  }
 }else{
	 $tomb_global_munkanap[$nap]='PN';
 }
 
}


if(is_array($tomb)){
foreach($tomb as $user_ad =>$ert){

$tomb_user_munkanap=array();
$tomb_user_munkanap=$tomb_global_munkanap;
	
 if(isset($tomb2_munkanap_user[$user_ad])){
  foreach($tomb2_munkanap_user[$user_ad] as $nap_user => $tipus){
   if(isset($tomb_user_munkanap[$nap_user])){//ki tudja...
	   if($tipus!=$tomb_user_munkanap[$nap_user]){
		   $tomb_user_munkanap[$nap_user]=$tipus;
	   }
   }

  }
 }


   //Munkakezdés lekezelése - eleje
   if(($ert['kezd_date_ho']==$ev2)
	   and($ert['kezd_date_nap']!='0')
	   and($ert['kezd_date_nap']>0)
	   and($ert['kezd_date_nap']<32)
   ){//Ha ebben a hónapban kezdett, akkor a kezdés előtt Ő pihenőnapos
	   $kezd_nap=$ert['kezd_date_nap'];
	   for($i=$ert['kezd_date_nap'];$i>0;$i--){
		  if($i!=$ert['kezd_date_nap']){
		   $tomb_user_munkanap[$i]='PN';
		  }
	   }
   }
   //Munkakezdés lekezelése - vége

   //Munkavége lekezelése - eleje
   if(($ert['veg_date_ho']==$ev2)
	   and($ert['veg_date_nap']!='0')
	   and($ert['veg_date_nap']>0)
	   and($ert['veg_date_nap']<32)
   ){//Ha ebben a hónapban végzett, akkor a kezdés után Ő pihenőnapos
	   
	   for($i=$ert['veg_date_nap'];$i<=31;$i++){
		  if($i!=$ert['veg_date_nap']){
		   $tomb_user_munkanap[$i]='PN';
		  }
	   }
   }
   //Munkavége lekezelése - vége

//nap_vege - eleje
if($nap_vege!=''){
 for($i=$nap_vege;$i<=31;$i++){
  $tomb_user_munkanap[$i]='PN';
 }
}
//nap_vege - vége

$user_munkanapszam=keres_munkanap_szamol($tomb_user_munkanap);

/*
if($user_ad=='f9594'){
	echo '<pre>';
	print_r($tomb_user_munkanap);
	echo '</pre>';
	echo $user_munkanapszam;
	exit;
}
*/

//maxido>8 akkor a munkaidő 8 óra.
//Minden más esetben a munkaidő a maxido értéke.
if($ert['maxido']>8){
 $havi_munkaido=$user_munkanapszam*8;
}else{
 $havi_munkaido=$user_munkanapszam*$ert['maxido'];
}

$tomb[$user_ad]['munkanapszam']=$user_munkanapszam;
$tomb[$user_ad]['munkaido']=$havi_munkaido;

/*
echo 'Havi munkanapok száma: '.$user_munkanapszam;
echo '<br>';
echo 'Havi munkaidő: '.$havi_munkaido;
echo '<pre>';
print_r($ert);
print_r($tomb_user_munkanap);
echo '</pre>';
exit; 
*/



}
}

return $tomb;
}

function keres_munkanap_szamol($tomb_user_munkanap){//Visszaadja, hogy az adott tombben mennyi a MN száma
$user_munkanapszam=0;
foreach($tomb_user_munkanap as $tipus){
 if($tipus=='MN'){
	 $user_munkanapszam++;
 }
}
return $user_munkanapszam;
}

function keres_nincs_kitoltve_alapadat($ev,$ho,$nap_vege){
$eredmeny_keres="";

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;
$ev_ho=$ev.'-'.$ho2;

if($nap_vege<10)$nap_vege2='0'.$nap_vege;
else $nap_vege2=$nap_vege;
//
//GROUP_CONCAT(user_jogcimcsop.tagv,\'-\', jogcimcsop.jogcimcsop_kod ORDER BY jogcimcsop.jogcimcsop_kod ASC SEPARATOR  \'; \') as jogcimcsop_kod
/*
mira_user_ker_jog.user_napi_ido_max_ora,
mira_tagv.napi_ido_max_ora,

sum(rogzit_sor.rogzit_ora),
sum(rogzit_sor.rogzit_perc),

GROUP_CONCAT(munkanap_user.munkanap,'-', munkanap_user.munkanap_tipus SEPARATOR  '; ') as munkanap
*/
//mira_user.user_kezd_date,
//mira_user.user_veg_date,
$sql="SELECT 
mira_user.user_ad,
mira_user.user_nev,
mira_user.user_email,

DATE_FORMAT( mira_user.user_kezd_date, '%Y-%m' ) AS kezd_date_ho,
DATE_FORMAT( mira_user.user_veg_date, '%Y-%m' ) AS veg_date_ho,
DATE_FORMAT( mira_user.user_kezd_date, '%e' ) AS kezd_date_nap,
DATE_FORMAT( mira_user.user_veg_date, '%e' ) AS veg_date_nap,


sum(rogzit_sor.rogzit_ora) as rogzit_ora,
sum(rogzit_sor.rogzit_perc) as rogzit_perc,
mira_user_ker_jog.user_napi_ido_max_ora,
mira_tagv.napi_ido_max_ora,
rogzit_ho.ellenorzesre_lezarva

FROM `mira_user` 
left join rogzit ON rogzit.user_ad = mira_user.user_ad
	and rogzit.rogzit_ho = '".$ev_ho."' ";
if($nap_vege2!=''){
 $sql.=" and rogzit.rogzit_nap < '".$ev_ho."-".$nap_vege2."'";
}

$sql.=" left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
left join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad
left join mira_tagv ON mira_tagv.tagv = mira_user.user_tagv 
left join rogzit_ho On rogzit_ho.user_ad = mira_user.user_ad
	and rogzit_ho.rogzit_ho='".$ev_ho."'
where
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


group by mira_user.user_ad
order by mira_user.user_nev asc 
";
//and mira_user.user_ad='d3933'
//and mira_user.user_ad='a2675'
//and mira_user.user_ad='ff6425'
//echo $sql;exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]['nev']=$adatom['user_nev'];
  $eredmeny_keres[$adatom['user_ad']]['email']=$adatom['user_email'];
  $eredmeny_keres[$adatom['user_ad']]['lezarva']=$adatom['ellenorzesre_lezarva'];
  
  $eredmeny_keres[$adatom['user_ad']]['kezd_date_ho']=$adatom['kezd_date_ho'];
  $eredmeny_keres[$adatom['user_ad']]['veg_date_ho']=$adatom['veg_date_ho'];
  
  $eredmeny_keres[$adatom['user_ad']]['kezd_date_nap']=$adatom['kezd_date_nap'];
  $eredmeny_keres[$adatom['user_ad']]['veg_date_nap']=$adatom['veg_date_nap'];
  
  if(($adatom['user_napi_ido_max_ora']!='')and($adatom['user_napi_ido_max_ora']!='0')){
	$eredmeny_keres[$adatom['user_ad']]['maxido']=$adatom['user_napi_ido_max_ora'];
  }else{
	$eredmeny_keres[$adatom['user_ad']]['maxido']=$adatom['napi_ido_max_ora'];
  }
  
  $eredmeny_keres[$adatom['user_ad']]['ora']=round( ( $adatom['rogzit_ora'] + ($adatom['rogzit_perc']/60) ),2);
 }
 return $eredmeny_keres;
}

function keres_nincs_kitoltve_kitoltheto($ev,$ho){
$eredmeny_keres="";

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;
$ev_ho=$ev.'-'.$ho2;

$sql=" SELECT 
mira_user.user_ad,

 DATE_FORMAT(munkanap_user.munkanap, '%e' ) as munkanap,
 munkanap_user.munkanap_tipus
FROM `mira_user` 

inner join munkanap_user ON munkanap_user.user_ad = mira_user.user_ad
 and munkanap_user.munkanap like '".$ev_ho."%'
where
 mira_user.user_inaktiv='0' and 
 mira_user.ful_rogzit ='1' 
";
//
//echo $sql;exit;

  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
    $eredmeny_keres[$adatom['user_ad']][$adatom['munkanap']]=$adatom['munkanap_tipus'];
 }
 return $eredmeny_keres;
}

function keres_munkanap_ho_athelyezesek($ev,$ho){
$eredmeny_keres="";

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;
$ev_ho=$ev.'-'.$ho2;

 $sql="SELECT DATE_FORMAT( munkanap, '%e' ) AS nap,munkanap_tipus 
 FROM `munkanap` 
 where 
 `munkanap` like '".$ev_ho."%'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['nap']]=$adatom['munkanap_tipus'];
 }
 return $eredmeny_keres;
}

function keres_nincs_kitoltve_jovhagyok_fel(){
$eredmeny_keres="";

$sql="SELECT
mira_user.user_ad,
mira_user_fel_jo.user_ad as jova_user_ad,
mira_user_fel_jo.user_nev as jova_user_nev,
mira_user_fel_jo.user_email as user_email
FROM `mira_user` 

left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad = mira_user.user_ad
inner join mira_user as mira_user_fel_jo ON mira_user_fel_jo.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo 
	and mira_user_fel_jo.user_inaktiv='0'
	and mira_user_fel_jo.ful_jovahagy='1'
where
 mira_user.user_inaktiv='0' and 
 mira_user.ful_rogzit ='1' 
";

 //echo $sql;exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']][$adatom['jova_user_ad']]['email']=$adatom['user_email'];
  $eredmeny_keres[$adatom['user_ad']][$adatom['jova_user_ad']]['nev']=$adatom['jova_user_nev'];
 }
return $eredmeny_keres;
}

function keres_nincs_kitoltve_jovhagyok_szerv(){
$eredmeny_keres="";

$sql="SELECT
mira_user.user_ad,
mira_user.user_nev,
mira_user_szerv_jo.user_ad as jova_user_ad,
mira_user_szerv_jo.user_nev as jova_user_nev,
mira_user_szerv_jo.user_email as user_email
FROM `mira_user` 


inner join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_user.szerv_id 
inner join mira_user as mira_user_szerv_jo ON mira_user_szerv_jo.user_ad = mira_szerv_jovahagyo.user_ad 
	and mira_user_szerv_jo.user_inaktiv='0' 
	and mira_user_szerv_jo.ful_jovahagy='1'

where
 mira_user.user_inaktiv='0' and 
 mira_user.ful_rogzit ='1' 
 

";
//Így a felettesek nem jönnek le, igazából lejöhet, majd később kezeljük.
//left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad = mira_user.user_ad
// and mira_user_felettes_jovahagyo.user_ad is null
 //echo $sql;exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']][$adatom['jova_user_ad']]['email']=$adatom['user_email'];
  $eredmeny_keres[$adatom['user_ad']][$adatom['jova_user_ad']]['nev']=$adatom['jova_user_nev'];
 }
return $eredmeny_keres;
}

function keres_nincs_jovahagyva_alapadat($ev,$ho,$nap_vege){
$eredmeny_keres="";

if($ho<10)$ho2='0'.$ho;
else $ho2=$ho;
$ev_ho=$ev.'-'.$ho2;

if($nap_vege<10)$nap_vege2='0'.$nap_vege;
else $nap_vege2=$nap_vege;

$sql="SELECT 
mira_user.user_ad,
mira_user.user_nev,

DATE_FORMAT( mira_user.user_kezd_date, '%Y-%m' ) AS kezd_date_ho,
DATE_FORMAT( mira_user.user_veg_date, '%Y-%m' ) AS veg_date_ho,
DATE_FORMAT( mira_user.user_kezd_date, '%e' ) AS kezd_date_nap,
DATE_FORMAT( mira_user.user_veg_date, '%e' ) AS veg_date_nap,


sum(rogzit_sor.rogzit_ora) as rogzit_ora,
sum(rogzit_sor.rogzit_perc) as rogzit_perc,
mira_user_ker_jog.user_napi_ido_max_ora,
mira_tagv.napi_ido_max_ora,

rogzit_ho.ellenorzesre_lezarva

FROM `mira_user` 
left join rogzit ON rogzit.user_ad = mira_user.user_ad
	and rogzit.rogzit_ho = '".$ev_ho."' ";
if($nap_vege2!=''){
 $sql.=" and rogzit.rogzit_nap < '".$ev_ho."-".$nap_vege2."'";
}

$sql.="

left join rogzit_ho On rogzit_ho.user_ad = mira_user.user_ad
	and rogzit_ho.rogzit_ho='".$ev_ho."' 
left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
left join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad
left join mira_tagv ON mira_tagv.tagv = mira_user.user_tagv 
where
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

and ( 
 (rogzit_ho.ellenorzesre_ok='0')or
(rogzit_ho.ellenorzesre_ok is null)
)

group by mira_user.user_ad 
order by mira_user.user_nev asc
";

//echo $sql;exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
    $eredmeny_keres[$adatom['user_ad']]['nev']=$adatom['user_nev'];
    $eredmeny_keres[$adatom['user_ad']]['lezarva']=$adatom['ellenorzesre_lezarva'];
	
	  $eredmeny_keres[$adatom['user_ad']]['kezd_date_ho']=$adatom['kezd_date_ho'];
  $eredmeny_keres[$adatom['user_ad']]['veg_date_ho']=$adatom['veg_date_ho'];
  
  $eredmeny_keres[$adatom['user_ad']]['kezd_date_nap']=$adatom['kezd_date_nap'];
  $eredmeny_keres[$adatom['user_ad']]['veg_date_nap']=$adatom['veg_date_nap'];
  
  if(($adatom['user_napi_ido_max_ora']!='')and($adatom['user_napi_ido_max_ora']!='0')){
	$eredmeny_keres[$adatom['user_ad']]['maxido']=$adatom['user_napi_ido_max_ora'];
  }else{
	$eredmeny_keres[$adatom['user_ad']]['maxido']=$adatom['napi_ido_max_ora'];
  }
  
  $eredmeny_keres[$adatom['user_ad']]['ora']=round( ( $adatom['rogzit_ora'] + ($adatom['rogzit_perc']/60) ),2);
 }
return $eredmeny_keres;
}




/*
function igaze_munknap_hovege_elott($munkanap_hovege_elott,$ev,$ho,$nap){
$evho=$ev."-".$ho;//01 hó

$ho_utolso_nap=date('t',strtotime($evho.'-01'));

$munkanap_athelyezesek=keres_munkanap_ho_athelyezesek('KONT',$evho);

echo $ho_utolso_nap;
}
*/

function mail_passrec_uj_auto($targy,$cimzes,$masolat,$level_html,$file,$css){
if((isset($GLOBALS['mail_tilt']))and($GLOBALS['mail_tilt']=="1")) return true;
/* használat:
$level_html="Alma<b>Vastag</b> Árvíztűrő tükörfúrógép";
$targy="Árvíztűrő tükörfúrógép";

$cimzes[0]['nev']="Nagy Imre";
$cimzes[0]['email']="nagy.imre@nusz-zrt.hu";
$cimzes[1]['nev']="KONTO-IT";
$cimzes[1]['email']="konto-it@mvm.hu";

$file[0]['nev']="Árvíztűrő tükörfúrógép_átnevezve.txt";
$file[0]['utv']="file/Árvíztűrő tükörfúrógép.txt";


mail_passrec_uj($targy,$cimzes,$level_html,$file);
*/

//$level_html.="<br><br>Ez egy automatikusan generált e-mail, kérjük ne válaszoljon rá.";
$level_html.="<br><br>Ez egy rendszer által generált üzenet, azonban kérdés esetén nyugodtan válaszolj rá és felvesszük Veled a kapcsolatot.";
//$level_html.="<br><br>Üdvözlettel,<br>MVMS GIG<br>
$level_html.="<br><br>Üdvözlettel,<br>".$GLOBALS['rend_emailfelado_udv_str']."<br>
<a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev']." ".$GLOBALS['rend_str']."</a>
<br><img src='cid:logoimg'>";

$level_sima=strip_tags($level_html);
//include_once("ajax_mail_uj.php");
//$mail = new PHPMailer();//régi 5.x

//include_once("a11jax_mail_uj606.php");
//include_once("a111jax_mail_uj616.php");
include_once('../'.$GLOBALS['phpmailer_akt']);
$mail = new PHPMailer\PHPMailer\PHPMailer;  //új 6.x

//include_once("plugin/phpmailer/class.phpmailer.php");

 //$mail->From     = "nuszwebir@nusz-zrt.hu";                // Feladó e-mail címe  
 $mail->From     = $GLOBALS['rend_emailfelado'];                // Feladó e-mail címe  
 //$mail->FromName = "NUSZWEBIR ".$GLOBALS['tesztdevmod']."";		// Feladó neve  
 $mail->FromName = $GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."";		// Feladó neve  

// Számláló inicializálása a hozzáadott címek követésére
$hozzaadott_cimek_szama = 0;

foreach($cimzes as $ert){
 if(
 (($ert['email']!="")and($ert['nev']!=""))and
 (!preg_match('/^nan\d+@mvm\.hu$/i', trim($ert['email'])))
 ){
  $mail->AddAddress($ert['email'],$ert['nev']);   // Címzett és neve 
  $hozzaadott_cimek_szama++; // Növeljük a számlálót, mert lett egy érvényes cím
 }
}

// Kilépés a függvényből, ha a szűrések után nem maradt kinek elküldeni
if($hozzaadott_cimek_szama === 0){
    // Opcionális: Belerakhatsz valamilyen naplózást (logolást) is ide, ha tudni akarod, hogy ez megtörtént
    return false; // A függvény futása itt megáll, a $mail->Send() már nem hívódik meg
}

if(is_array($masolat)){
 foreach($masolat as $ert){
  //if(($ert['email']!="")and($ert['nev']!=""))
  if(
 (($ert['email']!="")and($ert['nev']!=""))and
 (!preg_match('/^nan\d+@mvm\.hu$/i', trim($ert['email'])))
 ){
   $mail->AddCC($ert['email'],$ert['nev']);// Címzett és neve
 }
 }
}

//$mail->AddAddress("schubert.endre@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("nagy.imre@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("rippert.gabor@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("nagy.imre@tolna.net","nAGY iMRE");               // Még egy címzett  

//$mail->AddReplyTo("nuszwebir@nusz-zrt.hu");  // Válaszlevél ide  
$mail->AddReplyTo($GLOBALS['rend_emailfelado']);  // Válaszlevél ide  
//$mail->Sender="nuszwebir@nusz-zrt.hu"; 
$mail->Sender=$GLOBALS['rend_emailfelado']; 

$mail->CharSet="UTF-8";
//$mail->Priority = 1; 

$mail->WordWrap = 50;                              // Sortörés állítása  

if(is_array($file)){
foreach($file as $ert){
 if((!isset($ert['nev']))or($ert['nev']==""))
	$ert['nev']=basename($ert['utv']); 
 $mail->AddAttachment($ert['utv'],$ert['nev']); // Csatolás más néven  
}
}

$mail->IsHTML(true);                            // Küldés HTML-ként
//$mail->AddEmbeddedImage('image/logok2.png', 'logoimg', 'logok2.png');
// $mail->AddEmbeddedImage('image/logok2016_f_nusz.png', 'logoimg', 'logok2016_f_nusz.png');
$mail->AddEmbeddedImage('../image/logok2022_nkmh.png', 'logoimg', 'logok2022_nkmh.png');

//$mail->Subject = "WFJOG - Igény érkezett";            // A levél tárgya  
$mail->Subject = $targy;            // A levél tárgya  
$mail->Body    = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html><head><TITLE>'.$GLOBALS['rend_nev'].'</TITLE><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">'.email_css_table($css).'</head><body>'.$level_html.'</body></html>';// A levél html tartalma  

//$mail->AltBody = $level_sima;     // A levél szöveges tartalma  

if(!$mail->Send()){
 echo "A levél nem került elküldésre";
 echo "A felmerült hiba: " . $mail->ErrorInfo;
 exit;
}
}


function email_css_table($css){
if($css!='1'){
return '';
}else{
return '
<style>
table.table_emre {
  font-family:Helvetica,Arial,sans-serif;
  font-family: "Times New Roman", Times, serif;
  font-size:15px;

  w1hite-space: nowrap;


white-space:nowrap;
overflow-x:auto;

table-layout:fixed;

border-spacing: 2px 2px;
w1idth: 200%;

margin:1px 0px 1px;
-webkit-box-shadow:0 0 5px #000;
-moz-box-shadow:0 0 5px #000;
box-shadow:1px 1px 5px #000;

}
table.table_emre td, table.table_emre th {
  border: 0px solid #AAAAAA;
  padding: 2px 4px;
  overflow: hidden;
  text-overflow: ellipsis;
}
table.table_emre thead {
  background: #EDBE74;
  background: #eeb151;
  background: -moz-linear-gradient(top, #f1ce97 0%, #eec482 66%, #EDBE74 100%);
  background: -webkit-linear-gradient(top, #f1ce97 0%, #eec482 66%, #EDBE74 100%);
  background: linear-gradient(to bottom, #f1ce97 0%, #eec482 66%, #EDBE74 100%);
  
  background: -moz-linear-gradient(top, #f1ce97 0%, #eec482 66%, #eeb151 100%);
  background: -webkit-linear-gradient(top, #f1ce97 0%, #eec482 66%, #eeb151 100%);
  background: linear-gradient(to bottom, #f1ce97 0%, #eec482 66%, #eeb151 100%);
  border-bottom: 2px solid #444444;
}
table.table_emre thead th {
  font-size: 15px;
  font-weight: bold;
  color: #C22A10;background: #EDBE74;
  color: #C22A10;background: #eeb151;
  color: #000000;background: #4ea1f3;
  color: #000000;background: #89c4fe;
  color: #000000;background: #b6d0f9;
 padding: 2px 2px;

}

table.table_emre tbody th{
text-align:left;
font-weight: bold;
}

table.table_emre tbody tr{
color: #000;
background: #ecf5ff;

font-size: 15px;

}

table.table_emre tr{
 height:10px;
}


.table_emre tr:hover{
    background-color:#90EE90;
}
</style>
';
}
}


function ho_ki($ho){
$ret='';
switch($ho)
{
 case'1':$ret='Január';break;
 case'2':$ret='Február';break;
 case'3':$ret='Március';break;
 case'4':$ret='Április';break;
 case'5':$ret='Május';break;
 case'6':$ret='Június';break;
 case'7':$ret='Július';break;
 case'8':$ret='Augusztus';break;
 case'9':$ret='Szeptember';break;
 case'10':$ret='Október';break;
 case'11':$ret='November';break;
 case'12':$ret='December';break;
}
return $ret;
}
?>
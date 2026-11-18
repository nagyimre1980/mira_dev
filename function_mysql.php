<?php

function keres_talszam($talszam){

if(isset($GLOBALS[$GLOBALS['sessionname']]['user_admin_muvelet']))
 $user_ker_jog='mira_user_ker_jog_admin';
else
 $user_ker_jog='mira_user_ker_jog';

//Talszám - eleje
if((isset($_POST[$talszam]))and($_POST[$talszam]!="")){
 $ret_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST[$talszam]);
 
 if($_POST[$talszam]<999999){//Excel export miatt
 //Ha változik, akkor le is kell menteni
 if($GLOBALS['mira']['user_jog'][$talszam]!=$ret_talszam){
   $tmp_mod=array();
   $tmp_mod[0][$talszam]=$ret_talszam;
   mod_egy_fel_tom($user_ker_jog,$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
 //be is kell állítani.
 $GLOBALS['mira']['user_jog'][$talszam]=$ret_talszam;
 }
}else{
 $ret_talszam=$GLOBALS['mira']['user_jog'][$talszam];
}
//Talszám - vége
return $ret_talszam;
}

function keres_order($order,$order_mod){

if(isset($GLOBALS[$GLOBALS['sessionname']]['user_admin_muvelet']))
 $user_ker_jog='mira_user_ker_jog_admin';
else
 $user_ker_jog='mira_user_ker_jog';

$ret_sql_order='';
if((isset($_POST['order']))and($_POST['order']!="")){
 if($_POST['order']==$GLOBALS['mira']['user_jog'][$order]){
  //Ekkor mező marad, és desc->asc vagy fordítva
  if($GLOBALS['mira']['user_jog'][$order_mod]=="desc")
	  $GLOBALS['mira']['user_jog'][$order_mod]="asc";
  else
	  $GLOBALS['mira']['user_jog'][$order_mod]="desc";
  
  //Ekkor order_mod kell lemeteni
   $tmp_mod=array();
   $tmp_mod[0][$order_mod]=$GLOBALS['mira']['user_jog'][$order_mod];
   mod_egy_fel_tom($user_ker_jog,$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);

 }else{//Ekkor a mező változott, rendezési mód marad
	$GLOBALS['mira']['user_jog'][$order]=$_POST['order'];
   
   //Le is kell menteni.
   $tmp_mod=array();
   $tmp_mod[0][$order]=$_POST['order'];
   mod_egy_fel_tom($user_ker_jog,$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
}
$ret_sql_order=' order by '.$GLOBALS['mira']['user_jog'][$order].' '.$GLOBALS['mira']['user_jog'][$order_mod].' ';
return $ret_sql_order;
}

function keres_user_login_helyettes(){
$eredmeny_keres="";
//	and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
$sql="select 
mira_user_helyettes.user_ad,
mira_user.user_nev
FROM mira_user_helyettes
inner join mira_user ON 
	mira_user.user_ad = mira_user_helyettes.user_ad 
	and mira_user.user_inaktiv='0'

where
mira_user_helyettes.user_ad_helyettes='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
order by mira_user.user_nev asc";
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_helyettes_bellithoz_user($user_ad,$keress_user_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_user_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
$talszam=keres_talszam('user_modhelyettes_keres_talszam');
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$talszam;

$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";

if($csakvan==1)
 $sql1.=" inner join mira_user_helyettes ON mira_user_helyettes.user_ad = mira_user.user_ad 
  and mira_user_helyettes.user_ad='".$user_ad."'";
 
$sql1.=" where ";
//$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
$sql1.=" mira_user.user_inaktiv='0'";
$sql1.=" and mira_user.ful_rogzit='1'";
 
if($keress_user_nev!="")//Csak ha rákerestek bármire
 $sql1.=" and mira_user.user_nev like '".$keress_user_nev."%'";

if($csakvan==1)
 $sql1.=" and mira_user_helyettes.user_ad_helyettes !='".$user_ad."'";
else
 $sql1.=" and mira_user.user_ad !='".$user_ad."'";

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 if($csakvan==1)
  $sql.=" inner join mira_user_helyettes ON mira_user_helyettes.user_ad_helyettes = mira_user.user_ad 
  and mira_user_helyettes.user_ad='".$user_ad."'";
 
 $sql.=" where ";
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.=" mira_user.user_inaktiv='0'";
 $sql.=" and mira_user.ful_rogzit='1'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_user.user_nev like '".$keress_user_nev."%'";

 $sql.=" and mira_user.user_ad !='".$user_ad."'";
 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;

}

function keres_rogzit_egyho($user_ad,$ev,$ho){
$eredmeny_keres="";
/*if($_SESSION[$GLOBALS['sessionname']]['ho_ki']<10)$ho="0".$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
else $ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];*/

if($ho<10)$ho="0".$ho;
else $ho=$ho;

/*
 rogzit.rogzit_jovahagyva,
 rogzit.rogzit_jovahagyva_ki,
 rogzit.rogzit_jovahagyva_mikor,
 rogzit.rogzit_jovahagyva_megj,
 
 mira_user_jovahagyo.user_nev as rogzit_jovahagyva_ki_nev,
 
 left join mira_user as mira_user_jovahagyo ON 
	mira_user_jovahagyo.user_ad = rogzit.rogzit_jovahagyva_ki
 
*/

$ido=$ev."-".$ho;
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT 
 rogzit.rogzit_nap,
 rogzit.tavollet,
 rogzit.rogzit_megj,
 
 rogzit_sor.projekt_id,
 rogzit_sor.rogzit_ora,
 rogzit_sor.rogzit_perc,
 
 projekt.projekt_nev,
 projekt.projekt_title,
 IF(rogzit_sor.rogzit_sor_megj is not null,1,0) as rogzit_sor_megj,
 rogzit_sor.rogzit_sor_megj as rogzit_sor_megj_adat,
 rogzit_sor.rogzit_sor_update_time,
 
 mira_szerv.szerv_nev
 FROM `rogzit` 
 left join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 left join projekt ON projekt.projekt_id = rogzit_sor.projekt_id
 where 
 rogzit.user_ad='".$user_ad."' and 
 rogzit.rogzit_nap like '".$ido."%' 
 order by rogzit.rogzit_nap,rogzit_sor.sorsz ASC";
 //order by rogzit.rogzit_nap,projekt.projekt_nev ASC";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
 if(
  ($adatom['tavollet']==1)
  or
  (
  ($adatom['tavollet']==0)
  //and($adatom['projekt_id']!="")
  )
  ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres['tavollet'][$adatom['rogzit_nap']]=$adatom['tavollet'];
  
  if($adatom['projekt_id']!=""){
  //$eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]=$adatom;
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_title']=$adatom['projekt_title'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_megj']=$adatom['rogzit_sor_megj'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_megj_adat']=$adatom['rogzit_sor_megj_adat'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_update_time']=$adatom['rogzit_sor_update_time'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_id']=$adatom['projekt_id'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_ora']=$adatom['rogzit_ora'];
   $eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }
  
  $eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['szerv_nev']=$adatom['szerv_nev'];
  $eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_megj']=$adatom['rogzit_megj'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva']=$adatom['rogzit_jovahagyva'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_ki']=$adatom['rogzit_jovahagyva_ki'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_ki_nev']=$adatom['rogzit_jovahagyva_ki_nev'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_mikor']=$adatom['rogzit_jovahagyva_mikor'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_megj']=$adatom['rogzit_jovahagyva_megj'];
  
 }
 }
 return $eredmeny_keres;
 
}

function keres_rogzit_id_egy($projekt_id,$nap){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);
 if($nap<10)$nap="0".$nap;
 $rogzit_nap=$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$_SESSION[$GLOBALS['sessionname']]['ho_ki']."-".$nap;
 
 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
 
 $sql="SELECT rogzit.rogzit_id
 FROM `rogzit` 
 inner join rogzit_sor ON rogzit_sor.rogzit_id =rogzit.rogzit_id
 where 
 rogzit.user_ad='".$user_ad."' and 
 rogzit.rogzit_nap='".$nap."' and 
 rogzit_sor.projekt_id = '".$projekt_id."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['rogzit_id'];
 }
 return $eredmeny_keres;
}

function keres_mit_munkanap_usertomb($ev,$ho,$tomb_user_ad){
$eredmeny_keres="";
if(is_array($tomb_user_ad)){
 $ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
 
 $where="";
 foreach($tomb_user_ad as $ert){
  $ert['user_ad']=mysqli_real_escape_string($GLOBALS['mysqli'],$ert['user_ad']);
  if($where!="")$where.="or";
  $where.="(`user_ad` = '".$ert['user_ad']."')";
 }
 $where_ad="(".$where.")and ";
 
 if($ho<10)$ho="0".$ho;
 $sql="SELECT munkanap_tipus, 
  DATE_FORMAT( munkanap, '%e' ) AS nap
 FROM `munkanap_user` 
 where 
 ".$where_ad."
 `munkanap` like '".$ev."-".$ho."%'";
 //print "<br>".$sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['nap']]=$adatom['munkanap_tipus'];
 }
}
 return $eredmeny_keres;
}

function keres_mit_munkanap_user($ev,$ho,$user_ad){
 $eredmeny_keres="";
 $ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 if($ho<10)$ho="0".$ho;
 $sql="SELECT munkanap_tipus, 
  DATE_FORMAT( munkanap, '%e' ) AS nap
 FROM `munkanap_user` 
 where 
 `user_ad` = '".$user_ad."' and 
 `munkanap` like '".$ev."-".$ho."%'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['nap']]=$adatom['munkanap_tipus'];
 }
 return $eredmeny_keres;
}

function keres_mit_munkanap($ev,$ho){
 $eredmeny_keres="";
 $ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
 if($ho<10)$ho="0".$ho;
 //`munkanap_tagv` = '".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and 
 $sql="SELECT munkanap_tipus, 
  DATE_FORMAT( munkanap, '%e' ) AS nap
 FROM `munkanap` 
 where 
 `munkanap` BETWEEN '".$ev."-".$ho."-01' AND '".$ev."-".$ho."-31'";
 //`munkanap` like '".$ev."-".$ho."%'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['nap']]=$adatom['munkanap_tipus'];
 }
 return $eredmeny_keres;
}

//Adott usernek hány aktív helyettese van! Adat is
function keres_userhelyettes_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_user_helyettes.user_ad_helyettes
 FROM `mira_user_helyettes` 
 inner join mira_user ON mira_user.user_ad = mira_user_helyettes.user_ad_helyettes
 where
 mira_user_helyettes.user_ad='".$user_ad."' and 
 mira_user.user_inaktiv='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad_helyettes']]=1;
 }
 return $eredmeny_keres;
}

//Adott userhez hány
function keres_riport_tipusjogspan_aljog($user_ad){
$eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_user_riport.riport_tipus  
 FROM `mira_user_riport` 
 where
 mira_user_riport.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['riport_tipus']]=1;
 }
 return $eredmeny_keres;
}

function keress_jovahagyhoz_projekt_user($ev,$ho,$szerv_id,$user_ad){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);

$projekt_id = substr($_POST['szerv_id'],8);

if($user_ad=="all"){
 $where_user1=""; 
}else{
 $where_user1=" (mira_user.user_ad='".$user_ad."')";
}

//Rögzítés kezdete user - eleje
if($ho<10) $ho_nullas="0".$ho;
else $ho_nullas=$ho;
if($where_user1!="")$where_user1.=' and ';
$where_user1.=" (
 (mira_user.user_kezd_date='0000-00-00')
 or
 (mira_user.user_kezd_date <= '".$ev."-".$ho_nullas."-31')
) ";

//Rögzítés kezdete user - vége

if($where_user1!="")$where_user1.=" and ";
$where_user1.="mira_user.user_inaktiv='0' and mira_user.ful_rogzit='1'";

$sql='
SELECT 
mira_user.user_ad,
mira_user.user_nev

FROM `mira_user`
inner join rogzit ON 
	rogzit.user_ad=mira_user.user_ad and
	rogzit.rogzit_ho="'.$ev.'-'.$ho_nullas.'" 
inner join rogzit_sor ON
	rogzit_sor.rogzit_id = rogzit.rogzit_id and 
	rogzit_sor.projekt_id="'.$projekt_id.'"
where '.$where_user1.'
group by mira_user.user_ad
order by mira_user.user_nev';
//echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_jovahagyhoz_user($ev,$ho,$szerv_id,$user_ad){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);

if($szerv_id=="all"){
 $where="";
}else{
 $where=" AND (mira_szerv_jovahagyo.szerv_id='".$szerv_id."')";
}

if($user_ad=="all"){
 $where_user1=$where_user2="";
}else{
 $where_user1=" AND (mira_user_szerv.user_ad='".$user_ad."')";
 $where_user2=" AND (mira_user_rogzit.user_ad='".$user_ad."')";
}

//Rögzítés kezdete user - eleje
if($ho<10) $ho_nullas="0".$ho;
else $ho_nullas=$ho;
$where_user1.=" and
(
 (mira_user_szerv.user_kezd_date='0000-00-00')
 or
 (mira_user_szerv.user_kezd_date <= '".$ev."-".$ho_nullas."-31')
) ";
$where_user2.=" and
(
 (mira_user_rogzit.user_kezd_date='0000-00-00')
 or
 (mira_user_rogzit.user_kezd_date <= '".$ev."-".$ho_nullas."-31')
) ";
//Rögzítés kezdete user - vége
/*
$sql="
Select user_ad,user_nev ";
//,szerv_nev
$sql.="from
(
(
SELECT 
mira_user_szerv.user_ad,
mira_user_szerv.user_nev ";
//,mira_szerv.szerv_nev
$sql.="FROM `mira_szerv_jovahagyo`
left JOIN mira_user as mira_user_szerv ON mira_user_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id ";
//left join mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
$sql.="

left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad = mira_user_szerv.user_ad
left join mira_user as mira_user_fe_jo ON
	mira_user_fe_jo.user_ad=mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo

WHERE
mira_szerv_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
and
mira_user_szerv.user_inaktiv='0'
AND
(
 (mira_user_felettes_jovahagyo.user_ad IS NULL)
 or
 (mira_user_fe_jo.user_inaktiv='1')
)
".$where.$where_user1."
GROUP BY mira_user_szerv.user_ad

)
UNION
(
SELECT 
mira_user_rogzit.user_ad,
mira_user_rogzit.user_nev ";
//,mira_szerv.szerv_nev
$sql.="FROM `mira_szerv_jovahagyo`
left join rogzit ON rogzit.szerv_id = mira_szerv_jovahagyo.szerv_id
	and rogzit.rogzit_ho='".$ev."-".$ho_nullas."'

left join mira_user as mira_user_rogzit ON  mira_user_rogzit.user_ad = rogzit.user_ad ";
//left join mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
$sql.="

left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user_rogzit.user_ad
left join mira_user as mira_user_fe_jo ON
	mira_user_fe_jo.user_ad=mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo


WHERE
mira_szerv_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
and rogzit.szerv_id != mira_user_rogzit.szerv_id and 
mira_user_rogzit.user_inaktiv='0' 
AND
(
 (mira_user_felettes_jovahagyo.user_ad IS NULL)
 or
 (mira_user_fe_jo.user_inaktiv='1')
)
".$where.$where_user2."
GROUP BY mira_user_rogzit.user_ad

)
)results
order by user_nev ASC
";
*/
$sql="SELECT 
mira_user_szerv.user_ad,
mira_user_szerv.user_nev,mira_user_fe_jo.user_ad as user_ad_felettes ";
//,mira_szerv.szerv_nev
$sql.="FROM `mira_szerv_jovahagyo`
left JOIN mira_user as mira_user_szerv ON mira_user_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id ";
//left join mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
$sql.="

left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad = mira_user_szerv.user_ad
left join mira_user as mira_user_fe_jo ON
	mira_user_fe_jo.user_ad=mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
	and mira_user_fe_jo.user_inaktiv='0'
WHERE
mira_szerv_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
and
mira_user_szerv.user_inaktiv='0' and mira_user_szerv.ful_rogzit='1'

".$where.$where_user1."
GROUP BY mira_user_szerv.user_ad 
order by user_nev ASC";

/*
AND
(
 (mira_user_felettes_jovahagyo.user_ad IS NULL)
 or
 (mira_user_fe_jo.user_inaktiv='1')
)
*/
//order by mira_user_szerv.user_nev ASC
//order by mira_user_rogzit.user_nev ASC
//GROUP BY mira_user_egybe.user_ad
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_stat_rogzitett($ev,$ho,$tipus,$excel){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['idoszak_nap']);
if(isset($_POST['szerv_id']))
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['szerv_id']);
else
 $szerv_id="all";

if(isset($_POST['projekt_id']))
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['projekt_id']);
else
 $projekt_id="all";

if($ho!="all"){
 if($ho<10)$ho="0".$ho;
}
if(($nap!="all")and($ho<10))$nap="0".$nap;

$orderby="";
if(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $orderby="order by mira_user.user_nev,rogzit.rogzit_nap,projekt.projekt_nev asc";
}elseif($tipus=="user_napi"){
 $orderby="order by mira_user.user_nev asc";
}elseif($tipus=="napi_user"){
 //$orderby="order by rogzit.rogzit_nap asc";
 $orderby="order by mira_user.user_nev asc";
}elseif($tipus=="projekt_szerv"){
 //$orderby="order by projekt.projekt_nev, mira_szerv.szerv_nev asc";
 //$orderby="order by projekt.projekt_nev, mira_szerv.szerv_nev asc";
 $orderby="order by projekt.projekt_nev asc";//V1.035
}elseif($tipus=="projekt_napi"){
 $orderby="order by projekt.projekt_nev asc";
}elseif($tipus=="szerv_projekt"){
 //$orderby="order by mira_szerv.szerv_nev,projekt.projekt_nev asc";
 $orderby="order by mira_szerv.szerv_nev asc";//V1.035
}elseif($tipus=="szervezet_napi"){
 $orderby="order by mira_szerv.szerv_nev asc";
}

//where - eleje
//$where=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
$where=" mira_user.ful_rogzit='1' ";
//$where=" mira_user.ful_rogzit=1 ";
//Hogy üres ne legyen látható.
/*
$where.=" and ( 
((rogzit.rogzit_id IS NULL)and(mira_user.user_inaktiv='0'))OR
(rogzit.tavollet='1') or (rogzit_sor.rogzit_ora!='0') or (rogzit_sor.rogzit_perc!='0'))";
*/

if(isset($_POST['user']))
if($_POST['user']!="all"){
 $_POST['user']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user']);
 $where.=" and mira_user.user_ad='".$_POST['user']."' ";
}

/*if(($tipus=="szervezet_napi")or($tipus=="szerv_projekt")){
 $where.=" and rogzit_sor.rogzit_id is not null ";
}*/

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")or($tipus=="szerv_projekt")){
$where.=" and rogzit_sor.projekt_id is not null ";
}

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
 //$where.=" and rogzit_sor.projekt_id is not null ";
 $where.=" and rogzit_sor.rogzit_id is not null ";
}

if($szerv_id!="all"){
 $where.=" and mira_szerv.szerv_id='".$szerv_id."' ";
}elseif(($tipus!='reszletes3')and($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']!=1)){//Áll esetén ha nem az összesre van joga
 $tomb_stat_jog_szerv=keres_user_stat_szerv_jogok();
  
  $where_ksz="";
  if(is_array($tomb_stat_jog_szerv)){
  foreach($tomb_stat_jog_szerv as $ert_sz){
	  if($where_ksz!="")$where_ksz.="or";
	  $where_ksz.="(mira_user.szerv_id='".$ert_sz['szerv_id']."')";
  }
  }
  if($where_ksz!="")$where_ksz="and(".$where_ksz.") ";
  $where.=$where_ksz;
 
}

if($projekt_id!="all"){
 $where.=" and rogzit_sor.projekt_id='".$projekt_id."' ";
}elseif(($tipus!='reszletes3')and($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']!=1)){//Áll esetén ha nem az összesre van joga
 $tomb_stat_jog_proj=keres_user_stat_projekt_jogok();
 
   $where_ksz="";
  if(is_array($tomb_stat_jog_proj)){
  foreach($tomb_stat_jog_proj as $ert_sz){
	  if($where_ksz!="")$where_ksz.="or";
	  $where_ksz.="(rogzit_sor.projekt_id='".$ert_sz['projekt_id']."')";
  }
  }
  if($where_ksz!="")$where_ksz="and(".$where_ksz.") ";
  $where.=$where_ksz;
  
}

//Részletes esetén külön kezelünk mindent!
if(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){

if($ho=="all"){
 $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_ho like '".$ev."-%' ";
}elseif($nap=="all"){
 $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
}else{
  $where.=" and rogzit.rogzit_id is not null and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";
}
/*
 if($_POST['kiuser']=="csak_lezart"){
	$where.=" and rogzit_ho.ellenorzesre_lezarva='1' ";
 }elseif($_POST['kiuser']=="csak_jovahagyott"){
	$where.=" and rogzit_ho.ellenorzesre_ok='1' ";
 }elseif($_POST['kiuser']=="nem_zart_le"){
	 $where.=" and rogzit_ho.ellenorzesre_lezarva='0' ";
 }elseif($_POST['kiuser']=="jova_nem_hagyott"){
	 $where.=" and rogzit_ho.ellenorzesre_ok='0' ";
 }
*/
}//else

if($_POST['kiuser']=="all"){
//ha rögözített bármit akkor lehet iníktív is,
//vagy ha nem rögzített akkor csak az aktívak
 $where.=" and ( ";
 $where.="(rogzit.rogzit_id is not null) ";
 $where.="or ";
 $where.="(mira_user.user_inaktiv='0' and rogzit.rogzit_id is null) ";
 $where.=" ) ";
}elseif(
($_POST['kiuser']=="csak_rogzitett")or
($_POST['kiuser']=="csak_lezart")or
($_POST['kiuser']=="csak_jovahagyott")

){//Csak rögzített

/*if($nap=="all")
 $where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
else
 $where.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";*/

if($_POST['kiuser']=="csak_rogzitett")
 $where.=" and rogzit.rogzit_id is not null ";

 //(rogzit.rogzit_nap BETWEEN '".$ev."-".$ho."-01' and '".$ev."-".$ho."-31')
 if($_POST['kiuser']=="csak_lezart"){
	$where.=" and rogzit_ho.ellenorzesre_lezarva='1' "; 
 }elseif($_POST['kiuser']=="csak_jovahagyott"){
	$where.=" and rogzit_ho.ellenorzesre_ok='1' "; 
 }
 
}elseif($_POST['kiuser']=="le_nem_zart_user"){
 /*$where.=" and 
 (
 (rogzit_ho.ellenorzesre_lezarva='0')or
 (rogzit_ho.rogzit_ho_id is null)
 )
 ";*/
 //$where.=" and mira_user.user_inaktiv='0' ";
 $where.=" and ( ";
 $where.="(rogzit_ho.rogzit_ho_id is null and mira_user.user_inaktiv='0')or(rogzit_ho.ellenorzesre_lezarva='0')";
 $where.=" )  ";
 /*
 $where.=" and ( ";
 $where.="(rogzit.rogzit_id is not null)and(rogzit_ho.ellenorzesre_lezarva='0')";
 $where.="or ";
 $where.="(mira_user.user_inaktiv='0' and rogzit.rogzit_id is null)";
 $where.=" ) ";
 */
}elseif($_POST['kiuser']=="nem_rogzitett"){
 //$where.=" and rogzit.rogzit_id is null ";	
 $where.=" and mira_user.user_inaktiv='0' and rogzit.rogzit_id is null ";
}elseif($_POST['kiuser']=="nem_zart_le"){
//Csak rögzített de le nem zárt hónappal rendelkező felhasználók
/*$where.="(
 (
 (rogzit.rogzit_id is NULL)
 and
 (mira_user.user_inaktiv='0')
 )
 or
 (";*/
 /*
$where.="(
 (
  (rogzit.rogzit_id is not NULL) and 
  (rogzit_ho.rogzit_ho_id is null)
 )
 or
 (";*/

/*
 if($nap=="all")
  $where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
 else
  $where.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";*/
 
 $where.=" and rogzit.rogzit_id is not NULL and
 (
 (rogzit_ho.ellenorzesre_lezarva='0')or
 (rogzit_ho.rogzit_ho_id is null)
 )
 ";

}elseif($_POST['kiuser']=="jova_nem_hagyott"){
//Jóváhagyással nem rendelkező felhasználók
/*$where.="(
 (
 (rogzit.rogzit_id is NULL)
 and
 (mira_user.user_inaktiv='0')
 )
 or
 (";*/
 
 //$where.="(rogzit.rogzit_ho = '".$ev."-".$ho."')and";
 //$where.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
 
 //and rogzit.rogzit_id is not NULL
 $where.=" and
 rogzit_ho.ellenorzesre_lezarva='1' and
 rogzit_ho.ellenorzesre_ok='0' ";
 //)
 //)";
}

//Kezdeti rögzítés lekezelése - eleje
if($ho=="all"){
$where.=' and
(
 (mira_user.user_kezd_date="0000-00-00")or
 (mira_user.user_kezd_date <="'.$ev.'-12-31")
) ';
}else{
$where.=' and
(
 (mira_user.user_kezd_date="0000-00-00")or
 (mira_user.user_kezd_date <="'.$ev.'-'.$ho.'-31")
) ';
}
//Kezdeti rögzítés lekezelése - vége

	 //vége rögzítés lekezelése - eleje
	if($ho=="all"){
	$where.=' and
	(
	 (mira_user.user_veg_date="0000-00-00")or
	 (mira_user.user_veg_date>="'.$ev.'-01-01")
	) ';
	}else{
	$where.=' and
	(
	 (mira_user.user_veg_date="0000-00-00")or
	 (mira_user.user_veg_date>="'.$ev.'-'.$ho.'-01")
	) ';
	}
	//vége rögzítés lekezelése - vége

//where - vége



$sql="SELECT
mira_user.user_ad,";

if( ($excel=="1") and (($tipus=="reszletes2")or($tipus=="reszletes3")or($tipus=="user_napi")))
 $sql.="mira_user.user_email,";

if( ($excel=="1") and (($tipus=="user_napi")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")))
 $sql.="mira_user.user_tsz,";

if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="rogzit.tavollet,";
 
 if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="mira_user.user_nev,";

if(
($tipus=="projekt_szerv")
or($tipus=="szervezet_napi")
or($tipus=="szerv_projekt")
)
 $sql.="mira_szerv.szerv_id,";

if(($tipus=="user_napi")or($tipus=="napi_user")or($tipus=="projekt_szerv")
or($tipus=="szervezet_napi")or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
 $sql.="mira_szerv.szerv_nev,";

if($tipus=="reszletes3")
 $sql.="rogzit.szerv_id as rogzit_szerv_id ,";

if(
($excel=="1")and
(($tipus=="user_napi")or($tipus=="napi_user")
or($tipus=="szervezet_napi")or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3"))
)
 $sql.="mira_szerv.szerv_koltsegkod,mira_szerv.szerv_adkod,";

if(($tipus=="user_napi")or($tipus=="napi_user")
or($tipus=="szervezet_napi")
or($tipus=="projekt_napi")or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="DATE_FORMAT(rogzit.rogzit_nap,'%e') AS rogzit_nap,";
 if($ho=="all")
  $sql.="DATE_FORMAT(rogzit.rogzit_nap,'%m') AS rogzit_ho,";

}

if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")
or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="projekt.projekt_nev,rogzit_sor.projekt_id,";

}

 //Projekt max idő lekezelése
 if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
  $sql.="IF
( 
( (projekt.projekt_id_max_all_igen='1') ),projekt.projekt_id_max_all_ora, 
IF( projekt_ido.projekt_id_max_ora is not NULL,projekt_ido.projekt_id_max_ora, '' ) 
) AS projekt_id_max_ora,";
 }

if($tipus=="reszletes2")
 $sql.="projekt.projekt_co ,";

if(($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.="
 rogzit.rogzit_update_time,
 rogzit.rogzit_megj,
 rogzit_sor.rogzit_sor_megj,
 rogzit_sor.rogzit_sor_update_time,
 rogzit_ho.ellenorzesre_lezarva,
 rogzit_ho.ellenorzesre_lezarva_mikor,
 
 rogzit_ho.ellenorzesre_lezarva_jovahagyo,
 mira_user_ellenorzesre_lezarva_jovahagyo.user_nev as ellenorzesre_lezarva_jovahagyo_ki_nev,
  
 rogzit_ho.ellenorzesre_visszakuldve,
 mira_user_ellenorzesre_visszakuldve.user_nev as ellenorzesre_visszakuldve_ki_nev,
 rogzit_ho.ellenorzesre_visszakuldve_mikor,
 
 rogzit_ho.ellenorzesre_ok,
 rogzit_ho.ellenorzesre_ok_mikor,
 mira_user_jovahagyo.user_nev as ellenorzesre_ok_ki_nev,
 
 rogzit_sor.helyettes_rogzito,
 mira_user_helyettes_rogzito.user_nev as helyettes_rogzito_ki_nev,
 
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva,
 mira_user_projekt_jovahagyo_elutasitva.user_nev as projekt_jovahagyo_elutasitva_nev,
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva_mikor,
 
 rogzit_ho_projekt.projekt_jovahagyo_jovahagyva,
 mira_user_projekt_jovahagyo_jovahagyva.user_nev as projekt_jovahagyo_jovahagyva_nev,
 rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_mikor,
 
 ";
 
 //Társasági SAP kód
 $sql.=" projekt.projekt_tagv_kod, ";
 //Szervezeti szolgáltatás kód
 $sql.=" mira_szerv.szerv_szolg_kod, ";
 //Tevékenységek szolgáltatás kód
 $sql.=" projekt.projekt_szolg_kod, ";
 $sql.=" mira_szerv.szerv_sm_kod, ";

}

$sql.="rogzit_sor.rogzit_ora,
rogzit_sor.rogzit_perc";



$sql.=" FROM `mira_user`
left join rogzit ON rogzit.user_ad = mira_user.user_ad ";
//Hó vagy nap  lekezelése  - eleje
if($ho=="all"){
   $sql.=" and rogzit.rogzit_ho like '".$ev."-%' ";
}elseif($nap=="all"){
  $sql.=" and rogzit.rogzit_ho = '".$ev."-".$ho."' ";
}else{
  $sql.=" and rogzit.rogzit_nap = '".$ev."-".$ho."-".$nap."' ";
}
//Hó vagy nap  lekezelése  - vége

$sql.=" left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id ";

if(
(($tipus=="user_napi")or($tipus=="napi_user"))
or($szerv_id!="all")
){
 $sql.="left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id ";
}elseif(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")or($tipus=="projekt_szerv")){
 $sql.="left join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id ";
}elseif(($tipus=="szervezet_napi")or($tipus=="szerv_projekt")){
// $sql.="inner join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id ";
  $sql.="left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id ";  
}

$sql.="left join rogzit_ho ON rogzit_ho.rogzit_ho = rogzit.rogzit_ho and rogzit_ho.user_ad = rogzit.user_ad ";
if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")
or($tipus=="szerv_projekt")
or($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.=" left join projekt ON projekt.projekt_id = rogzit_sor.projekt_id ";
}

  
 //Projekt max idő lekezelése
 if(($tipus=="projekt_napi")or($tipus=="projekt_szerv")){
  if($ho=="all")
   $sql.=" left join projekt_ido ON projekt_ido.projekt_id=projekt.projekt_id and projekt_ido.projekt_ho_ido='".$ev."-%' ";  
  else
   $sql.=" left join projekt_ido ON projekt_ido.projekt_id=projekt.projekt_id and projekt_ido.projekt_ho_ido='".$ev."-".$ho."' ";
 }

if(($tipus=="reszletes2")or($tipus=="reszletes3")){
 $sql.=" left join mira_user as mira_user_jovahagyo ON mira_user_jovahagyo.user_ad = rogzit_ho.ellenorzesre_ok_ki ";
 $sql.=" left join mira_user as mira_user_ellenorzesre_visszakuldve ON mira_user_ellenorzesre_visszakuldve.user_ad = rogzit_ho.ellenorzesre_visszakuldve_ki ";
 $sql.=" left join mira_user as mira_user_ellenorzesre_lezarva_jovahagyo ON mira_user_ellenorzesre_lezarva_jovahagyo.user_ad = rogzit_ho.ellenorzesre_lezarva_jovahagyo_ki ";
 
 $sql.=" left join mira_user as mira_user_helyettes_rogzito ON mira_user_helyettes_rogzito.user_ad = rogzit_sor.helyettes_rogzito_ki ";
 
  $sql.=" left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.user_ad = rogzit.user_ad and
	rogzit_ho_projekt.rogzit_ho = rogzit.rogzit_ho and
	rogzit_ho_projekt.projekt_id = rogzit_sor.projekt_id 
	";
  $sql.=" left join mira_user as mira_user_projekt_jovahagyo_jovahagyva ON mira_user_projekt_jovahagyo_jovahagyva.user_ad = rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_ki ";
  $sql.=" left join mira_user as mira_user_projekt_jovahagyo_elutasitva ON mira_user_projekt_jovahagyo_elutasitva.user_ad = rogzit_ho_projekt.projekt_jovahagyo_elutasitva_ki ";
}
$sql.=" WHERE ".$where;

$sql.=$orderby;
 //DATE_FORMAT(rogzit.rogzit_nap,'%Y.%m.%d') AS rogzit_date ,

 //print $sql."<br>";
 //exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i_resz=0;
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(($tipus=="user_napi")or($tipus=="napi_user")){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['user_ad']]['user_nev']=$adatom['user_nev'];
  
  if(($tipus=="user_napi")and($excel=="1")){
   $eredmeny_keres['sor'][$adatom['user_ad']]['user_tsz']=$adatom['user_tsz'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['user_email']=$adatom['user_email'];
  }
  $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_nev']=$adatom['szerv_nev'];
  if($excel=="1"){
   $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['szerv_adkod']=$adatom['szerv_adkod'];
  }
  
  if(!isset($eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if(($adatom['rogzit_perc']!="")and($adatom['rogzit_perc']<10))$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	//echo $adatom['rogzit_nap']."-".$adatom['user_ad']."-".$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']."<br>";
	$ora=$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }
  
  $eredmeny_keres['sor'][$adatom['user_ad']]['adat'][$adatom['rogzit_nap']]['tavollet']=$adatom['tavollet'];
  
 }elseif($tipus=="szervezet_napi"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_nev']=$adatom['szerv_nev']; 
  if($excel=="1"){
   $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod']; 
   $eredmeny_keres['sor'][$adatom['szerv_id']]['szerv_adkod']=$adatom['szerv_adkod']; 
  }
   if(!isset($eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	$ora=$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];
	
	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['szerv_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];


  }
  
 }elseif($tipus=="szerv_projekt"){

  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];

  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_nev']]=$adatom['projekt_id']; 
  //$eredmeny_keres['sor_szerv_nev'][$adatom['szerv_nev']]=$adatom['szerv_id']; 
  $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_nev']=$adatom['szerv_nev']; 
  if($excel=="1"){
   $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_koltsegkod']=$adatom['szerv_koltsegkod']; 
   $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]['szerv_adkod']=$adatom['szerv_adkod'];
  }
  
  if(!isset($eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora'])){
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
   $ora=$eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']+$adatom['rogzit_ora'];
   $perc=$eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']+$adatom['rogzit_perc'];
   $tomb_ora=ora_perc_osszead($ora,$perc);
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

   if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['szerv_id']][$adatom['projekt_id']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }

 }elseif($tipus=="projekt_napi"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  $eredmeny_keres['sor'][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];  
  $eredmeny_keres['sor'][$adatom['projekt_id']]['projekt_id_max_ora']=$adatom['projekt_id_max_ora'];  
  
  if(!isset($eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']])){
   $eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
	$ora=$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']+$adatom['rogzit_ora'];
	$perc=$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']+$adatom['rogzit_perc'];
	$tomb_ora=ora_perc_osszead($ora,$perc);
	$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_ora']=$tomb_ora['rogzit_ora'];
	
	if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
	$eredmeny_keres['sor'][$adatom['projekt_id']]['adat'][$adatom['rogzit_nap']]['rogzit_perc']=$tomb_ora['rogzit_perc'];


  }

 }elseif($tipus=="projekt_szerv"){
  $eredmeny_keres['user_tomb'][$adatom['user_ad']]['user_ad']=$adatom['user_ad'];
  
  //$eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]=$adatom['projekt_nev']; 
  //$eredmeny_keres['sor_szerv_nev'][$adatom['szerv_id']]=$adatom['szerv_nev'];
  
  //$eredmeny_keres['sor_projekt_nev'][$adatom['projekt_nev']]=$adatom['projekt_id'];
  
  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];
  $eredmeny_keres['sor_projekt_nev'][$adatom['projekt_id']]['projekt_id_max_ora']=$adatom['projekt_id_max_ora'];
  
  $eredmeny_keres['sor_szerv_nev'][$adatom['szerv_nev']]=$adatom['szerv_id']; 
  
  if(!isset($eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora'])){
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']=$adatom['rogzit_ora'];

   if($adatom['rogzit_perc']<10)$adatom['rogzit_perc']="0".$adatom['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }else{
   $ora=$eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']+$adatom['rogzit_ora'];
   $perc=$eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']+$adatom['rogzit_perc'];
   $tomb_ora=ora_perc_osszead($ora,$perc);
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_ora']=$tomb_ora['rogzit_ora'];

   if($tomb_ora['rogzit_perc']<10)$tomb_ora['rogzit_perc']="0".$tomb_ora['rogzit_perc'];
   $eredmeny_keres['sor'][$adatom['projekt_id']][$adatom['szerv_id']]['rogzit_perc']=$tomb_ora['rogzit_perc'];
  }
  
 }elseif(($tipus=="reszletes")or($tipus=="reszletes2")or($tipus=="reszletes3")){
	 $i_resz++;
	 $eredmeny_keres[$i_resz]['user_ad']=$adatom['user_ad'];
	 $eredmeny_keres[$i_resz]['user_nev']=$adatom['user_nev'];
	 $eredmeny_keres[$i_resz]['user_tsz']=$adatom['user_tsz'];
	 $eredmeny_keres[$i_resz]['szerv_nev']=$adatom['szerv_nev'];
	 $eredmeny_keres[$i_resz]['szerv_koltsegkod']=$adatom['szerv_koltsegkod'];
	 $eredmeny_keres[$i_resz]['szerv_adkod']=$adatom['szerv_adkod'];
	 $eredmeny_keres[$i_resz]['projekt_nev']=$adatom['projekt_nev'];
	 
	 if($ho=="all")
	  $eredmeny_keres[$i_resz]['rogzit_ho']=$adatom['rogzit_ho'];
	 
	 $eredmeny_keres[$i_resz]['rogzit_nap']=$adatom['rogzit_nap'];
	 $eredmeny_keres[$i_resz]['rogzit_ora']=$adatom['rogzit_ora'];
	 $eredmeny_keres[$i_resz]['rogzit_perc']=$adatom['rogzit_perc'];
	 $eredmeny_keres[$i_resz]['tavollet']=$adatom['tavollet'];
	
	if(($tipus=="reszletes2")or($tipus=="reszletes3")){
	 $eredmeny_keres[$i_resz]['projekt_tagv_kod']=$adatom['projekt_tagv_kod'];
	 $eredmeny_keres[$i_resz]['szerv_szolg_kod']=$adatom['szerv_szolg_kod'];
	 $eredmeny_keres[$i_resz]['projekt_szolg_kod']=$adatom['projekt_szolg_kod'];
	 $eredmeny_keres[$i_resz]['szerv_sm_kod']=$adatom['szerv_sm_kod'];
	 
	 $eredmeny_keres[$i_resz]['user_email']=$adatom['user_email'];
   	 $eredmeny_keres[$i_resz]['rogzit_update_time']=$adatom['rogzit_update_time'];
   	 $eredmeny_keres[$i_resz]['rogzit_megj']=$adatom['rogzit_megj'];
   	 $eredmeny_keres[$i_resz]['rogzit_sor_megj']=$adatom['rogzit_sor_megj'];
   	 $eredmeny_keres[$i_resz]['rogzit_sor_update_time']=$adatom['rogzit_sor_update_time'];
   	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva']=$adatom['ellenorzesre_lezarva'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_mikor']=$adatom['ellenorzesre_lezarva_mikor'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_jovahagyo']=$adatom['ellenorzesre_lezarva_jovahagyo'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_lezarva_jovahagyo_ki_nev']=$adatom['ellenorzesre_lezarva_jovahagyo_ki_nev'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve']=$adatom['ellenorzesre_visszakuldve'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve_ki_nev']=$adatom['ellenorzesre_visszakuldve_ki_nev'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_visszakuldve_mikor']=$adatom['ellenorzesre_visszakuldve_mikor'];
	 
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok']=$adatom['ellenorzesre_ok'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok_ki_nev']=$adatom['ellenorzesre_ok_ki_nev'];
	 $eredmeny_keres[$i_resz]['ellenorzesre_ok_mikor']=$adatom['ellenorzesre_ok_mikor'];
	 
	 $eredmeny_keres[$i_resz]['helyettes_rogzito']=$adatom['helyettes_rogzito'];
	 $eredmeny_keres[$i_resz]['helyettes_rogzito_ki_nev']=$adatom['helyettes_rogzito_ki_nev'];
	 
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva']=$adatom['projekt_jovahagyo_elutasitva'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva_nev']=$adatom['projekt_jovahagyo_elutasitva_nev'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_elutasitva_mikor']=$adatom['projekt_jovahagyo_elutasitva_mikor'];
	 
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva']=$adatom['projekt_jovahagyo_jovahagyva'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva_nev']=$adatom['projekt_jovahagyo_jovahagyva_nev'];
	 $eredmeny_keres[$i_resz]['projekt_jovahagyo_jovahagyva_mikor']=$adatom['projekt_jovahagyo_jovahagyva_mikor'];
    }
	
	if($tipus=="reszletes2"){
	 $eredmeny_keres[$i_resz]['projekt_co']=$adatom['projekt_co'];
	}
	
	if($tipus=="reszletes3"){
		$eredmeny_keres[$i_resz]['szerv_id']=$adatom['rogzit_szerv_id'];
		$eredmeny_keres[$i_resz]['projekt_id']=$adatom['projekt_id'];
	}
 }
  
 }
 //error_log("Peak memory: " . (memory_get_usage()) / 1024 / 1024 . " MB");
 mysqli_free_result($adat);
 //error_log("Peak memory: " . (memory_get_usage()) / 1024 / 1024 . " MB");
 return $eredmeny_keres;
}

function keress_rogzitett_egynaphoz_rogzit_sor_megj_aktuser($ev,$ho,$nap,$projekt_id){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);
$projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);

if($ho<10)$ho_akt="0".$ho;
else $ho_akt=$ho;

if($nap<10)$nap_akt="0".$nap;
else $nap_akt=$nap;

$rogzit_nap=$ev."-".$ho_akt."-".$nap_akt;

if(
(isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
)
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

$sql="SELECT 
rogzit_sor.rogzit_sor_megj
FROM `rogzit`
inner join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id and rogzit_sor.projekt_id='".$projekt_id."'
where 
rogzit.user_ad = '".$user_ad."' and 
rogzit.rogzit_nap='".$rogzit_nap."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['rogzit_sor_megj'];
 }
 return $eredmeny_keres;
}

function keress_rogzitett_egynaphoz_rogzit_id_aktuser($ev,$ho,$nap){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);

if($ho<10)$ho_akt="0".$ho;
else $ho_akt=$ho;

if($nap<10)$nap_akt="0".$nap;
else $nap_akt=$nap;

$rogzit_nap=$ev."-".$ho_akt."-".$nap_akt;

if(
(isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
)
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

$sql="SELECT 
rogzit.rogzit_id
FROM `rogzit`
where 
rogzit.user_ad = '".$user_ad."' and 
rogzit.rogzit_nap='".$rogzit_nap."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['rogzit_id'];
 }
 return $eredmeny_keres;
}

function keress_rogzitett_egynaphoz_proj_nev_aktuser($ev,$ho,$nap,$sorsz){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);
$sorsz=mysqli_real_escape_string($GLOBALS['mysqli'],$sorsz);

if($ho<10)$ho_akt="0".$ho;
else $ho_akt=$ho;

if($nap<10)$nap_akt="0".$nap;
else $nap_akt=$nap;

$rogzit_nap=$ev."-".$ho_akt."-".$nap_akt;

if(
(isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
)
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

$sql="SELECT 
projekt.projekt_nev
FROM `rogzit`
inner join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id and rogzit_sor.sorsz = '".$sorsz."'
inner join projekt ON projekt.projekt_id = rogzit_sor.projekt_id
where 
rogzit.user_ad = '".$user_ad."' and 
rogzit.rogzit_nap='".$rogzit_nap."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['projekt_nev'];
 }
 return $eredmeny_keres;
}

//Bejelentkezett usernek van-e joga a $user_ad akt szervezetéhez
//vagy ha ez nincs, akkor van-e felettes jóváhagyó joga a user-hez
function keres_jovahagyo_vanejogom_szerv($user_ad){
$eredmeny_keres=false;
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);

$sql="SELECT 
mira_szerv_jovahagyo.user_ad
FROM `mira_user` 
inner join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_user.szerv_id
 and mira_szerv_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
where mira_user.user_ad='".$user_ad."'
";

 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres=true;
 }

//Ha nincs jog,a akkor hátha van felettes jóváhagyó joga
if(!$eredmeny_keres){
 $sql_f="SELECT 
 mira_user_felettes_jovahagyo.user_ad
 FROM `mira_user_felettes_jovahagyo` 
 where mira_user_felettes_jovahagyo.user_ad='".$user_ad."'
 and mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";

 //echo $sql_f."<br>";
 $adat_f=mysqli_query($GLOBALS['mysqli'],$sql_f);
 while($adatom_f=mysqli_fetch_assoc($adat_f)){
  $eredmeny_keres=true;
 }
}

 return $eredmeny_keres;
}

function keress_jovahagyhoz_rogzitett_egy($ev,$ho,$nap,$user_ad,$projekt_jovahagyas_id){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$projekt_jovahagyas_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_jovahagyas_id);

if($ho<10)$ho_akt="0".$ho;
else $ho_akt=$ho;

if($nap<10)$nap_akt="0".$nap;
else $nap_akt=$nap;

$rogzit_nap=$ev."-".$ho_akt."-".$nap_akt;

//$where.=" limit 10";
/*
%d – Day of the month as a numeric value (01 to 31)
%e – Day of the month as a numeric value (0 to 31)
*/
//SQL_NO_CACHE
$sql="SELECT 
rogzit.user_ad,
rogzit.rogzit_nap,
DATE_FORMAT(rogzit.rogzit_nap,'%e') AS rogzit_nap ,
rogzit_sor.projekt_id,
projekt.projekt_nev,
rogzit_sor.rogzit_ora,
rogzit_sor.rogzit_perc,
rogzit.tavollet,
rogzit.rogzit_megj
FROM `rogzit`
left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
left join projekt ON projekt.projekt_id = rogzit_sor.projekt_id
left join rogzit_ho ON rogzit_ho.user_ad = rogzit.user_ad and rogzit_ho.rogzit_ho = '".$ev."-".$ho."'
left join mira_user as mira_user_ok ON mira_user_ok.user_ad = rogzit_ho.ellenorzesre_ok_ki
left join mira_user as mira_user_visszaki ON mira_user_visszaki.user_ad = rogzit_ho.ellenorzesre_visszakuldve_ki
left join mira_user as mira_user_ellenorzesre_lezarva_jovahagyo_ki ON mira_user_ellenorzesre_lezarva_jovahagyo_ki.user_ad = rogzit_ho.ellenorzesre_lezarva_jovahagyo_ki
WHERE
rogzit.rogzit_nap = '".$rogzit_nap."'
and rogzit.user_ad='".$user_ad."'";

if($projekt_jovahagyas_id!=""){
 $sql.=" and rogzit_sor.projekt_id='".$projekt_jovahagyas_id."'";	
}

$sql.=" order by projekt.projekt_nev asc";
//rogzit.rogzit_nap BETWEEN '".$ev."-".$ho."-01' and '".$ev."-".$ho."-31'
 //print $sql."<br>";exit;
 $i=0;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_megj']=$adatom['rogzit_megj'];
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['tavollet']=$adatom['tavollet'];
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['projekt_nev_ora'][$i]=$adatom['rogzit_ora'];
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['projekt_nev_perc'][$i]=$adatom['rogzit_perc'];  
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['projekt_nev'][$i]=$adatom['projekt_nev'];
 }
 return $eredmeny_keres;
}

function keress_jovahagyhoz_user_felettes($ev,$ho){
 $eredmeny_keres="";
 $ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);

//Rögzítés kezdete user - eleje
if($ho<10) $ho_nullas="0".$ho;
else $ho_nullas=$ho;
$where_user=" and
(
 (mira_user.user_kezd_date='0000-00-00')
 or
 (mira_user.user_kezd_date <= '".$ev."-".$ho_nullas."-31')
) ";
//Rögzítés kezdete user - vége

//and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user_felettes_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = mira_user_felettes_jovahagyo.user_ad
 where
 mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' and 
 mira_user.user_inaktiv='0' and mira_user.ful_rogzit='1' 
 ".$where_user."
 order by mira_user.user_nev asc";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_jovahagy_infok_leker($user_ad,$ev,$ho){
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
if($ho<10)$ho="0".$ho;

 $eredmeny_keres="";
 $sql="SELECT mira_user.user_nev,rogzit_ho.ellenorzesre_ok_mikor
 FROM `rogzit_ho` 
 left join mira_user ON mira_user.user_ad = rogzit_ho.ellenorzesre_ok_ki
 where
 rogzit_ho.user_ad='".$user_ad."' and
 rogzit_ho.rogzit_ho='".$ev."-".$ho."' and
 rogzit_ho.ellenorzesre_ok='1' and 
 rogzit_ho.ellenorzesre_visszakuldve='0'
 ";
 
 $sql1="SELECT mira_user.user_nev,
 rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_mikor,
 projekt.projekt_nev
 FROM `rogzit_ho_projekt` 
 inner join mira_user ON mira_user.user_ad = rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_ki
 left join projekt ON projekt.projekt_id = rogzit_ho_projekt.projekt_id
 where
 rogzit_ho_projekt.user_ad='".$user_ad."' and
 rogzit_ho_projekt.rogzit_ho='".$ev."-".$ho."' and  
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva='0'
 order by projekt.projekt_nev asc";
 
 //print "<br>".$sql1."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]=$adatom;//Szervezeti jóváhagyó
 }
 
 $i=0;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]=$adatom1;//projekt jóváhagyó
 }
 return $eredmeny_keres;
}

function keress_jovahagy_infok_leker_var($user_ad,$ev,$ho){
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
if($ho<10)$ho="0".$ho;

$eredmeny_keres="";
 
 //Szakterületi jóváhagyók
 $sql0="SELECT 
 mira_user_jova.user_nev
 FROM `rogzit_ho`
 left join mira_user ON mira_user.user_ad = rogzit_ho.user_ad
 left join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_user.szerv_id 
 inner join mira_user as mira_user_jova ON 
	mira_user_jova.user_ad=mira_szerv_jovahagyo.user_ad and 
	mira_user_jova.user_inaktiv='0' 
 left join mira_user_felettes_jovahagyo ON 
	mira_user_felettes_jovahagyo.user_ad='".$user_ad."'
 
 LEFT JOIN mira_user AS mira_user_fe_jo ON mira_user_fe_jo.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
 
 where
 rogzit_ho.user_ad='".$user_ad."' and
 rogzit_ho.rogzit_ho='".$ev."-".$ho."' and 
 rogzit_ho.ellenorzesre_ok='0' 
 
 AND (
(
mira_user_felettes_jovahagyo.user_ad IS NULL
)
OR (
mira_user_fe_jo.user_inaktiv = '1'
)
)
 
 order by mira_user_jova.user_nev";
 $adat0=mysqli_query($GLOBALS['mysqli'],$sql0);
 while($adatom0=mysqli_fetch_assoc($adat0)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0][]=$adatom0['user_nev'];
 }

 //Felettes jóváhagyók
  $sql0f="SELECT mira_user_jova.user_nev
FROM `mira_user_felettes_jovahagyo`
INNER JOIN mira_user AS mira_user_jova ON 
	mira_user_jova.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo AND 
	mira_user_jova.user_inaktiv = '0'
WHERE mira_user_felettes_jovahagyo.user_ad = '".$user_ad."'";
 $adat0f=mysqli_query($GLOBALS['mysqli'],$sql0f);
 while($adatom0f=mysqli_fetch_assoc($adat0f)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[1][]=$adatom0f['user_nev'];
 }
 
 //Projekt jóváhagyók megállapítása
 $sql1="SELECT 
 projekt_jovahagyo.projekt_id
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = rogzit_sor.projekt_id
 where
 rogzit.user_ad='".$user_ad."' and
 rogzit.rogzit_ho='".$ev."-".$ho."' 
 group by projekt_jovahagyo.projekt_id";
 
 $projekt_jovahagyok="";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($projekt_jovahagyok))$projekt_jovahagyok=array();
  $projekt_jovahagyok[]=$adatom1['projekt_id'];
 }
 
 if(is_array($projekt_jovahagyok)){
 $sql2="SELECT 
 projekt.projekt_nev,
 mira_user.user_nev
 FROM `projekt` 
 left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.projekt_id = projekt.projekt_id and 
	rogzit_ho_projekt.user_ad='".$user_ad."' and
	rogzit_ho_projekt.rogzit_ho='".$ev."-".$ho."' 
 left join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = projekt.projekt_id 
 left join mira_user ON mira_user.user_ad = projekt_jovahagyo.user_ad
 where
 rogzit_ho_projekt.projekt_id is NULL 
 and mira_user.user_inaktiv='0' 
 and (";
 foreach($projekt_jovahagyok as  $i => $projekt_id){
	 if($i>0)$sql2.="or";
	$sql2.="(projekt.projekt_id='".$projekt_id."')"; 
 }
 $sql2.=") order by projekt.projekt_nev ASC,mira_user.user_nev ASC";
 //echo $sql2;
 $adat2=mysqli_query($GLOBALS['mysqli'],$sql2);
 while($adatom2=mysqli_fetch_assoc($adat2)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[2][$adatom2['projekt_nev']][]=$adatom2['user_nev'];
 }
 }
  return $eredmeny_keres;
}

function keress_jovahagyhoz_rogzitett($projekt_jovahagyas_id,$szerv_id,$szerv_all,$ev,$ho,$tomb_user){
$eredmeny_keres="";
if(is_array($tomb_user)){
$projekt_jovahagyas_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_jovahagyas_id);
$szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
$szerv_all=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_all);
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);

if($ho<10)$ho="0".$ho;

$where="";

if(($szerv_id=="all")or($szerv_id=="all_f")){
 $tomb_szerv_all=explode("-",$szerv_all);
 $where_rogzit_szerv="";
 
 /*
 foreach($tomb_szerv_all as $szerv_id_all){
  if($szerv_id_all!=""){
	if($where_rogzit_szerv!="")$where_rogzit_szerv.="or";
	$where_rogzit_szerv.="(rogzit.szerv_id='".$szerv_id_all."')";
  }
 }
 */

 $where_user="";
 foreach($tomb_user as $ert){
  if(($where_user!="")or($where_rogzit_szerv!=""))
   $where_user.="or";
  $where_user.="(rogzit.user_ad='".$ert['user_ad']."')";
 }
 
 $where.=" AND (".$where_rogzit_szerv.$where_user.")";
 
}else{
$where_usr_szerv="";
 
if($projekt_jovahagyas_id!=""){
 $where.=" and rogzit_sor.projekt_id='".$projekt_jovahagyas_id."'";
}elseif($szerv_id!="all_f"){
 //$where_usr_szerv.="(rogzit.szerv_id='".$szerv_id."')";


 foreach($tomb_user as $ert){
  if($where_usr_szerv!="")
   $where_usr_szerv.="or";
  $where_usr_szerv.="(rogzit.user_ad='".$ert['user_ad']."')";
 }
 
 $where.=" AND ( ".$where_usr_szerv." )";
}
}



//$where.=" limit 10";
/*
%d – Day of the month as a numeric value (01 to 31)
%e – Day of the month as a numeric value (0 to 31)
*/
//rogzit.rogzit_jovahagyva,
//SQL_NO_CACHE

//Ezt kivettem mert nem kell, de hátha
//,IF( projekt_jovahagyo.projekt_jovahagyo_id is not NULL, 1, 0 ) AS van_e_projekt_jovahagyo
//,IF( rogzit_ho_projekt.rogzit_ho_projekt_id is not NULL, 1, 0 ) AS projekt_jovahagyas_megtortent_e

//rogzit.rogzit_nap,
$sql="SELECT 
rogzit.user_ad,

DATE_FORMAT(rogzit.rogzit_nap,'%e') AS rogzit_nap ,
rogzit_sor.projekt_id,

rogzit_sor.rogzit_ora,
rogzit_sor.rogzit_perc,
rogzit.tavollet,

rogzit_ho.ellenorzesre_lezarva,
rogzit_ho.ellenorzesre_lezarva_mikor,

rogzit_ho.ellenorzesre_lezarva_jovahagyo,
mira_user_ellenorzesre_lezarva_jovahagyo_ki.user_nev as ellenorzesre_lezarva_jovahagyo_ki_nev,

rogzit_ho.ellenorzesre_lezarva_hanyadik,
rogzit_ho.ellenorzesre_visszakuldve,
rogzit_ho.ellenorzesre_visszakuldve_mikor,
rogzit_ho.ellenorzesre_visszakuldve_megj,
rogzit_ho.ellenorzesre_ok,
rogzit_ho.ellenorzesre_ok_mikor,
mira_user_ok.user_nev as ellenorzesre_ok_ki_nev,
mira_user_visszaki.user_nev as ellenorzesre_visszakuldve_ki_nev,

mira_user_jovahagyo.user_nev as projekt_jovahagyo_nev,
rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_mikor,

rogzit_ho_projekt_all.projekt_jovahagyo_elutasitva,
rogzit_ho_projekt_all.projekt_jovahagyo_elutasitva_mikor,
rogzit_ho_projekt_all.projekt_jovahagyo_elutasitva_megj,
mira_user_elutasitva.user_nev as projekt_elutasitva_nev,

IF( 
(rogzit_ho_projekt.rogzit_ho_projekt_id is NULL) and (projekt_jovahagyo.projekt_jovahagyo_id is not NULL)
, 1, 0 ) AS kell_e_meg_projekt_jovahagyas

FROM `rogzit`
inner join mira_user ON mira_user.user_ad=rogzit.user_ad
	and mira_user.user_inaktiv='0'

left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id

left join rogzit_ho ON 
	rogzit_ho.user_ad = rogzit.user_ad and rogzit_ho.rogzit_ho = '".$ev."-".$ho."'

left join mira_user as mira_user_ok ON mira_user_ok.user_ad = rogzit_ho.ellenorzesre_ok_ki
left join mira_user as mira_user_visszaki ON mira_user_visszaki.user_ad = rogzit_ho.ellenorzesre_visszakuldve_ki
left join mira_user as mira_user_ellenorzesre_lezarva_jovahagyo_ki ON mira_user_ellenorzesre_lezarva_jovahagyo_ki.user_ad = rogzit_ho.ellenorzesre_lezarva_jovahagyo_ki

LEFT JOIN projekt_jovahagyo ON projekt_jovahagyo.projekt_id = rogzit_sor.projekt_id

LEFT JOIN rogzit_ho_projekt ON 
	rogzit_ho_projekt.rogzit_ho = '".$ev."-".$ho."' and
	rogzit_ho_projekt.user_ad = rogzit.user_ad 
	and rogzit_ho_projekt.projekt_id = projekt_jovahagyo.projekt_id

LEFT JOIN rogzit_ho_projekt as rogzit_ho_projekt_all ON 
	rogzit_ho_projekt_all.rogzit_ho = '".$ev."-".$ho."' and
	rogzit_ho_projekt_all.user_ad = rogzit.user_ad 
	and rogzit_ho_projekt_all.projekt_jovahagyo_elutasitva='1'
left join mira_user as mira_user_elutasitva ON mira_user_elutasitva.user_ad = rogzit_ho_projekt_all.projekt_jovahagyo_elutasitva_ki

left join mira_user as mira_user_jovahagyo ON mira_user_jovahagyo.user_ad = rogzit_ho_projekt.projekt_jovahagyo_jovahagyva_ki

WHERE
rogzit.rogzit_ho = '".$ev."-".$ho."'
".$where;
//$sql.=" group by rogzit_sor.rogzit_id,rogzit_sor.projekt_id";
$sql.=" group by rogzit.rogzit_id,rogzit_sor.projekt_id";
//$sql.=" group by rogzit_sor.rogzit_id,rogzit_sor.projekt_id,mira_user_projekt_jovahagyo.user_ad";

/*
$sql2="
SELECT * FROM (".$sql.") t1 
group by rogzit_id,projekt_id
";*/


//$sql.=" group by rogzit_sor.rogzit_id";
//$sql.=" group by rogzit.user_ad,rogzit.rogzit_nap";
// 
// and rogzit_ho_projekt.projekt_jovahagyo_jovahagyva = '1'
//Felesleges ezt rendezni
//$sql.=" order by rogzit.user_ad, rogzit.rogzit_nap asc";

//rogzit.rogzit_nap BETWEEN '".$ev."-".$ho."-01' and '".$ev."-".$ho."-31'
 //print $sql."<br>";
 //exit;
 //ini_set('memory_limit', '1024M');
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array(); 
 if(!isset($eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_ora']))
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_ora']=0;
 if(!isset($eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_perc']))
  $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_perc']=0;
 
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_lezarva']=$adatom['ellenorzesre_lezarva'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_lezarva_mikor']=$adatom['ellenorzesre_lezarva_mikor'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_lezarva_jovahagyo']=$adatom['ellenorzesre_lezarva_jovahagyo'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_lezarva_jovahagyo_ki_nev']=$adatom['ellenorzesre_lezarva_jovahagyo_ki_nev'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_lezarva_hanyadik']=$adatom['ellenorzesre_lezarva_hanyadik'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_visszakuldve']=$adatom['ellenorzesre_visszakuldve'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_visszakuldve_mikor']=$adatom['ellenorzesre_visszakuldve_mikor'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_visszakuldve_megj']=$adatom['ellenorzesre_visszakuldve_megj'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_visszakuldve_ki_nev']=$adatom['ellenorzesre_visszakuldve_ki_nev'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_ok']=$adatom['ellenorzesre_ok'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_ok_mikor']=$adatom['ellenorzesre_ok_mikor'];
 $eredmeny_keres[$adatom['user_ad']]['ellenorzesre_ok_ki_nev']=$adatom['ellenorzesre_ok_ki_nev'];
 
 $eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_nev']=$adatom['projekt_jovahagyo_nev'];
 
 
 $eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_jovahagyva_mikor']=$adatom['projekt_jovahagyo_jovahagyva_mikor'];
 
 if(
 (!isset($eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_elutasitva']))or
 ($adatom['projekt_jovahagyo_elutasitva']==1) 
 ){
  $eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_elutasitva']=$adatom['projekt_jovahagyo_elutasitva'];
  $eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_elutasitva_mikor']=$adatom['projekt_jovahagyo_elutasitva_mikor'];
  $eredmeny_keres[$adatom['user_ad']]['projekt_jovahagyo_elutasitva_megj']=$adatom['projekt_jovahagyo_elutasitva_megj'];
  $eredmeny_keres[$adatom['user_ad']]['projekt_elutasitva_nev']=$adatom['projekt_elutasitva_nev'];
 }
 
 if(
 (!isset($eredmeny_keres[$adatom['user_ad']]['kell_e_meg_projekt_jovahagyas']))
 or
 (
  (isset($eredmeny_keres[$adatom['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
  ($eredmeny_keres[$adatom['user_ad']]['kell_e_meg_projekt_jovahagyas']==0)and
  ($adatom['kell_e_meg_projekt_jovahagyas']==1)
 )
 ){
  $eredmeny_keres[$adatom['user_ad']]['kell_e_meg_projekt_jovahagyas']=$adatom['kell_e_meg_projekt_jovahagyas'];
 }
 
 $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['tavollet']=$adatom['tavollet'];
 $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_ora']+=$adatom['rogzit_ora'];
 $eredmeny_keres[$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_perc']+=$adatom['rogzit_perc'];
 
 }
}

 return $eredmeny_keres;
}

//Bejelentkezett usernek hány aktív szervezetre van jóváhagyási jogosultsága!
function keres_aktuser_jovahagyhato_szerv_adat(){
 $eredmeny_keres="";
 // and mira_szerv.szerv_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT mira_szerv.szerv_nev,mira_szerv.szerv_id
 FROM `mira_szerv_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = mira_szerv_jovahagyo.user_ad
 inner join mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
 where
 mira_szerv_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' and 
 mira_user.user_inaktiv='0' and 
 mira_szerv.szerv_inaktiv='0' 

 order by mira_szerv.szerv_nev asc";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=$adatom['szerv_nev'];
 }
 return $eredmeny_keres;
}

//Bejelentkezett usernek hány aktív felettes jóváhagyási jogosultsága!
function keres_aktuser_felettes_jovahagyhato_user_adat(){
 $eredmeny_keres="";
 //and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT mira_user.user_ad
 FROM `mira_user_felettes_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = mira_user_felettes_jovahagyo.user_ad
 where
 mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' and 
 mira_user.user_inaktiv='0'  
 
 order by mira_user.user_nev asc";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['user_ad'];
 }
 return $eredmeny_keres;
}

//Bejelentkezett usernek hány aktív projekt jóváhagyási jogosultsága!
function keres_aktuser_projekt_jovahagyhato_user_adat(){
 $eredmeny_keres="";
 $sql="SELECT projekt_jovahagyo.projekt_id,projekt.projekt_nev
 FROM `projekt_jovahagyo` 
 inner join projekt ON projekt.projekt_id = projekt_jovahagyo.projekt_id 
 where projekt_jovahagyo.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
 order by projekt.projekt_nev asc";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['projekt_nev'];
 }
 return $eredmeny_keres;
}

function keress_projekt_jovahagyva_ho($user_ad,$rogzit_ho){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);
 $sql="SELECT 
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva_mikor,
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva_megj,
 mira_user_vissza_ki.user_nev as projekt_jovahagyo_elutasitva_ki_nev 
 FROM `rogzit_ho_projekt`
 left join mira_user as mira_user_vissza_ki ON mira_user_vissza_ki.user_ad = rogzit_ho_projekt.projekt_jovahagyo_elutasitva_ki
 where 
 rogzit_ho_projekt.user_ad='".$user_ad."' and 
 rogzit_ho_projekt.projekt_jovahagyo_elutasitva='1'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_jovahagyva_ho($user_ad,$rogzit_ho){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);
 $sql="SELECT rogzit_ho.*,
 mira_user_vissza_ki.user_nev as ellenorzesre_visszakuldve_ki_nev 
 FROM `rogzit_ho`
 left join mira_user as mira_user_vissza_ki ON mira_user_vissza_ki.user_ad = rogzit_ho.ellenorzesre_visszakuldve_ki
 where 
 rogzit_ho.user_ad='".$user_ad."' and 
 rogzit_ho.rogzit_ho='".$rogzit_ho."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_aktuser_ad_szervezethez_jovahagyok($user_ad){
 $eredmeny_keres="";
 $sql="SELECT mira_user_jovahagyo.user_nev,mira_user_jovahagyo.user_email
 FROM `mira_user` 
 inner join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id =	mira_user.szerv_id
 inner join mira_user as mira_user_jovahagyo ON mira_user_jovahagyo.user_ad  = mira_szerv_jovahagyo.user_ad and mira_user_jovahagyo.user_inaktiv ='0' and mira_user_jovahagyo.ful_jovahagy ='1' 
 left join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user.user_ad
 where 
 mira_user.user_ad='".$user_ad."'
 and mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo is NULL";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_aktuser_ad_szervezethez_jovahagyok_felettes($user_ad){
 $eredmeny_keres="";
 $sql="SELECT mira_user_felettes_jovahagyo_user.user_nev,mira_user_felettes_jovahagyo_user.user_email
 FROM `mira_user` 
 inner join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad = mira_user.user_ad
 inner join mira_user AS mira_user_felettes_jovahagyo_user ON mira_user_felettes_jovahagyo_user.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo and mira_user_felettes_jovahagyo_user.user_inaktiv ='0'
 where 
 mira_user.user_ad='".$user_ad."'
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_emailerthez_jovahagyok_csakszervezet($user_ad,$alkalom){
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
//Ha alkalom 1, akkor opciót is megnézni, hogy kér-e a jóváhagyó email értesítést
$eredmeny_keres="";

 //Szakterületi jóváhagyók
 $sql0="SELECT 
 mira_user_jova.user_nev,mira_user_jova.user_email,mira_user_jova.user_ad
 FROM `mira_user`
 left join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_user.szerv_id 
 left join mira_user as mira_user_jova ON mira_user_jova.user_ad=mira_szerv_jovahagyo.user_ad
 
 left join mira_user_felettes_jovahagyo ON 
	mira_user_felettes_jovahagyo.user_ad='".$user_ad."'
 left join mira_user as mira_user_fel_jo ON mira_user_fel_jo.user_ad=mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
 
 where
 mira_user.user_ad='".$user_ad."' and ";
 
 if($alkalom=="1")
  $sql0.=" mira_user_jova.email_jova_elso_szak='1' and ";
 
 $sql0.=" mira_user.user_inaktiv='0' and mira_user_jova.user_inaktiv='0' 
 AND 
(
 (mira_user_felettes_jovahagyo.user_ad IS NULL)
 or
 (mira_user_fel_jo.user_inaktiv='1')
)";
 
 $adat0=mysqli_query($GLOBALS['mysqli'],$sql0);
 while($adatom0=mysqli_fetch_assoc($adat0)){
 if(($adatom0['user_nev']!="")and($adatom0['user_email']!="")){
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom0['user_ad']]['nev']=$adatom0['user_nev'];
  $eredmeny_keres[$adatom0['user_ad']]['email']=$adatom0['user_email'];
 }
 }
 
 //Felettes jóváhagyók
 //mira_user_jova.email_vissza_szak = '1' AND 
  $sql0f="SELECT mira_user_jova.user_nev, mira_user_jova.user_email, mira_user_jova.user_ad
FROM `mira_user_felettes_jovahagyo`
LEFT JOIN mira_user AS mira_user_jova ON 
	mira_user_jova.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo AND 
	mira_user_jova.user_inaktiv = '0'
WHERE mira_user_felettes_jovahagyo.user_ad = '".$user_ad."'";
 if($alkalom=="1")
  $sql0f.=" and mira_user_jova.email_jova_elso_szak='1' ";
 $adat0f=mysqli_query($GLOBALS['mysqli'],$sql0f);
 while($adatom0f=mysqli_fetch_assoc($adat0f)){
  if(($adatom0f['user_nev']!="")and($adatom0f['user_email']!="")){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom0f['user_ad']]['nev']=$adatom0f['user_nev'];
  $eredmeny_keres[$adatom0f['user_ad']]['email']=$adatom0f['user_email'];
  }
 }
 return $eredmeny_keres;
}

function keres_emailerthez_jovahagyok_csak_projekt($user_ad,$rogzit_ho){
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);

 $eredmeny_keres="";

 //Projekt jóváhagyók megállapítása
 $sql1="SELECT 
 projekt_jovahagyo.projekt_id
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = rogzit_sor.projekt_id
 where
 rogzit.user_ad='".$user_ad."' and
 rogzit.rogzit_ho='".$rogzit_ho."' 
 group by projekt_jovahagyo.projekt_id";
 
 $projekt_jovahagyok="";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($projekt_jovahagyok))$projekt_jovahagyok=array();
  $projekt_jovahagyok[]=$adatom1['projekt_id'];
 }
 
 if(is_array($projekt_jovahagyok)){
 $sql2="SELECT 
 mira_user.user_nev,
 mira_user.user_email,
 mira_user.user_ad
 FROM `projekt` 
 left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.projekt_id = projekt.projekt_id and 
	rogzit_ho_projekt.user_ad='".$user_ad."' and
	rogzit_ho_projekt.rogzit_ho='".$rogzit_ho."' 
 left join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = projekt.projekt_id 
 left join mira_user ON mira_user.user_ad = projekt_jovahagyo.user_ad
 where
 rogzit_ho_projekt.projekt_id is NULL 
 and mira_user.user_inaktiv='0' 
 and (";
 foreach($projekt_jovahagyok as  $i => $projekt_id){
	 if($i>0)$sql2.="or";
	$sql2.="(projekt.projekt_id='".$projekt_id."')"; 
 }
 $sql2.=") order by projekt.projekt_nev ASC,mira_user.user_nev ASC";
 //echo $sql2;
 $adat2=mysqli_query($GLOBALS['mysqli'],$sql2);
 while($adatom2=mysqli_fetch_assoc($adat2)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom2['user_ad']]['nev']=$adatom2['user_nev'];
  $eredmeny_keres[$adatom2['user_ad']]['email']=$adatom2['user_email'];
 }
 return $eredmeny_keres;
 }
}

function keres_emailerthez_jovahagyok_visszakuld($user_ad,$rogzit_ho){
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);

 $eredmeny_keres="";
 
 //Szakterületi jóváhagyók
 $sql0="SELECT 
 mira_user_jova.user_nev,mira_user_jova.user_email,mira_user_jova.user_ad
 FROM `mira_user`
 left join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_user.szerv_id 
 left join mira_user as mira_user_jova ON 
	mira_user_jova.user_ad=mira_szerv_jovahagyo.user_ad and 
	mira_user_jova.email_vissza_szak='1' and 
	mira_user_jova.ful_jovahagy='1' and 
	mira_user_jova.user_inaktiv='0'
 
 left join mira_user_felettes_jovahagyo ON
	mira_user_felettes_jovahagyo.user_ad='".$user_ad."'
 left join mira_user as mira_user_fel_jo ON mira_user_fel_jo.user_ad=mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
 
 where
 mira_user.user_ad='".$user_ad."' 
AND 
(
 (mira_user_felettes_jovahagyo.user_ad IS NULL)
 or
 (mira_user_fel_jo.user_inaktiv='1')
)
AND mira_user_jova.user_ad IS NOT NULL
";
//
//echo $sql0;
 $adat0=mysqli_query($GLOBALS['mysqli'],$sql0);
 while($adatom0=mysqli_fetch_assoc($adat0)){
 if(($adatom0['user_nev']!="")and($adatom0['user_email']!="")){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom0['user_ad']]['nev']=$adatom0['user_nev'];
  $eredmeny_keres[$adatom0['user_ad']]['email']=$adatom0['user_email'];
 }
 }
 //Felettes szakterületi jóváhagyók
  $sql0f="SELECT mira_user_jova.user_nev, mira_user_jova.user_email, mira_user_jova.user_ad
FROM `mira_user_felettes_jovahagyo`
LEFT JOIN mira_user AS mira_user_jova ON 
	mira_user_jova.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo AND 
	mira_user_jova.email_vissza_szak = '1' AND 
	mira_user_jova.ful_jovahagy = '1' and 
	mira_user_jova.user_inaktiv = '0'
WHERE mira_user_felettes_jovahagyo.user_ad = '".$user_ad."'";
 $adat0f=mysqli_query($GLOBALS['mysqli'],$sql0f);
 while($adatom0f=mysqli_fetch_assoc($adat0f)){
 if(($adatom0f['user_nev']!="")and($adatom0f['user_email']!="")){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom0f['user_ad']]['nev']=$adatom0f['user_nev'];
  $eredmeny_keres[$adatom0f['user_ad']]['email']=$adatom0f['user_email'];
 }
 }
 //Projekt jóváhagyók megállapítása
 $sql1="SELECT 
 projekt_jovahagyo.projekt_id
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = rogzit_sor.projekt_id
 where
 rogzit.user_ad='".$user_ad."' and
 rogzit.rogzit_ho='".$rogzit_ho."' 
 group by projekt_jovahagyo.projekt_id";
 
 $projekt_jovahagyok="";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($projekt_jovahagyok))$projekt_jovahagyok=array();
  $projekt_jovahagyok[]=$adatom1['projekt_id'];
 }
 
 if(is_array($projekt_jovahagyok)){
 $sql2="SELECT 
 mira_user.user_nev,
 mira_user.user_email,
 mira_user.user_ad
 FROM `projekt` 
 left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.projekt_id = projekt.projekt_id and 
	rogzit_ho_projekt.user_ad='".$user_ad."' and
	rogzit_ho_projekt.rogzit_ho='".$rogzit_ho."' 
 left join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = projekt.projekt_id 
 left join mira_user ON mira_user.user_ad = projekt_jovahagyo.user_ad
 where
 rogzit_ho_projekt.projekt_id is NULL 
 and mira_user.email_vissza_proj='1' 
 and mira_user.ful_jovahagy='1' 
 and mira_user.user_inaktiv='0' 
 and (";
 foreach($projekt_jovahagyok as  $i => $projekt_id){
	 if($i>0)$sql2.="or";
	$sql2.="(projekt.projekt_id='".$projekt_id."')"; 
 }
 $sql2.=") order by projekt.projekt_nev ASC,mira_user.user_nev ASC";
 //echo $sql2;
 $adat2=mysqli_query($GLOBALS['mysqli'],$sql2);
 while($adatom2=mysqli_fetch_assoc($adat2)){
  if(($adatom2['user_nev']!="")and($adatom2['user_email']!="")){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom2['user_ad']]['nev']=$adatom2['user_nev'];
  $eredmeny_keres[$adatom2['user_ad']]['email']=$adatom2['user_email'];
  }
 }
 }
return $eredmeny_keres;
}

function keres_user_rogzites_vane_tovabbi_projet_jovahagyo($user_ad,$rogzit_ho){
/*
0- nincs, szakterületi jóváhagyó jön.
1-projekt jóváhagyók jönnek még
*/
 $eredmeny_keres="0";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);

 //Projekt jóváhagyók megállapítása
 $sql="SELECT 
 projekt_jovahagyo.projekt_id
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = rogzit_sor.projekt_id
 left join rogzit_ho_projekt ON 
	rogzit_ho_projekt.projekt_id = projekt_jovahagyo.projekt_id and
	rogzit_ho_projekt.user_ad ='".$user_ad."' and 
	rogzit_ho_projekt.rogzit_ho ='".$rogzit_ho."' 
 where
 rogzit.user_ad='".$user_ad."' and
 rogzit.rogzit_ho='".$rogzit_ho."' 
 AND rogzit_ho_projekt.projekt_id IS NULL
 group by projekt_jovahagyo.projekt_id";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres="1";
 }
 return $eredmeny_keres;
}

function keres_user_stat_projekt_jogok_vane(){
$eredmeny_keres="";
 $sql="SELECT mira_user_stat_proj.projekt_id
 FROM `mira_user_stat_proj` 
 inner join projekt ON projekt.projekt_id = mira_user_stat_proj.projekt_id
 where mira_user_stat_proj.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres="1";
 }
 return $eredmeny_keres;
}

function keres_user_stat_projekt_jogok(){
$eredmeny_keres="";
 $sql="SELECT mira_user_stat_proj.projekt_id,projekt.projekt_nev,projekt.projekt_inaktiv
 FROM `mira_user_stat_proj` 
 inner join projekt ON projekt.projekt_id = mira_user_stat_proj.projekt_id
 where mira_user_stat_proj.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_user_stat_szerv_jogok_vane(){
$eredmeny_keres="";
 $sql="SELECT mira_user_stat.szerv_id
 FROM `mira_user_stat` 
 inner join mira_szerv ON mira_szerv.szerv_id = mira_user_stat.szerv_id
 where mira_user_stat.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres="1";
 }
 return $eredmeny_keres;
}

function keres_tagvkod_nev_tomb(){
$eredmeny_keres="";
 $sql="SELECT
 mira_tagv_kod.tagv_kod,
 mira_tagv_kod.tagv_kod_nev
 FROM `mira_tagv_kod`
 ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
 return $eredmeny_keres;
}

function keres_user_stat_szerv_jogok(){
$eredmeny_keres="";
 $sql="SELECT mira_user_stat.szerv_id,mira_szerv.szerv_nev,mira_szerv.szerv_inaktiv
 FROM `mira_user_stat` 
 inner join mira_szerv ON mira_szerv.szerv_id = mira_user_stat.szerv_id
 where mira_user_stat.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_all($tabla_nev){
 $eredmeny_keres="";
 $sql="SELECT * FROM `$tabla_nev`";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;	
}

/*
function keres_all_mit_order($tabla_nev,$mit,$order,$sort){
 $eredmeny_keres="";
 $sql="SELECT ".$mit." FROM `$tabla_nev` order by $order $sort";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom[$mit];
 }
 return $eredmeny_keres;
}
*/

function keres_all_order($tabla_nev,$order,$sort){
 $eredmeny_keres="";
 $sql="SELECT * FROM `$tabla_nev` order by $order $sort";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;	
}

function keres_mit1($tabla_nev,$hol,$mire){
 $eredmeny_keres="";
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $sql="SELECT * FROM `$tabla_nev` where `$hol`='$mire'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_mit2($tabla_nev,$hol,$mire,$hol2,$mire2){
 $eredmeny_keres="";
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $sql="SELECT * FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_mit1_mit1($tabla_nev,$hol,$mire,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit1_mit1_kulcs($tabla_nev,$hol,$mire,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom[$mit]]='1';
 }
 return $eredmeny_keres;
}

function keres_mit1_mit1_csak_ertek($tabla_nev,$hol,$mire,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit2_mit1_csak_ertek($tabla_nev,$hol,$mire,$hol2,$mire2,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit2_mit1($tabla_nev,$hol,$mire,$hol2,$mire2,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit3_mit1($tabla_nev,$hol,$mire,$hol2,$mire2,$hol3,$mire3,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $mire3=mysqli_real_escape_string($GLOBALS['mysqli'],$mire3);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2' and `$hol3`='$mire3'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit4_mit1($tabla_nev,$hol,$mire,$hol2,$mire2,$hol3,$mire3,$hol4,$mire4,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $mire3=mysqli_real_escape_string($GLOBALS['mysqli'],$mire3);
 $mire4=mysqli_real_escape_string($GLOBALS['mysqli'],$mire4);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2' and `$hol3`='$mire3' and `$hol4`='$mire3'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function keres_mit1_order($tabla_nev,$hol,$mire,$order,$sort){
 $eredmeny_keres="";
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $sql="SELECT * FROM `$tabla_nev` where `$hol`='$mire' order by $order $sort";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_mit2_order($tabla_nev,$hol,$mire,$hol2,$mire2,$order,$sort){
 $eredmeny_keres="";
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $sql="SELECT * FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2' order by $order $sort";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

include_once('function_log.php');

function torles($tabla,$where_hol,$mit){
$where_hol=mysqli_real_escape_string($GLOBALS['mysqli'],$where_hol);
$mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
$sql="Delete from `$tabla` WHERE `$where_hol`='$mit'";
log_ment('del',$tabla,'',$where_hol,$mit);
//echo $sql;
if(mysqli_query($GLOBALS['mysqli'],$sql))
{
echo "";
}else{
echo "hiba";
echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
exit;
}
}

function torles2($tabla,$where_hol,$mit,$where_hol2,$mit2){
$where_hol=mysqli_real_escape_string($GLOBALS['mysqli'],$where_hol);
$where_hol2=mysqli_real_escape_string($GLOBALS['mysqli'],$where_hol2);
$mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
$mit2=mysqli_real_escape_string($GLOBALS['mysqli'],$mit2);
$sql="Delete from `$tabla` WHERE `$where_hol`='$mit' and `$where_hol2`='$mit2'";
log_ment('del',$tabla,'',$where_hol,$mit,$where_hol2,$mit2);
//echo $sql;
if(mysqli_query($GLOBALS['mysqli'],$sql))
{
echo "";
}else{
echo "hiba";
echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
exit;
}
}

function be_visz_insert_simabackup($tabla,$tomb){
 foreach($tomb as $b)
 {
 $mit="(";
 $mire="(";
 $i=0;
  foreach($b as $c => $d)
  {
   $i++;
   ////////$d=mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$d)))));
   if(!is_null($d))
    $d=mysqli_real_escape_string($GLOBALS['mysqli'],$d);
   if($i!=1) {$mit.=",";}
   $mit.="`".$c."`";
   if($i!=1) {$mire.=",";}
   
   if(!is_null($d))
    $mire.="'".$d."'";
   else
	$mire.="null";
  }
  $mit.=")";
  $mire.=")";
  //sql összerakása, majd végrehajtása
  $sql="insert INTO `".$tabla."` ".$mit." VALUES ".$mire."";
  //print $sql;
  
/*
	  if(mysqli_query($GLOBALS['mysqli'],$sql))
	  {
	   //print "Mentés sikeres<br>";
	   //$jo=1;
	  } else {
	  echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	  echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	   exit;
	  }
*/
try {
    if (!mysqli_query($GLOBALS['mysqli'], $sql)) {
        throw new Exception("MySQL error: " . mysqli_errno($GLOBALS['mysqli']) . ", " . mysqli_error($GLOBALS['mysqli'].' <br> sql'.$sql));
    }
} catch (Exception $e) {
    echo "<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
    echo "<br>" . $e->getMessage() . "<br>in sql: " . $sql;
    exit;
}

 }
 return '';
}

function be_visz_insert($tabla,$tomb){//Adatokat bevisz, új sor, lehet több is egyszerre.  $tmp[0]['nev']="Nagy Feró";

log_ment('bevitel',$tabla,$tomb,'','');

 foreach($tomb as $a =>$b){
 $mit="(";
 $mire="(";
 $i=0;
  foreach($b as $c => $d)
  {
   $i++;
   if(!is_null($d))
    $d=mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$d)))));
   if($i!=1) {$mit.=",";}
   $mit.="`".$c."`";
   
   if($i!=1) {$mire.=",";}

   if(!is_null($d))
	$mire.="'".$d."'";
   else
	$mire.="null";

  }
  $mit.=")";
  $mire.=")";
  //sql összerakása, majd végrehajtása
  $sql="replace INTO `".$tabla."` ".$mit." VALUES ".$mire."";
  //print $sql;

	  if(mysqli_query($GLOBALS['mysqli'],$sql))
	  {
	   //print "Mentés sikeres<br>";
	   $jo=1;
	  } else {
	  if($GLOBALS['test_sql_hibaki']=='0'){
	   echo"<b><font color=red>Valami hiba történt!</font></b>";
	  }else{
	   echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	   echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	  }
	   exit;
	  }

 }
 //return $jo;
}

function be_visz_replace($tabla,$tomb){//Adatokat bevisz, új sor, lehet több is egyszerre.  $tmp[0]['nev']="Nagy Feró";

log_ment('bevitel',$tabla,$tomb,'','');

 foreach($tomb as $a =>$b){
 $mit="(";
 $mire="(";
 $i=0;
  foreach($b as $c => $d)
  {
   $i++;
   if(!is_null($d))
   $d=mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$d)))));
   if($i!=1) {$mit.=",";}
   $mit.="`".$c."`";
   if($i!=1) {$mire.=",";}
   $mire.="'".$d."'";
  }
  $mit.=")";
  $mire.=")";
  //sql összerakása, majd végrehajtása
  $sql="replace INTO `".$tabla."` ".$mit." VALUES ".$mire."";
  //print $sql.'<br>';

	  if(mysqli_query($GLOBALS['mysqli'],$sql))
	  {
	   //print "Mentés sikeres<br>";
	   $jo=1;
	  } else {
	  echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	  echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	   exit;
	  }

 }
 return $jo;
}

function mod_egy_fel_tom($tabla,$tomb,$where_hol,$where_mi){

log_ment('mod',$tabla,$tomb,$where_hol,$where_mi);

$where_mi=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi);
$sql="UPDATE `".$tabla."` SET ";
$i=0;
foreach($tomb as $a => $b)
{
if($i>0)
 $sql.=", ";
$i++;
$a=mysqli_real_escape_string($GLOBALS['mysqli'],$a);
//if(($b=='')or($b!=null))
if(!is_null($b))
 //$sql.="`".$a."` ='".mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags($b))."' ";
 $sql.="`".$a."` ='".mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$b)))))."' ";
else
 $sql.="`".$a."` = null ";	
}
$sql.="WHERE ";

if($where_mi!=null)
 $sql.="`".$where_hol."`='".$where_mi."'";
else
 $sql.="`".$where_hol."` is null ";
//echo $sql."<br>";
//exit;
	if(mysqli_query($GLOBALS['mysqli'],$sql))
	{
	 //print "<br>Módosítás sikeres";
	} else {
	echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	exit;
	}

}


/*
function mod_egy_fel_tom($tabla,$tomb,$where_hol,$where_mi){
$where_mi=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi);
$sql="UPDATE `".$tabla."` SET ";
$i=0;
foreach($tomb as $a => $b)
{
if($i>0)
 $sql.=", ";
$i++;
$a=mysqli_real_escape_string($GLOBALS['mysqli'],$a);
$b=mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$b)))));
if($b!="NULL")
 $sql.="`".$a."` ='".$b."' ";
else
 $sql.="`".$a."` =".$b." ";	
}
$sql.="WHERE `".$where_hol."`='".$where_mi."'";
//echo $sql."<br>";
//exit;
	if(mysqli_query($GLOBALS['mysqli'],$sql))
	{
	 //print "<br>Módosítás sikeres";
	} else {
	echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	exit;
	}

}
*/

function mod_egy_fel_tom2($tabla,$tomb,$where_hol,$where_mi,$where_hol2,$where_mi2){

log_ment('mod',$tabla,$tomb,$where_hol,$where_mi,$where_hol2,$where_mi2);

$where_mi=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi);
$where_mi2=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi2);
$sql="UPDATE `".$tabla."` SET ";
$i=0;
foreach($tomb as $a => $b)
{
if($i>0)
 $sql.=", ";
$i++;
$a=mysqli_real_escape_string($GLOBALS['mysqli'],$a);
if($b!==null)
 $sql.="`".$a."` ='".mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$b)))))."' ";
else
 $sql.="`".$a."` = null ";	
}
$sql.="WHERE `".$where_hol."`='".$where_mi."' and `".$where_hol2."`='".$where_mi2."'";
//echo $sql."<br>";
//exit;
	if(mysqli_query($GLOBALS['mysqli'],$sql))
	{
	 //print "<br>Módosítás sikeres";
	} else {
	echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	exit;
	}

}


?>
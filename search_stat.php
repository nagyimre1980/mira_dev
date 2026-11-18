<?php
//session_start();
session_start(['read_and_close' => true]);
include_once("config_uj.php");

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: no-cache ");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

if(
(isset($_POST['mod']))
and($_POST['mod']!="")
){
	
switch($_POST['mod']){

 case'stat_leker_user':
  //stat_leker_user();
  jovahagy_melyik_user("all","");
 break;
 
 case'stat_leker_user_stat':
  //stat_leker_user();
  jovahagy_melyik_user("all","stat");
 break;
 
 case'jovahagy_melyik_user':
  jovahagy_melyik_user("hely","");
 break;

 case'stat_leker_projekt_stat':
  //stat_leker_user();
  stat_melyik_projekt("all","stat");
 break;
 
 case'stat_leker_szerv_stat':
  //stat_leker_user();
  stat_melyik_szerv("all","stat");
 break;
 
}

}

function stat_melyik_szerv($modszer,$holfut){
$tomb=keres_user_ki_stat_szerv($modszer,$holfut);
echo json_encode($tomb);
}

function keres_user_ki_stat_szerv($modszer,$holfut){
$eredmeny_keres="";

$where_search='';
/*
$_POST['q']=urldecode($_POST['q']);
$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);

if($_POST['q']!=""){
 $where_search=' mira_szerv.szerv_nev like "'.$_POST['q'].'%" and ';
}
*/

if($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']!=1){
//Ha csak bizonyos projektekre van joga
 $join=" inner join mira_user_stat ON mira_user_stat.szerv_id=mira_szerv.szerv_id
 and mira_user_stat.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
}else{
  $join="";
}
//WHERE 
//'.$where_search.'
//mira_szerv.szerv_tagv="'.$_SESSION[$GLOBALS['sessionname']]['tagv'].'"
$sql='
SELECT mira_szerv.szerv_id, mira_szerv.szerv_nev,mira_szerv.szerv_inaktiv
FROM `mira_szerv`
'.$join.'
 order by mira_szerv.szerv_nev asc';

$adat=mysqli_query($GLOBALS['mysqli'],$sql);
$i=0;
//echo $sql;
 if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]['id']='all';
  $eredmeny_keres[0]['text']='Összes';
  $eredmeny_keres[0]['sorsz']=0;
  $i++;
 }
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   
  $eredmeny_keres[$i]['id']=$adatom['szerv_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerv_nev'];
  
  if($adatom['szerv_inaktiv']=="1"){
   $eredmeny_keres[$i]['text'].="  (inaktív)";
  }
  $eredmeny_keres[$i]['sorsz']=$i;
 $i++;
 }
 mysqli_close($GLOBALS['mysqli']);
 return $eredmeny_keres;
}


function stat_melyik_projekt($modszer,$holfut){
$tomb=keres_user_ki_stat_projekt($modszer,$holfut);
echo json_encode($tomb);
}

function keres_user_ki_stat_projekt($modszer,$holfut){
$eredmeny_keres="";

/*
echo '<pre>';
print_r($_SESSION[$GLOBALS['sessionname']]);
echo '</pre>';
*/

$where_search='';

if((isset($_POST['idoszak_ev']))and($_POST['idoszak_ev']!=''))
 $ev=$_POST['idoszak_ev'];
else $ev='';

if((isset($_POST['idoszak_ho']))and($_POST['idoszak_ho']!='')
and($_POST['idoszak_ho']!='all')
){
 $ho=$_POST['idoszak_ho'];
 if($ho<10)$ho_ki='0'.$ho;
 else $ho_ki=$ho;
}else{
 $ho_ki='';
}

if(($ev!='')and($ho_ki!='')){
 $date_szur_kezd=$ev.'-'.$ho_ki.'-'.'01';
 $date_szur_veg=$ev.'-'.$ho_ki.'-'.'31';
  
  /*
  ( (projekt.projekt_kezd_date>='".$date_szur_kezd."') and (projekt.projekt_kezd_date<='".$date_szur_veg."') )
   or
  */
 $sql_nap="
  ( (projekt.projekt_kezd_date is null) or 
   
   (projekt.projekt_kezd_date<='".$date_szur_veg."')

  )
  and
  ( (projekt.projekt_veg_date is null) or 
  (projekt.projekt_veg_date>='".$date_szur_kezd."')  
  )
   ";
}else{
 $sql_nap="";
}
/*
$_POST['q']=str_replace("*","%",urldecode($_POST['q']));
$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);

if($_POST['q']!=""){
 $where_search=' projekt.projekt_nev like "'.$_POST['q'].'%" and ';
}
*/

if($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']!=1){
//Ha csak bizonyos projektekre van joga
 $join=" inner join mira_user_stat_proj ON mira_user_stat_proj.projekt_id=projekt.projekt_id
 and mira_user_stat_proj.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'";
}else{
  $join="";
}

/*
WHERE 
'.$where_search.'
projekt.projekt_tagv="'.$_SESSION[$GLOBALS['sessionname']]['tagv'].'"
*/

$sql='
SELECT projekt.projekt_id, projekt.projekt_nev,projekt.projekt_inaktiv
FROM `projekt`
'.$join;

if($sql_nap!='')
 $sql.=' where '.$sql_nap;
$sql.=' order by projekt.projekt_nev asc';

$adat=mysqli_query($GLOBALS['mysqli'],$sql);
$i=0;
//echo $sql;
 if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]['id']='all';
  $eredmeny_keres[0]['text']='Összes';
  $eredmeny_keres[0]['sorsz']=0;
  $i++;
 }
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   
  $eredmeny_keres[$i]['id']=$adatom['projekt_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_nev'];
  
  if($adatom['projekt_inaktiv']=="1"){
   $eredmeny_keres[$i]['text'].="  (inaktív)";
  }
  $eredmeny_keres[$i]['sorsz']=$i;
 $i++;
 }
 mysqli_close($GLOBALS['mysqli']);
 return $eredmeny_keres;
}

function jovahagy_melyik_user($modszer,$holfut){
$tomb=keres_user_ki_jovagyasos($modszer,$holfut);
echo json_encode($tomb);
}

function keres_user_ki_jovagyasos($modszer,$holfut){
$eredmeny_keres="";
$_POST['szerv_id']=mysqli_real_escape_string($GLOBALS['mysqli'],urldecode($_POST['szerv_id']));
$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ho']);
$_POST['q']=str_replace("*","%",urldecode($_POST['q']));

if($_POST['q']!=""){
 //$where_search=" and mira_user.user_nev like '".$_POST['q']."%' ";
 $where_search=" and (mira_user.user_nev like '".$_POST['q']."%' ";
 $where_search.=" or mira_user.user_ad like '".$_POST['q']."%' ";
 $where_search.=" or mira_user.user_tsz like '".$_POST['q']."%' )";
}else{
 $where_search="";
}

//Rögzítés kezdete user - eleje

if($ho=='all'){
	$ho_nullas="12";
	$ho_nullas_v="01";
}elseif($ho<10) $ho_nullas_v=$ho_nullas="0".$ho;
else $ho_nullas_v=$ho_nullas=$ho;

$where_search.=" and
(
 (mira_user.user_kezd_date='0000-00-00')
 or
 (mira_user.user_kezd_date <= '".$ev."-".$ho_nullas."-31')
) ";

$where_search.=" and
(
 (mira_user.user_veg_date='0000-00-00')
 or
 (mira_user.user_veg_date >= '".$ev."-".$ho_nullas_v."-01')
) ";

$sql="SELECT mira_user.user_nev,mira_user.user_inaktiv,mira_user.user_ad
,mira_user.user_tsz
FROM `mira_user` ";

$kell_groupby=0;

if(($_POST['szerv_id']!="all")and($_POST['szerv_id']!="all_f")){//szervezeti


//Projekt jóváhagyás-e a szerv_id
$projekt_e = substr($_POST['szerv_id'],0,8);
if($projekt_e=='projekt_'){
 $projekt_id = substr($_POST['szerv_id'],8);
 if($ho<10)$ho='0'.$ho;
 $sql.='
 inner join rogzit ON 
	rogzit.user_ad=mira_user.user_ad and
	rogzit.rogzit_ho="'.$ev.'-'.$ho.'" 
 inner join rogzit_sor ON
	rogzit_sor.rogzit_id = rogzit.rogzit_id and 
	rogzit_sor.projekt_id="'.$projekt_id.'"
 ';
 $sql.="where ";
 $kell_groupby=1;
}else{
$sql.="where(";
$sql_sz="";
$tomb_szerv=explode(",",$_POST['szerv_id']);
foreach($tomb_szerv as $ert_szerv_id){
if($sql_sz!="")$sql_sz.="or";
 $sql_sz.="(mira_user.szerv_id='".$ert_szerv_id."')";
}
$sql.=$sql_sz.") and ";

if($modszer!="all"){
	/*
$tomb_van_felettes_nemkell=keres_aktuser_felettes_jovahgyokkal_rendlekezo_userek();
if(is_array($tomb_van_felettes_nemkell)){
 foreach($tomb_van_felettes_nemkell as $user_ad_nemkell){
  $sql.=" mira_user.user_ad!='".$user_ad_nemkell."' and ";
 }
}
*/
}

}

}elseif($_POST['szerv_id']=="all_f"){//Felettes
 $sql.="where ";
 $tomb_felettes_jovahagyhato_user=keres_aktuser_felettes_jovahagyhato_user_adat();
 if(is_array($tomb_felettes_jovahagyhato_user)){
 $sql_user_fel="";
 foreach($tomb_felettes_jovahagyhato_user as $user_ad_fel){
	if($sql_user_fel!="")$sql_user_fel.="or";
	$sql_user_fel.="(mira_user.user_ad='".$user_ad_fel."')";
 }
 $sql.="(".$sql_user_fel.") and ";
 }
}



if($holfut!="stat")//stat esetén teljes kell. Inaktívval
 $sql.=" mira_user.user_inaktiv='0' and ";
elseif(($_POST['szerv_id']=="all")and($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']==1)){
 $sql.=" where ";
}elseif($_POST['szerv_id']=="all"){
 $sql.=" where ";
  $tomb_szerv=keres_user_stat_szerv_jogok();
  $sql_k="";
  foreach($tomb_szerv as $ert_sz){
	  if($sql_k!="")$sql_k.="or";
	  $sql_k.="(mira_user.szerv_id='".$ert_sz['szerv_id']."')";
  }
  if($sql_k!="")$sql_k="(".$sql_k.")and ";
  $sql.=$sql_k;
}
//$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' ";
//$sql.=" and ";
$sql.=" mira_user.ful_rogzit='1' ";
$sql.=" ".$where_search;

if( $kell_groupby==1)
 $sql.=" group by mira_user.user_ad";

$sql.=" order by mira_user.user_nev asc";
//limit 100
//echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 
/* if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){*/
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]['id']="all";
  $eredmeny_keres[0]['text']="Összes";
  $eredmeny_keres[0]['sorsz']=0;
  $i++;
 //}
 
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']=$adatom['user_ad'];
  if($adatom['user_inaktiv']=="1")
   //$ki_in=" (inaktív)";
   $ki_in=" inaktív";
  else
   $ki_in="";
  //$eredmeny_keres[$i]['text']=$adatom['user_nev'].$ki_in;
  //$eredmeny_keres[$i]['text']=$adatom['user_nev']." <i>(".$adatom['user_tsz'].", ".$adatom['user_ad'].$ki_in.")</li>";
  $eredmeny_keres[$i]['text']=$adatom['user_nev']." (".$adatom['user_tsz'].", ".$adatom['user_ad'].$ki_in.")";
  
  //$eredmeny_keres[$i]['title']="<b>Azonosító:</b> ".$adatom['user_ad'];
  //$eredmeny_keres[$i]['title'].="<br><b>Név:</b> ".$adatom['user_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 $i++;
 }
 return $eredmeny_keres;
}

//Kinek van felettes jóváhagyója
/*
function keres_aktuser_felettes_jovahgyokkal_rendlekezo_userek(){
 $eredmeny_keres="";
 $sql="SELECT mira_user.user_ad
 FROM `mira_user_felettes_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = mira_user_felettes_jovahagyo.user_ad
 where
 mira_user.user_inaktiv='0' and 
 mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['user_ad'];
 }
 return $eredmeny_keres;
}
*/

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

/*
function stat_leker_user(){


//1 Keressük le azokat a projekteket, amire a usernek nincs rögzítve semmi arra a napra
//$tomb=keres_projekt_ki();
$tomb=keres_user_ki();
echo json_encode($tomb);

}



function keres_user_ki(){
$eredmeny_keres="";
$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);

$_POST['q']=str_replace("*","%",urldecode($_POST['q']));

if($_POST['q']!=""){
 $where_search=" and mira_user.user_nev like '".$_POST['q']."%' ";
}else{
 $where_search="";
}

$sql="SELECT *

FROM `mira_user`
where
mira_user.user_inaktiv='0' 
and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' 
".$where_search."
order by mira_user.user_nev";
//echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 
 if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]['id']="all";
  $eredmeny_keres[0]['text']="Összes";
  $i++;
 }
 
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']=$adatom['user_ad'];
  $eredmeny_keres[$i]['text']=$adatom['user_nev'];
  //$eredmeny_keres[$i]['title']="<b>Azonosító:</b> ".$adatom['user_ad'];
  //$eredmeny_keres[$i]['title'].="<br><b>Név:</b> ".$adatom['user_nev'];
 $i++;
 }
 return $eredmeny_keres;
}
*/
?>
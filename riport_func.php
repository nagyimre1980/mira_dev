<?php


function riport_tervteny_adat_ment(){

if(isset($_POST['tipus1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus1']=$_POST['tipus1'];
}

if(isset($_POST['tipus2'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus2']=$_POST['tipus2'];
}


echo 'ok$;$';
}

function keress_riport_ful_ki_evlist_teny3(){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ev
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3  = '1' 
 group by backup_ver.backup_ver_ev 
 order by backup_ver.backup_ver_ev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evlist_teny3_3(){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ev
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_3  = '1' 
 group by backup_ver.backup_ver_ev 
 order by backup_ver.backup_ver_ev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evlist_teny3_2(){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ev
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_2  = '1' 
 group by backup_ver.backup_ver_ev 
 order by backup_ver.backup_ver_ev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evlist_teny3_1_1(){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ev
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1  = '1' 
 group by backup_ver.backup_ver_ev 
 order by backup_ver.backup_ver_ev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evlist_nonp(){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ev
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_2 = '1' 
 group by backup_ver.backup_ver_ev 
 order by backup_ver.backup_ver_ev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_default,
 backup_ver.backup_ver_ev,
 backup_ver.backup_ver_ho
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3  = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3_3($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_default,
 backup_ver.backup_ver_ev,
 backup_ver.backup_ver_ho
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_3  = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3_2($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_default,
 backup_ver.backup_ver_ev,
 backup_ver.backup_ver_ho
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_2  = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3_1_1_szervcsop_all(){
$eredmeny_keres="";
 $sql="SELECT 
 mira_szerv_csoport.mira_szerv_csoport_id,
 mira_szerv_csoport.mira_szerv_csoport_nev
 FROM `mira_szerv_csoport`
 order by mira_szerv_csoport.mira_szerv_csoport_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3_1_1_szervcsop(){
$eredmeny_keres="";
 $sql="SELECT 
 mira_szerv_csoport.mira_szerv_csoport_id,
 mira_szerv_csoport.mira_szerv_csoport_nev
 FROM `mira_user_riport_311_szervcsop`
 inner join mira_szerv_csoport ON mira_szerv_csoport.mira_szerv_csoport_id = mira_user_riport_311_szervcsop.mira_szerv_csoport_id
 where 
 mira_user_riport_311_szervcsop.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
 order by mira_szerv_csoport.mira_szerv_csoport_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny3_1_1($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_default,
 backup_ver.backup_ver_ev,
 backup_ver.backup_ver_ho
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1  = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_nonp($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_default,
 backup_ver.backup_ver_ev,
 backup_ver.backup_ver_ho
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_2 = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}





function riport_tervteny_ev_change_hole(){
if((isset($_POST['tipus']))and($_POST['tipus']=='teny')){
 $tomb=keres_search2_riport_tervteny_sel_ho_teny();
}else{//terv
 $tomb=keres_search2_riport_tervteny_sel_ho_terv();
}
echo 'ok$;$';
echo json_encode($tomb);
}

function keres_search2_riport_tervteny_sel_ho_terv(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);
$sql='SELECT backup_terv.backup_terv_ho 
FROM `backup_terv`
where
backup_terv.backup_terv_ev="'.$_POST['ev'].'" 
group by backup_terv.backup_terv_ho 
order by backup_terv.backup_terv_ho asc ';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_terv_ho'];
  $eredmeny_keres[$i]['text']=ho_ki($adatom['backup_terv_ho']);
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_riport_tervteny_sel_ho_teny(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);
$sql='SELECT backup_ver.backup_ver_ho 
FROM `backup_ver`
where
backup_ver.backup_ver_ev="'.$_POST['ev'].'" and 
backup_ver.backup_ver_teny3="1" and backup_ver.backup_ver_default="1" 
group by backup_ver.backup_ver_ho 
order by backup_ver.backup_ver_ho asc ';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_ver_ho'];
  $eredmeny_keres[$i]['text']=ho_ki($adatom['backup_ver_ho']);
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function riport_tervteny_szerv_listle(){
if(isset($_POST['ev'])){
 $tomb=keres_search2_riport_tervteny_szerv_listle_teny();
 echo 'ok$;$';
 echo json_encode($tomb);
}else{
 echo 'adathiány';
}
}

function keres_search2_riport_tervteny_szerv_listle_teny(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);

$where='';
$where_h='';
if($_POST['ho']!=''and($_POST['ho']!='all')){
 $tomb_ho=explode(',',$_POST['ho']);
 foreach($tomb_ho as $ho){
	 if($where_h!='')$where_h.='or';
	 $where_h.='(backup_ver.backup_ver_ho="'.$ho.'")';
 }
 $where=' and ('.$where_h.')';
}else{
 //Ekkor nem kell hóra szűrni!
}

$sql='SELECT 
backup_szerv.szerv_id,
backup_szerv.szerv_nev,
backup_szerv.szerv_szolg_kod
FROM `backup_ver`
inner join backup_szerv ON backup_szerv.backup_ver_id=backup_ver.backup_ver_id and backup_szerv.szerv_inaktiv="0"
where 
backup_ver.backup_ver_ev="'.$_POST['ev'].'"'.$where.'
group by backup_szerv.szerv_id 
order by backup_szerv.szerv_nev asc
';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerv_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerv_nev'];
  $eredmeny_keres[$i]['title']=$adatom['szerv_nev'].' , szolgáltatási kód: '.$adatom['szerv_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function riport_tervteny_projekt_listle(){
if(isset($_POST['ev'])){
 $tomb=keres_search2_riport_tervteny_projekt_listle();
 echo 'ok$;$';
 echo json_encode($tomb);
}else{
 echo 'adathiány';
}
}

function keres_search2_riport_tervteny_projekt_listle(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);

$where='';
$where_h='';
if($_POST['ho']!=''and($_POST['ho']!='all')){
 $tomb_ho=explode(',',$_POST['ho']);
 foreach($tomb_ho as $ho){
	 if($where_h!='')$where_h.='or';
	 $where_h.='(backup_ver.backup_ver_ho="'.$ho.'")';
 }
 $where=' and ('.$where_h.')';
}else{
 //Ekkor nem kell hóra szűrni!
}

$sql='SELECT 
backup_pojekt.projekt_id,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_szolg_kod
FROM `backup_ver`
inner join backup_pojekt ON backup_pojekt.backup_ver_id=backup_ver.backup_ver_id and backup_pojekt.projekt_inaktiv="0"
where 
backup_ver.backup_ver_ev="'.$_POST['ev'].'"'.$where.'
group by backup_pojekt.projekt_id 
order by backup_pojekt.projekt_nev asc
';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['projekt_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_nev'];
  $eredmeny_keres[$i]['title']=$adatom['projekt_nev'].' , szolgáltatási kód: '.$adatom['projekt_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function riport_tervteny_szolgkod_listle(){
if(isset($_POST['ev'])){
 $tomb=keres_search2_riport_tervteny_szolgkod_listle();
 echo 'ok$;$';
 echo json_encode($tomb);
}else{
 echo 'adathiány';
}
}

function keres_search2_riport_tervteny_szolgkod_listle(){
$eredmeny_keres="";

$sql='SELECT 
mira_szolg_kod.szolg_kod,
mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
order by mira_szolg_kod.szolg_kod asc';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  //$eredmeny_keres[$i]['title']=$adatom['projekt_nev'].' , szolgáltatási kód: '.$adatom['projekt_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

/*
function keres_search2_riport_tervteny_szolgkod_listle_old(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);
$where='';
$where_h='';
if($_POST['ho']!=''and($_POST['ho']!='all')){
 $tomb_ho=explode(',',$_POST['ho']);
 foreach($tomb_ho as $ho){
	 if($where_h!='')$where_h.='or';
	 $where_h.='(backup_ver.backup_ver_ho="'.$ho.'")';
 }
 $where=' and ('.$where_h.')';
}else{
 //Ekkor nem kell hóra szűrni!
}

$sql='SELECT 
backup_szolg_kod.szolg_kod,
backup_szolg_kod.szolg_kod_nev
FROM `backup_ver`
inner join backup_szolg_kod ON backup_szolg_kod.backup_ver_id=backup_ver.backup_ver_id and backup_szolg_kod.szolg_kod_inaktiv="0"
where 
backup_ver.backup_ver_ev="'.$_POST['ev'].'"'.$where.'
group by backup_szolg_kod.szolg_kod 
order by backup_szolg_kod.szolg_kod asc
';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  //$eredmeny_keres[$i]['title']=$adatom['projekt_nev'].' , szolgáltatási kód: '.$adatom['projekt_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}
*/

function riport_tervteny_tagv_listle(){
if(isset($_POST['ev'])){
 $tomb=keres_search2_riport_tervteny_tagv_listle();
 echo 'ok$;$';
 echo json_encode($tomb);
}else{
 echo 'adathiány';
}
}

function keres_search2_riport_tervteny_tagv_listle(){
$eredmeny_keres="";

$sql='SELECT 
mira_tagv_kod.tagv_kod,
mira_tagv_kod.tagv_kod_nev
FROM `mira_tagv_kod` 
order by mira_tagv_kod.tagv_kod asc ';

  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  //$eredmeny_keres[$i]['title']=$adatom['projekt_nev'].' , szolgáltatási kód: '.$adatom['projekt_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

/*
function keres_search2_riport_tervteny_tagv_listle_old(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);

$where='';
$where_h='';
if($_POST['ho']!=''and($_POST['ho']!='all')){
 $tomb_ho=explode(',',$_POST['ho']);
 foreach($tomb_ho as $ho){
	 if($where_h!='')$where_h.='or';
	 $where_h.='(backup_ver.backup_ver_ho="'.$ho.'")';
 }
 $where=' and ('.$where_h.')';
}else{
 //Ekkor nem kell hóra szűrni!
}

$sql='SELECT 
backup_tagv_kod.tagv_kod,
backup_tagv_kod.tagv_kod_nev
FROM `backup_ver`
inner join backup_tagv_kod ON backup_tagv_kod.backup_ver_id=backup_ver.backup_ver_id and backup_tagv_kod.tagv_kod_inaktiv="0"
where 
backup_ver.backup_ver_ev="'.$_POST['ev'].'"'.$where.'
group by backup_tagv_kod.tagv_kod 
order by backup_tagv_kod.tagv_kod asc
';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  //$eredmeny_keres[$i]['title']=$adatom['projekt_nev'].' , szolgáltatási kód: '.$adatom['projekt_szolg_kod'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}
*/

function riport_tervteny_user_listle(){
if(isset($_POST['ev'])){
 $tomb=keres_search2_riport_tervteny_user_listle();
 echo 'ok$;$';
 echo json_encode($tomb);
}else{
 echo 'adathiány';
}
}

function keres_search2_riport_tervteny_user_listle(){
$eredmeny_keres="";
$_POST['ev']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['ev']);

$where='';
$where_h='';
if($_POST['ho']!=''and($_POST['ho']!='all')){
 $tomb_ho=explode(',',$_POST['ho']);
 foreach($tomb_ho as $ho){
	 if($where_h!='')$where_h.='or';
	 $where_h.='(backup_ver.backup_ver_ho="'.$ho.'")';
 }
 $where=' and ('.$where_h.')';
}else{
 //Ekkor nem kell hóra szűrni!
}

$sql='SELECT 
backup_user.user_ad,
backup_user.user_nev
FROM `backup_ver`
inner join backup_user ON backup_user.backup_ver_id=backup_ver.backup_ver_id and backup_user.user_inaktiv="0"
where 
backup_ver.backup_ver_ev="'.$_POST['ev'].'"'.$where.'
group by backup_user.user_ad 
order by backup_user.user_nev asc
';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
 //echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['user_ad'];
  $eredmeny_keres[$i]['text']=$adatom['user_nev'];
  $eredmeny_keres[$i]['title']=$adatom['user_ad'];
  //$eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

?>
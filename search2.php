<?php
session_start();
include_once("config_uj.php");
include_once("function_login.php");
//include_once("function.php");
//include_once("function_mysql.php");
login();
session_write_close(); 
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 echo "logout";
 exit;
}

if(isset($_POST['mod'])){
switch($_POST['mod']){

 case'admin_penznem_uj':
  search2_admin_penznem_uj();
 break;
 
 case'admin_kpi_sorszam':
  admin_kpi_sorszam();
 break;
 
 case'admin_kpi_szolg_kod':
  admin_kpi_szolg_kod();
 break;
 
 case'admin_szerztipus_uj':
 case'admin_szerztipus_mod':
  admin_szerztipus_uj();
 break;
 
 case'admin_szerztipus_ujall':
  admin_szerztipus_ujall();
 break;
 
 case'admin_szerztipus_keres':
  admin_szerztipus_ker_keres();
 break;
 
 case'admin_szolgcsop_uj':
 case'admin_szolgcsop_mod':
  admin_szolgcsop_uj();
 break;

 case'admin_elsztipus_uj':
 case'admin_elsztipus_mod':
  admin_elsztipus_uj();
 break;

 case'admin_nattipus_uj':
 case'admin_nattipus_mod':
  admin_nattipus_uj();
 break;
 
 case'admin_usergazda_uj':
 case'admin_usergazda_mod':
  admin_usergazda_uj();
 break;
 
 case'admin_szerzalapadat_uj':
 /*case'admin_szerzalapadat_all':*/
  admin_szerzalapadat_uj();
 break;
 
 case'admin_szolgkapadat_ker1':
  admin_szolgkapadat_ker1();
 break;
 
 case'admin_kapcs_tulaj':
  admin_kapcs_tulaj();
 break;
 
 case'admin_kapcs_torzs':
  search2_admin_kapcs_torzs();
 break;
 
 case'admin_tagvkod_all':
  search2_admin_tagvkod_all();
 break;
 case'admin_tagvkod':
  search2_admin_tagvkod();
 break;
 case'admin_tagvkod_uj':
  search2_admin_tagvkod_uj();
 break;
 case'admin_tagvkod_uj_all':
  search2_admin_tagvkod_uj_all();
 break;
 
 case'admin_devizanem_uj':
  admin_devizanem_uj();
 break;

 case'admin_szolgkod':
  search2_admin_szolgkod();
 break;
 
 
 case'admin_szolgkod_csopid':
  search2_admin_szolgkod_csopid();
 break;
 
 case'admin_szolgkod_uj':
  search2_admin_szolgkod_uj();
 break;

case'admin_szolgkod_csop_uj':
  search2_admin_szolgkod_csop_uj();
 break;
 
 case'admin_szolgkod_ujtorzsossze':
  search2_admin_szolgkod_ujtorzsossze();
 break;
 case'admin_szolgkod_uj_all':
  search2_admin_szolgkod_uj_all();
 break;

 case'admin_csopnev_uj':
  search2_admin_csopnev_uj();
 break;
 case'admin_csopnev':
  search2_admin_csopnev();
 break;

 case'admin_kat_uj':
  search2_admin_kat_uj();
 break;
 case'admin_kat':
  search2_admin_kat();
 break;
 
 case'riport_tervteny_sel_ev1':
 case'riport_tervteny_sel_ev2':
  search2_riport_tervteny_sel_ev();
 break;

 case'riport_tervteny_sel_tervalaptipus1':
 case'riport_tervteny_sel_tervalaptipus2':
  search2_riport_tervteny_sel_tipus();
 break;

 case'admin_ujhibajavitas_ho':
  search2_admin_ujhibajavitas_ho();
 break;

 case'admin_ujhibajavitas_nap':
  admin_ujhibajavitas_nap();
 break;
 
 case'admin_ujhibajavitas_backup_ver_id':
  search2_admin_ujhibajavitas_backup_ver_id();
 break;
 
 case'admin_ujhibajavitas_user_ad':
  search2_admin_ujhibajavitas_user_ad();
 break;
 
 case'projekt_backup_ver_id':
  search2_projekt_backup_ver_id();
 break; 
}
}


function search2_projekt_backup_ver_id(){
$tomb=keres_search2_projekt_backup_ver_id();
echo json_encode($tomb);
}

function keres_search2_projekt_backup_ver_id(){
 $eredmeny_keres="";
 $backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
 $sql="SELECT 
 backup_pojekt.backup_pojekt_id,
 backup_pojekt.projekt_id,
 backup_pojekt.projekt_nev
 FROM `backup_pojekt` 
 where 
 backup_pojekt.backup_ver_id='".$backup_ver_id."' and 
 backup_pojekt.projekt_inaktiv='0'
 order by backup_pojekt.projekt_nev asc";
 //echo $sql;exit;
  $i=-1;    
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['uj_pojekt_id']=$adatom['projekt_id'];
  $eredmeny_keres[$i]['id']=$adatom['backup_pojekt_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function search2_admin_ujhibajavitas_user_ad(){
$tomb=keres_search2_admin_ujhibajavitas_user_ad();
echo json_encode($tomb);
}

function keres_search2_admin_ujhibajavitas_user_ad(){
$eredmeny_keres="";
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
 $sql="SELECT
 backup_user.user_tsz,
 backup_user.user_ad,
 backup_user.user_nev
 FROM `backup_user` 
 inner join backup_ver ON backup_ver.backup_ver_id = backup_user.backup_ver_id 
	and backup_ver.backup_ver_id = '".$backup_ver_id."'
 order by backup_user.user_nev asc
";
 //echo $sql;exit;
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
 if($_POST['mit']!='keremv'){
    
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['user_ad'];
  $eredmeny_keres[$i]['text']=$adatom['user_nev']. ' ('.$adatom['user_tsz'].', '.$adatom['user_ad'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
  }
 return $eredmeny_keres;
}


function search2_admin_ujhibajavitas_backup_ver_id(){
$tomb=keres_search2_search2_admin_ujhibajavitas_backup_ver_id();
echo json_encode($tomb);
}

function keres_search2_search2_admin_ujhibajavitas_backup_ver_id(){
$eredmeny_keres="";
$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$_POST['mit2']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit2']);
 $sql="SELECT 
 backup_ver.backup_ver_id,
 backup_ver.backup_ver_ver,
 backup_ver.backup_ver_update_time
 FROM `backup_ver` 
 where 
 backup_ver.backup_ver_ev='".$_POST['mit']."' and 
 backup_ver.backup_ver_ho='".$_POST['mit2']."'
 order by backup_ver.backup_ver_id desc
 limit 1
 ";
 //echo $sql;exit;
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
 if($_POST['mit']!='keremv'){
    
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_ver_id'];
  $eredmeny_keres[$i]['text']='Verzió: '.$adatom['backup_ver_ver'].' ('.$adatom['backup_ver_update_time'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
  }
 return $eredmeny_keres;
}

function admin_ujhibajavitas_nap(){
$tomb=keres_search2_admin_ujhibajavitas_nap();
echo json_encode($tomb);
}

function keres_search2_admin_ujhibajavitas_nap(){
$eredmeny_keres=array();
  $eredmeny_keres[0]['id']='all';
  $eredmeny_keres[0]['text']='Összes';
  $eredmeny_keres[0]['sorsz']=0;
if(($_POST['mit']!='keremv')and($_POST['mit2']!='keremv')){
$ev=$_POST['mit'];
$ho=$_POST['mit2'];
$utolso_nap=date("t",strtotime($ev."-".$ho));
for($i=1;$i<=$utolso_nap;$i++){
  $naptime=mktime("0","0","1",$ho,$i,$ev);
  $het_sorszam=date('w',$naptime);

  $eredmeny_keres[$i]['id']=$i;
  $eredmeny_keres[$i]['text']=$i." - ".napkod($het_sorszam);
  $eredmeny_keres[$i]['sorsz']=$i;
}
}
return $eredmeny_keres;
}

function search2_admin_ujhibajavitas_ho(){
$tomb=keres_search2_admin_ujhibajavitas_ho();
echo json_encode($tomb);
}

function keres_search2_admin_ujhibajavitas_ho(){
$eredmeny_keres="";
 $sql="SELECT backup_ver.backup_ver_ho
 FROM `backup_ver` 
 where backup_ver.backup_ver_ev='".$_POST['mit']."'
 group by backup_ver.backup_ver_ho  
 order by backup_ver.backup_ver_ho asc";
 //echo $sql;exit;
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
 if($_POST['mit']!='keremv'){
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_ver_ho'];
  $eredmeny_keres[$i]['text']=ho_ki($adatom['backup_ver_ho']);
  $eredmeny_keres[$i]['sorsz']=$i;
 }
  }
 return $eredmeny_keres;
}


function search2_riport_tervteny_sel_tipus(){
$tomb=keres_search2_riport_tervteny_sel_tipus();
echo json_encode($tomb);
}
function keres_search2_riport_tervteny_sel_tipus(){
$eredmeny_keres="";
$sql='SELECT 
backup_terv_tipus.backup_terv_tipus_id,
backup_terv_tipus.backup_terv_tipus_nev,
backup_terv_tipus.backup_terv_tipus_megj,
backup_terv_fo_tipus_nev.backup_terv_fo_tipus
FROM `backup_terv_tipus`
inner join backup_terv_fo_tipus_nev ON backup_terv_fo_tipus_nev.backup_terv_fo_tipus_id = backup_terv_tipus.backup_terv_fo_tipus_id
where
backup_terv_tipus.backup_terv_tipus_ev="'.$_POST['mit'].'" and 
backup_terv_tipus.backup_terv_tipus_riportok="1"
 ';
 //echo $sql;exit;
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
 if($_POST['mit']!='keremv'){
    
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_terv_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['backup_terv_fo_tipus'].' - '.$adatom['backup_terv_tipus_nev'];
  $eredmeny_keres[$i]['title']=$adatom['backup_terv_tipus_megj'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
  }
 return $eredmeny_keres;
}



function search2_riport_tervteny_sel_ev(){
$tomb=keres_search2_riport_tervteny_sel_ev_teny();
/*
if((isset($_POST['mit']))and($_POST['mit']=='teny')){
 $tomb=keres_search2_riport_tervteny_sel_ev_teny();
}else{
 $tomb=keres_search2_riport_tervteny_sel_ev_terv();
}*/
echo json_encode($tomb);
}

function keres_search2_riport_tervteny_sel_ev_terv(){
$eredmeny_keres="";
$sql='SELECT backup_terv.backup_terv_ev  
FROM `backup_terv`
group by backup_terv.backup_terv_ev  ';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_terv_ev'];
  $eredmeny_keres[$i]['text']=$adatom['backup_terv_ev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_riport_tervteny_sel_ev_teny(){
$eredmeny_keres="";
$sql='SELECT backup_ver.backup_ver_ev 
FROM `backup_ver`
where
backup_ver.backup_ver_teny3="1" and backup_ver.backup_ver_default="1" 
group by backup_ver.backup_ver_ev ';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['backup_ver_ev'];
  $eredmeny_keres[$i]['text']=$adatom['backup_ver_ev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}





function search2_admin_kat_uj(){
$tomb=keres_search2_admin_kat_uj();
echo json_encode($tomb);
}

function keres_search2_admin_kat_uj(){
$eredmeny_keres="";
$sql='SELECT projekt_kat.projekt_kat_id,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h
FROM `projekt_kat`
where projekt_kat.projekt_kat_inaktiv  = "0"
order by projekt_kat.projekt_kat_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['projekt_kat_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_kat_nev'].' - '.$adatom['projekt_kat_nev_h'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function search2_admin_kat(){
$tomb=keres_search2_admin_kat();
echo json_encode($tomb);
}

function keres_search2_admin_kat(){
$eredmeny_keres="";
$sql='SELECT projekt_kat.projekt_kat_id,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h 
FROM `projekt_kat`
where projekt_kat.projekt_kat_inaktiv  = "0"
order by projekt_kat.projekt_kat_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['projekt_kat_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_kat_nev'].' - '.$adatom['projekt_kat_nev_h'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}






function search2_admin_csopnev_uj(){
$tomb=keres_search2_admin_csopnev_uj();
echo json_encode($tomb);
}

function keres_search2_admin_csopnev_uj(){
$eredmeny_keres="";
$sql='SELECT mira_szerv_csoport.mira_szerv_csoport_id,mira_szerv_csoport.mira_szerv_csoport_nev 
FROM `mira_szerv_csoport`
where mira_szerv_csoport.mira_szerv_csoport_inaktiv = "0"
order by mira_szerv_csoport.mira_szerv_csoport_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['mira_szerv_csoport_id'];
  $eredmeny_keres[$i]['text']=$adatom['mira_szerv_csoport_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_csopnev(){
$tomb=keres_search2_admin_csopnev();
echo json_encode($tomb);
}

function keres_search2_admin_csopnev(){
$eredmeny_keres="";
$sql='SELECT mira_szerv_csoport.mira_szerv_csoport_id,mira_szerv_csoport.mira_szerv_csoport_nev 
FROM `mira_szerv_csoport`
where mira_szerv_csoport.mira_szerv_csoport_inaktiv = "0"
order by mira_szerv_csoport.mira_szerv_csoport_nev ASC';
  $i=-1;
  /*if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;*/
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['mira_szerv_csoport_id'];
  $eredmeny_keres[$i]['text']=$adatom['mira_szerv_csoport_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}





function search2_admin_szolgkod_uj_all(){
$tomb=keres_search2_admin_szolgkod_uj_all();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod_uj_all(){
$eredmeny_keres="";
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
where mira_szolg_kod.szolg_kod_inaktiv="0"
order by mira_szolg_kod.szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function search2_admin_szolgkod_ujtorzsossze(){
$tomb=keres_search2_admin_szolgkod_ujtorzsossze();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod_ujtorzsossze(){
$eredmeny_keres="";
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
where mira_szolg_kod.szolg_kod_inaktiv="0" and 
(
 (mira_szolg_kod.szolg_kod like "DK%")or
 (mira_szolg_kod.szolg_kod like "EG%")or
 (mira_szolg_kod.szolg_kod like "SL%")or
 (mira_szolg_kod.szolg_kod like "KK%")
)
order by mira_szolg_kod.szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_admin_szolgcsop_all(){
$eredmeny_keres="";
$sql='SELECT szerz_csop.szerz_csop_id,szerz_csop.szerz_csop_nev
FROM `szerz_csop`
order by szerz_csop.szerz_csop_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_csop_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_csop_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_admin_kpiszolgcsop_all(){
$eredmeny_keres="";
$sql='SELECT kpi_szolg_kod.kpi_szolg_kod
FROM `kpi_szolg_kod`
order by kpi_szolg_kod.kpi_szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kpi_szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['kpi_szolg_kod'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_admin_szolgkod_all(){
$eredmeny_keres="";
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
where mira_szolg_kod.szolg_kod_inaktiv="0"
order by mira_szolg_kod.szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_szolgkod_csop_uj(){
$tomb=keres_search2_admin_szolgkod_csop_uj();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod_csop_uj(){
$eredmeny_keres="";
$mit=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `szerz_csop_szolgkod`
inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_csop_szolgkod.szolg_kod
where mira_szolg_kod.szolg_kod_inaktiv="0" and szerz_csop_szolgkod.szerz_csop_id = "'.$mit.'"
order by mira_szolg_kod.szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_szolgkod_uj(){
$tomb=keres_search2_admin_szolgkod_uj();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod_uj(){
$eredmeny_keres="";
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
where mira_szolg_kod.szolg_kod_inaktiv="0"
order by mira_szolg_kod.szolg_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_szolgkod_csopid(){
$tomb=keres_search2_admin_szolgkod_csopid();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod_csopid(){
$eredmeny_keres="";
$mit=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `szerz_csop_szolgkod`
inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_csop_szolgkod.szolg_kod
where mira_szolg_kod.szolg_kod_inaktiv="0" and szerz_csop_szolgkod.szerz_csop_id = "'.$mit.'"
order by mira_szolg_kod.szolg_kod ASC';
  
  $i=-1;
  /*
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  */
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function admin_devizanem_uj(){
$tomb=keres_search2_admin_devizanem();
echo json_encode($tomb);
}

function keres_search2_admin_devizanem(){
$eredmeny_keres="";
$sql='SELECT penznem
FROM `szerz_penznem`
order by szerz_penznem.penznem ASC';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['penznem'];
  $eredmeny_keres[$i]['text']=$adatom['penznem'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}


function search2_admin_szolgkod(){
$tomb=keres_search2_admin_szolgkod();
echo json_encode($tomb);
}

function keres_search2_admin_szolgkod(){
$eredmeny_keres="";
$sql='SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
FROM `mira_szolg_kod`
where mira_szolg_kod.szolg_kod_inaktiv="0"
order by mira_szolg_kod.szolg_kod ASC';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['szolg_kod'].' - '.$adatom['szolg_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_tagvkod_uj_all(){
$tomb=keres_search2_admin_tagvkod_uj_all();
echo json_encode($tomb);
}

function keres_search2_admin_tagvkod_uj_all(){
$eredmeny_keres="";
$sql='SELECT mira_tagv_kod.tagv_kod,mira_tagv_kod.tagv_kod_nev
FROM `mira_tagv_kod`
where mira_tagv_kod.tagv_kod_inaktiv = "0"
order by mira_tagv_kod.tagv_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }

 return $eredmeny_keres;
}


function search2_admin_tagvkod_uj(){
$tomb=keres_search2_admin_tagvkod_uj();
echo json_encode($tomb);
}

function keres_search2_admin_tagvkod_uj(){
$eredmeny_keres="";
$sql='SELECT mira_tagv_kod.tagv_kod,mira_tagv_kod.tagv_kod_nev
FROM `mira_tagv_kod`
where mira_tagv_kod.tagv_kod_inaktiv = "0"
order by mira_tagv_kod.tagv_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }

 return $eredmeny_keres;
}

function admin_nattipus_uj(){
$tomb=keres_search2_nattipus_uj();
echo json_encode($tomb);
}

function keres_search2_nattipus_uj(){
$eredmeny_keres="";
$sql='SELECT szerz_naturalia.szerz_naturalia_nev,szerz_naturalia.szerz_naturalia_id
FROM `szerz_naturalia`
order by szerz_naturalia.szerz_naturalia_nev ASC';
  
 if($_POST['mod']=='admin_nattipus_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_naturalia_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_naturalia_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_nattipus_all(){
$eredmeny_keres="";
$sql='SELECT szerz_naturalia.szerz_naturalia_nev,szerz_naturalia.szerz_naturalia_id
FROM `szerz_naturalia`
order by szerz_naturalia.szerz_naturalia_nev ASC';

  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
 

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_naturalia_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_naturalia_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_elsztipus_uj(){
$tomb=keres_search2_elsztipus_uj();
echo json_encode($tomb);
}

function keres_search2_elsztipus_uj(){
$eredmeny_keres="";
$sql='SELECT szerz_elsz_tipus.szerz_elsz_tipus_nev,szerz_elsz_tipus.szerz_elsz_tipus_id
FROM `szerz_elsz_tipus`
order by szerz_elsz_tipus.szerz_elsz_tipus_nev ASC';
  
 if($_POST['mod']=='admin_elsztipus_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_elsz_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_elsz_tipus_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_elsztipus_all(){
$eredmeny_keres="";
$sql='SELECT szerz_elsz_tipus.szerz_elsz_tipus_nev,szerz_elsz_tipus.szerz_elsz_tipus_id
FROM `szerz_elsz_tipus`
order by szerz_elsz_tipus.szerz_elsz_tipus_nev ASC';
  
 //if($_POST['mod']=='admin_elsztipus_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
 /*}else{
	$i=-1;  
 }*/

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_elsz_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_elsz_tipus_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_szolgcsop_uj(){
$tomb=keres_search2_szolgcsop_uj();
echo json_encode($tomb);
}

function keres_search2_szolgcsop_uj(){
$eredmeny_keres="";
$sql='SELECT szerz_csop.szerz_csop_nev,szerz_csop.szerz_csop_id
FROM `szerz_csop`
order by szerz_csop.szerz_csop_nev ASC';
  
 if($_POST['mod']=='admin_szolgcsop_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_csop_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_csop_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_szolgkapadat_ker1(){

if($_POST['mit']=='tagv_kod'){
 $tomb=keres_search2_admin_tagvkod_uj_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='tagv_kat'){
 $tomb=array();
 $tomb[0]['id']='all';
 $tomb[0]['text']='Összes';
 $tomb[0]['sorsz']='0';
 
 $tomb[1]['id']='1';
 $tomb[1]['text']='1-es szintű';
 $tomb[1]['sorsz']='1';
 
 $tomb[2]['id']='2';
 $tomb[2]['text']='2-es szintű';
 $tomb[2]['sorsz']='2';
 
 $tomb[3]['id']='3';
 $tomb[3]['text']='3-as szintű';
 $tomb[3]['sorsz']='3';
 
 $tomb[4]['id']='0';
 $tomb[4]['text']='Nincs KPI';
 $tomb[4]['sorsz']='4';
 
 $tomb[5]['id']='123';
 $tomb[5]['text']='1,2,3-as szintű';
 $tomb[5]['sorsz']='5';
 
 echo json_encode($tomb);
}elseif($_POST['mit']=='szerz_tipus'){
 $tomb=keres_search2_szerztipus_ker_keres();
 echo json_encode($tomb);
}elseif($_POST['mit']=='szerz'){
 $tomb=keres_search2_szerzalapadat_uj();
 echo json_encode($tomb);
}elseif($_POST['mit']=='szolg_kod'){
 $tomb=keres_search2_admin_szolgkod_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='szolg_csop'){
 $tomb=keres_search2_admin_szolgcsop_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='kpi_szolg_kod'){
 $tomb=keres_search2_admin_kpiszolgcsop_all();
 echo json_encode($tomb);
}elseif(
($_POST['mit']=='uto_kalk')or
($_POST['mit']=='szerz_keret')or
($_POST['mit']=='integ_erintett')or
($_POST['mit']=='folyamatban')
){
 $tomb=array();
 $tomb[0]['id']='all';
 $tomb[0]['text']='Összes';
 $tomb[0]['sorsz']='0';
 $tomb[1]['id']='0';
 $tomb[1]['text']='Nem';
 $tomb[1]['sorsz']='1';
 $tomb[2]['id']='1';
 $tomb[2]['text']='Igen';
 $tomb[2]['sorsz']='2';
 echo json_encode($tomb);
}elseif($_POST['mit']=='szolg_erv'){
 $tomb=array();
 $tomb[0]['id']='all';
 $tomb[0]['text']='Összes';
 $tomb[0]['sorsz']='0';
 $tomb[1]['id']='0';
 $tomb[1]['text']='Nincs vagy Jövőbeli';
 $tomb[1]['sorsz']='1';
 $tomb[2]['id']='1';
 $tomb[2]['text']='Múltbeli';
 $tomb[2]['sorsz']='2';
 echo json_encode($tomb);
}elseif($_POST['mit']=='elsz_tipus'){
 $tomb=keres_search2_elsztipus_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='naturalia'){
 $tomb=keres_search2_nattipus_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='usergazda'){
 $tomb=keres_search2_usergazda_all();
 echo json_encode($tomb);
}elseif($_POST['mit']=='penznem'){
 $tomb=keres_search2_admin_penznem_uj();
 echo json_encode($tomb);
}
}

function admin_szerzalapadat_uj(){
$tomb=keres_search2_szerzalapadat_uj();
echo json_encode($tomb);

}

function keres_search2_szerzalapadat_uj(){
$eredmeny_keres="";
$sql='SELECT szerz.szerz_id,szerz.tagv_kod,szerz.szerz_keret,szerz.szerz_date_hatalybelep,szerz_tipus.szerz_tipus_nev
,szerz.szerz_date_hatalybelep,szerz.szerz_megj
FROM `szerz`
left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id 
order by szerz.tagv_kod ASC, szerz.szerz_id ASC';
  
  
 if($_POST['mod']=='admin_szerzalapadat_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }elseif(($_POST['mod']=='admin_szerzalapadat_all')or(
  (isset($_POST['mit']))and($_POST['mit']=='szerz')
 )){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_id'].' - '.$adatom['tagv_kod'].' ('.$adatom['szerz_tipus_nev'].', Keretszerződés: '.igennem_kod_ki_0nalis($adatom['szerz_keret']).', '.kidate_format_ev($adatom['szerz_date_hatalybelep']).')';
  if($adatom['szerz_megj']!='')
   $eredmeny_keres[$i]['title']=str_replace("\n","<br>",$adatom['szerz_megj']);
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_usergazda_uj(){
$tomb=keres_search2_usergazda_uj();
echo json_encode($tomb);
}

function keres_search2_usergazda_uj(){
$eredmeny_keres="";
//where szerz_usergazda.szerz_usergazda_inaktiv="0"
$sql='SELECT szerz_usergazda.szerz_usergazda_nev,szerz_usergazda.szerz_usergazda_ad,szerz_usergazda.szerz_usergazda_tsz 
FROM `szerz_usergazda`
where szerz_usergazda.szerz_usergazda_inaktiv="0"
order by szerz_usergazda.szerz_usergazda_nev ASC';
  
 if($_POST['mod']=='admin_usergazda_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_usergazda_ad'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_usergazda_nev'].' ('.$adatom['szerz_usergazda_tsz'].', '.$adatom['szerz_usergazda_ad'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function keres_search2_usergazda_all(){
$eredmeny_keres="";
$sql='SELECT szerz_usergazda.szerz_usergazda_nev,szerz_usergazda.szerz_usergazda_ad,szerz_usergazda.szerz_usergazda_tsz 
,szerz_usergazda.szerz_usergazda_inaktiv
FROM `szerz_usergazda`
order by szerz_usergazda.szerz_usergazda_nev ASC';
  

  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_usergazda_ad'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_usergazda_nev'].' ('.$adatom['szerz_usergazda_tsz'].', '.$adatom['szerz_usergazda_ad'].')';
  if($adatom['szerz_usergazda_inaktiv']=='1')$eredmeny_keres[$i]['text'].=' - Inaktív';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_penznem_uj(){
$tomb=keres_search2_admin_penznem_uj();
echo json_encode($tomb);
}

function keres_search2_admin_penznem_uj(){
$eredmeny_keres="";

$sql='SELECT szerz_penznem.penznem
FROM `szerz_penznem` ';

 if((isset($_POST['mod']))and($_POST['mod']=='admin_szolgkapadat_ker1')){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
  $i=-1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['penznem'];
  $eredmeny_keres[$i]['text']=$adatom['penznem'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
  
}

function admin_kpi_sorszam(){
$tomb=keres_search2_kpi_sorszam_uj();
echo json_encode($tomb);
}

function keres_search2_kpi_sorszam_uj(){
$eredmeny_keres="";

$i=-1;
/*
$i++;
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();
 $eredmeny_keres[$i]['id']='keremv';
 $eredmeny_keres[$i]['text']='Kérem válassz';
 $eredmeny_keres[$i]['sorsz']=$i;
*/
if(((isset($_POST['mit']))and($_POST['mit']!='keremv')and($_POST['mit']!=''))){
$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT IFNULL(MAX(kpi_tipus.kpi_tipus_sorszam),0) + 1 AS uj_kpi_tipus_sorszam
FROM `kpi_tipus` 
where kpi_tipus.kpi_szolg_kod="'.$_POST['mit'].'"';

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['uj_kpi_tipus_sorszam'];
  $eredmeny_keres[$i]['text']=$adatom['uj_kpi_tipus_sorszam'];
  $eredmeny_keres[$i]['selected']=true;
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 
 if(is_array($eredmeny_keres)){
  $i_t2=$eredmeny_keres[$i]['id']+1;
 }else $i_t2=0;
  
 for($i_t=$i_t2;$i_t<99;$i_t++){
  $i++;
  $eredmeny_keres[$i]['id']=$i_t;
  $eredmeny_keres[$i]['text']=$i_t;
  $eredmeny_keres[$i]['sorsz']=$i_t;
 }
 
}else{
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();
 $i++;
 $eredmeny_keres[$i]['id']='keremv';
 $eredmeny_keres[$i]['text']='Kérem válassz';
 $eredmeny_keres[$i]['selected']=true;
 $eredmeny_keres[$i]['sorsz']=$i;
}

 return $eredmeny_keres;
}

function admin_kpi_szolg_kod(){
$tomb=keres_search2_kpi_szolg_kod_uj();
echo json_encode($tomb);
}

function keres_search2_kpi_szolg_kod_uj(){
$eredmeny_keres="";
$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT kpi_szolg_kod.kpi_szolg_kod
FROM `kpi_szolg_kod` ';

  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kpi_szolg_kod'];
  $eredmeny_keres[$i]['text']=$adatom['kpi_szolg_kod'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_szerztipus_ujall(){
$tomb=keres_search2_szerztipus_ujall();
echo json_encode($tomb);
}

function keres_search2_szerztipus_ujall(){
$eredmeny_keres="";
//$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT szerz_tipus.szerz_tipus_id,szerz_tipus.szerz_tipus_nev
FROM `szerz_tipus` 
order by szerz_tipus.szerz_tipus_nev ASC';

  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;

  
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_tipus_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_szerztipus_uj(){
$tomb=keres_search2_szerztipus_uj();
echo json_encode($tomb);
}

function keres_search2_szerztipus_uj(){
$eredmeny_keres="";
if($_POST['mit']!='')$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);
$sql='SELECT szerz_tipus.szerz_tipus_id,szerz_tipus.szerz_tipus_nev
FROM `szerz_tipus` ';

if($_POST['mit']!=''){
 $sql.='where szerz_tipus.szerz_tipus_szerz_keret="'.$_POST['mit'].'"';
}
$sql.=' order by szerz_tipus.szerz_tipus_nev ASC';
  
 if($_POST['mod']=='admin_szerztipus_uj'){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }
  
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_tipus_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_szerztipus_ker_keres(){
$tomb=keres_search2_szerztipus_ker_keres();
echo json_encode($tomb);
}

function keres_search2_szerztipus_ker_keres(){
$eredmeny_keres="";
$sql='SELECT szerz_tipus.szerz_tipus_id,szerz_tipus.szerz_tipus_nev
FROM `szerz_tipus`
order by szerz_tipus.szerz_tipus_nev ASC';
  
 if(($_POST['mod']=='admin_szolgkapadat_ker1')or($_POST['mod']=='admin_szerztipus_keres')){
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='all';
  $eredmeny_keres[$i]['text']='Összes';
  $eredmeny_keres[$i]['sorsz']=$i;
 }else{
	$i=-1;  
 }
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['szerz_tipus_id'];
  $eredmeny_keres[$i]['text']=$adatom['szerz_tipus_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function admin_kapcs_tulaj(){
$tomb=keres_search2_kapcs_tulaj();
echo json_encode($tomb);
}

function keres_search2_kapcs_tulaj(){
$eredmeny_keres="";
$sql='SELECT kapcs_tulaj.kapcs_tulaj_kod,kapcs_tulaj.kapcs_tulaj_nev
FROM `kapcs_tulaj`
where 
kapcs_tulaj.kapcs_tulaj_inaktiv="0" 
order by kapcs_tulaj.kapcs_tulaj_kod ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kapcs_tulaj_kod'];
  $eredmeny_keres[$i]['text']=$adatom['kapcs_tulaj_kod'].' - '.$adatom['kapcs_tulaj_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_kapcs_torzs(){
if((isset($_POST['mit']))and($_POST['mit']!='')){
 $tomb=keres_search2_kapcs_torzs_mit_tulaj();
}elseif((isset($_POST['mit3']))and($_POST['mit3']=='NKMH')){//Csak NKMH és MVRT
 $tomb=keres_search2_kapcs_torzs_mit_nkmh_mvrt();
/*
}elseif((isset($_POST['mit3']))and($_POST['mit3']!='')){//Egyenlőre nincs hasznlálatban
 $tomb=keres_search2_kapcs_torzs_mit_egy();
*/
}else{//ALL
 $tomb=keres_search2_kapcs_torzs();
}
echo json_encode($tomb);
}

function keres_search2_kapcs_torzs_mit_tulaj(){
$eredmeny_keres="";
$_POST['mit']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit']);

$tulaj_kod=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$_POST['mit'],'kapcs_tulaj_kod');

$sql='
SELECT kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev,kapcs_torzs.tagv_kod 
,kapcs_torzs.kapcs_torzs_beosztas
FROM `kapcs_torzs`
where 
kapcs_torzs.kapcs_torzs_inaktiv="0" ';

if($tulaj_kod!='Nincs'){
	$sql.='and 
	(
	(kapcs_torzs.tagv_kod="'.$_POST['mit'].'")
	or
	(kapcs_torzs.tagv_kod IN (
	SELECT mira_tagv_kod.tagv_kod
	FROM `mira_tagv_kod`
	 inner join mira_tagv_kod as mira_tagv_kod_orig ON mira_tagv_kod_orig.kapcs_tulaj_kod = mira_tagv_kod.kapcs_tulaj_kod
		and mira_tagv_kod_orig.tagv_kod = "'.$_POST['mit'].'"
	where 
	mira_tagv_kod.tagv_kod_inaktiv ="0" 
	)
	)
	) ';
}

$sql.='order by kapcs_torzs.kapcs_torzs_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kapcs_torzs_id'];
  $eredmeny_keres[$i]['title']='Név: '.$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$i]['title'].='<br>Társaság: '.$adatom['tagv_kod'];
  if($adatom['kapcs_torzs_beosztas']!='')
   $eredmeny_keres[$i]['title'].='<br>Beosztás: '.$adatom['kapcs_torzs_beosztas'];
  $eredmeny_keres[$i]['text']=$adatom['kapcs_torzs_nev'].' ('.$adatom['tagv_kod'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
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

function keres_search2_kapcs_torzs_mit_nkmh_mvrt(){
$eredmeny_keres="";
$sql='SELECT kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev,kapcs_torzs.tagv_kod
,kapcs_torzs.kapcs_torzs_beosztas
FROM `kapcs_torzs`
where 
(
 (kapcs_torzs.tagv_kod="NKMH")
 or
 (kapcs_torzs.tagv_kod="MVRT")
)
and
kapcs_torzs.kapcs_torzs_inaktiv="0" 
order by kapcs_torzs.kapcs_torzs_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  //echo $sql;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kapcs_torzs_id'];
  $eredmeny_keres[$i]['title']='Név: '.$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$i]['title'].='<br>Társaság: '.$adatom['tagv_kod'];
  if($adatom['kapcs_torzs_beosztas']!='')
   $eredmeny_keres[$i]['title'].='<br>Beosztás: '.$adatom['kapcs_torzs_beosztas'];
  $eredmeny_keres[$i]['text']=$adatom['kapcs_torzs_nev'].' ('.$adatom['tagv_kod'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

/*
function keres_search2_kapcs_torzs_mit_egy(){
$eredmeny_keres="";
$_POST['mit3']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['mit3']);
$sql='SELECT kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev,kapcs_torzs.tagv_kod
FROM `kapcs_torzs`
where 
kapcs_torzs.tagv_kod="'.$_POST['mit3'].'" and
kapcs_torzs.kapcs_torzs_inaktiv="0" 
order by kapcs_torzs.kapcs_torzs_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  //echo $sql;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kapcs_torzs_id'];
  $eredmeny_keres[$i]['text']=$adatom['kapcs_torzs_nev'].' ('.$adatom['tagv_kod'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}
*/

function keres_search2_kapcs_torzs(){
$eredmeny_keres="";
//where kapcs_torzs.tagv_kod_inaktiv = "0"
$sql='SELECT kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev,kapcs_torzs.tagv_kod
,kapcs_torzs.kapcs_torzs_beosztas
FROM `kapcs_torzs`
where 
kapcs_torzs.kapcs_torzs_inaktiv="0" 
order by kapcs_torzs.kapcs_torzs_nev ASC';
  $i=0;
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']='keremv';
  $eredmeny_keres[$i]['text']='Kérem válassz';
  $eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['kapcs_torzs_id'];
  $eredmeny_keres[$i]['title']='Név: '.$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$i]['title'].='<br>Társaság: '.$adatom['tagv_kod'];
  if($adatom['kapcs_torzs_beosztas']!='')
   $eredmeny_keres[$i]['title'].='<br>Beosztás: '.$adatom['kapcs_torzs_beosztas'];
  $eredmeny_keres[$i]['text']=$adatom['kapcs_torzs_nev'].' ('.$adatom['tagv_kod'].')';
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_tagvkod_all(){
$tomb=keres_search2_admin_tagvkod_all();
echo json_encode($tomb);
}

function keres_search2_admin_tagvkod_all(){
$eredmeny_keres="";
$sql='SELECT mira_tagv_kod.tagv_kod,mira_tagv_kod.tagv_kod_nev
FROM `mira_tagv_kod`
order by mira_tagv_kod.tagv_kod ASC';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function search2_admin_tagvkod(){
$tomb=keres_search2_admin_tagvkod();
echo json_encode($tomb);
}

function keres_search2_admin_tagvkod(){
$eredmeny_keres="";
$sql='SELECT mira_tagv_kod.tagv_kod,mira_tagv_kod.tagv_kod_nev
FROM `mira_tagv_kod`
where mira_tagv_kod.tagv_kod_inaktiv = "0"
order by mira_tagv_kod.tagv_kod ASC';
  $i=-1;
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  //$eredmeny_keres[$i]['id']='keremv';
  //$eredmeny_keres[$i]['text']='Kérem válassz';
  //$eredmeny_keres[$i]['sorsz']=$i;
  
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$i]['id']=$adatom['tagv_kod'];
  $eredmeny_keres[$i]['text']=$adatom['tagv_kod'].' - '.$adatom['tagv_kod_nev'];
  $eredmeny_keres[$i]['sorsz']=$i;
 }
 return $eredmeny_keres;
}

function igennem_kod_ki_0nalis($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'':$ret="";break;
	case'0':$ret="Nem";break;
	case'1':$ret="Igen";break;
}
return $ret;
}

function napkod($het_sorszam){
$ret='hiba';
switch($het_sorszam)
{
 case'0':$ret='Vasárnap';break;
 case'1':$ret='Hétfő';break;
 case'2':$ret='Kedd';break;
 case'3':$ret='Szerda';break;
 case'4':$ret='Csütörtök';break;
 case'5':$ret='Péntek';break;
 case'6':$ret='Szombat';break;
}
return $ret;
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

function kidate_format_ev($date){
if(($date=='0000-00-00')or($date=='')){
 $date='';
}else{
 $date=str_replace('-','.',$date);
 $date=str_replace(' ','. ',$date);
}

return $date;
}


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

?>
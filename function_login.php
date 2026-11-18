<?php

function login_helyettes(){

$tomb_user=keres_user_login($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],0);

if(!is_array($tomb_user)){//Ekkor sima legyen
 $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']="";
 $GLOBALS[$GLOBALS['sessionname']]['helyettes_szerv_nev']="";
}else{
 $GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev']=$tomb_user['user_nev'];
 $GLOBALS[$GLOBALS['sessionname']]['helyettes_szerv_nev']=$tomb_user['szerv_nev'];
 
 $GLOBALS['mira']['szerv_id']=$_SESSION[$GLOBALS['sessionname']]['szerv_id']=$tomb_user['szerv_id'];
 
 //Userhez kötött munkaidő - eleje
 //if($tomb_user['user_napi_ido_max_ora']>0){
 //if($tomb_user['user_napi_ido_max_ora']!=''){
if(
($tomb_user['user_napi_ido_max_ora']>0)
or
(
 ($tomb_user['user_napi_ido_max_ora']==0)and
 ($tomb_user['user_napi_ido_max_perc']>0)
)
){
 $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":00";
 
 if($tomb_user['user_napi_ido_max_perc']>9){
  $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":".$tomb_user['user_napi_ido_max_perc'];
 }else{
  $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":0".$tomb_user['user_napi_ido_max_perc'];
 }
 
 $GLOBALS['mira']['napi_ido_max_ora']=$tomb_user['user_napi_ido_max_ora'];
 $GLOBALS['mira']['napi_ido_max_perc']=$tomb_user['user_napi_ido_max_perc'];
  
 }else{
  //$GLOBALS['mira']['napi_ido_max']=$tomb_user['napi_ido_max_ora'].":00";//Ennél többet nem enged 1 napra rögzíteni
  //$GLOBALS['mira']['napi_ido_max_ora']=$tomb_user['napi_ido_max_ora'];//Ennél többet nem enged 1 napra rögzíteniű
  $GLOBALS['mira']['napi_ido_max']=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'].":00";//Ennél többet nem enged 1 napra rögzíteni
  $GLOBALS['mira']['napi_ido_max_ora']=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];//Ennél többet nem enged 1 napra rögzíteni
  $GLOBALS['mira']['napi_ido_max_perc']=0;
 }
 //Userhez kötött munkaidő - vége

//Kezdő hó - eleje
if(
($tomb_user['user_kezd_date']!="")and
($tomb_user['user_kezd_date']!="0000-00-00")and
(strlen($tomb_user['user_kezd_date'])=="10")
){
 $tomb_user_kezd_date=explode("-",$tomb_user['user_kezd_date']);
 $GLOBALS['mira']['rogzit_ev_kezdo_ev']=$tomb_user_kezd_date[0];
 
 $tmp_ev_kezdo_ho=$tomb_user_kezd_date[1]+1;
 $GLOBALS['mira']['rogzit_ev_kezdo_ho']=$tmp_ev_kezdo_ho-1;
 
 $tmp_ev_kezdo_nap=$tomb_user_kezd_date[2]+1;
 $GLOBALS['mira']['rogzit_ev_kezdo_nap']=$tmp_ev_kezdo_nap-1;

}else{
 //$GLOBALS['mira']['rogzit_ev_kezdo_ev']=$tomb_user['ev_kezdo_ev'];
 //$GLOBALS['mira']['rogzit_ev_kezdo_ho']=$tomb_user['ev_kezdo_ho'];
 $GLOBALS['mira']['rogzit_ev_kezdo_ev']=$GLOBALS['tagv_alap_ev_kezdo_ev'];
 $GLOBALS['mira']['rogzit_ev_kezdo_ho']=$GLOBALS['tagv_alap_ev_kezdo_ho'];
 $GLOBALS['mira']['rogzit_ev_kezdo_nap']="1";
}
//Kezdő hó - vége

//Vége hó - eleje
if(
($tomb_user['user_veg_date']!="")and
($tomb_user['user_veg_date']!="0000-00-00")and
(strlen($tomb_user['user_veg_date'])=="10")
){
 $tomb_user_kezd_date=explode("-",$tomb_user['user_veg_date']);
 $GLOBALS['mira']['rogzit_ev_veg_ev']=$tomb_user_kezd_date[0];
 
 $tmp_ev_kezdo_ho=$tomb_user_kezd_date[1]+1;
 $GLOBALS['mira']['rogzit_ev_veg_ho']=$tmp_ev_kezdo_ho-1;
 
 $tmp_ev_kezdo_nap=$tomb_user_kezd_date[2]+1;
 $GLOBALS['mira']['rogzit_ev_veg_nap']=$tmp_ev_kezdo_nap-1;

}else{
 $GLOBALS['mira']['rogzit_ev_veg_ev']="";
 $GLOBALS['mira']['rogzit_ev_veg_ho']="";
 $GLOBALS['mira']['rogzit_ev_veg_nap']="";
}
//Vége hó - vége

}
}

function login($full_admin='0'){

//$_SERVER['REMOTE_USER']="qerqwe@mvmh.local";
if(
(isset($_SERVER['REMOTE_USER']))
and($_SERVER['REMOTE_USER']!="")
){
//$ad=str_replace("@mvmh.local","",mb_strtolower($_SERVER['REMOTE_USER']));
$ad_split=explode("@",mb_strtolower($_SERVER['REMOTE_USER']));
$ad=$ad_split[0];

$tomb_user=keres_user_login($ad,$full_admin);

//echo 'Rögzítési jog: '.$tomb_user['ful_rogzit'].'<br>';

//Rögzítés jog elvétele ha a rögzítés kezdete >1hónap - eleje
if(
(is_array($tomb_user))and
($tomb_user['ful_rogzit']==1)and
($tomb_user['ful_rogzit']==1)and
($tomb_user['user_kezd_date']!="")and
($tomb_user['user_kezd_date']!="0000-00-00")and
(strlen($tomb_user['user_kezd_date'])=="10")
){

$ma_most = date("Ym",time());
$nextev = date('Y', strtotime('+1 month', (strtotime($ma_most))));
//$nextho = date('m', strtotime('+1 month', (strtotime($ma_most))));
$ho_most=date("n",time());
if($ho_most<10){
	$nextho=$ho_most+1;
	$nextho="0".$nextho;
}elseif($ho_most==10) $nextho=11;
elseif($ho_most==11) $nextho=12;
else $nextho='01';

$evhokov=$nextev.$nextho."31";
$rogkezd_sp=str_replace("-","",$tomb_user['user_kezd_date']);
//echo $evhokov."-".$rogkezd_sp.'<br>';
if($evhokov<$rogkezd_sp){
 $tomb_user['ful_rogzit']=0;
}
}
//Rögzítés jog elvétele ha a rögzítés kezdete >1hónap - vége

//echo 'Rögzítési jog: '.$tomb_user['ful_rogzit'].'<br>';



if(!is_array($tomb_user)){
 logout();
}elseif(
($tomb_user['ful_rogzit']!=0)or
($tomb_user['ful_jovahagy']!=0)or
($tomb_user['ful_stat']!=0)or
($tomb_user['ful_riport']!=0)or
($tomb_user['ful_admin']!=0)or
($tomb_user['ful_admin_all']!=0)
)
{//Ekkor van joga - eleje
//Ha nincs se rögzítő, se jóváhagyó,se Statisztika, se Admin joga, akkor nincs joga! - eleje

if((!isset($_SESSION[$GLOBALS['sessionname']]))or(!is_array($_SESSION[$GLOBALS['sessionname']])))
 $_SESSION[$GLOBALS['sessionname']]=array();

if(!isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))
 $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']="";

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))or
($_SESSION[$GLOBALS['sessionname']]['login_ad']!=$ad)
)
 $_SESSION[$GLOBALS['sessionname']]['login_ad']=$ad;

/*if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_nev']))or
($_SESSION[$GLOBALS['sessionname']]['login_nev']!=$tomb_user['user_nev'])
)*/
 $GLOBALS[$GLOBALS['sessionname']]['login_nev']=$tomb_user['user_nev'];

$GLOBALS['mira']['szerv_id']=$_SESSION[$GLOBALS['sessionname']]['szerv_id']=$tomb_user['szerv_id'];

/*
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['szerv_nev']))or
($_SESSION[$GLOBALS['sessionname']]['szerv_nev']!=$tomb_user['szerv_nev'])
)
 $_SESSION[$GLOBALS['sessionname']]['szerv_nev']=$tomb_user['szerv_nev'];
*/
 $GLOBALS[$GLOBALS['sessionname']]['szerv_nev']=$tomb_user['szerv_nev'];

/*
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['tagv']))or
($_SESSION[$GLOBALS['sessionname']]['tagv']!=$tomb_user['user_tagv'])
)
 $_SESSION[$GLOBALS['sessionname']]['tagv']=$tomb_user['user_tagv'];
 */

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ev_ki']))or
(
 ($_SESSION[$GLOBALS['sessionname']]['ev_ki']!=$tomb_user['ev_ki'])and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=='')
)
)
 $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$tomb_user['ev_ki'];

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ho_ki']))or
(
($_SESSION[$GLOBALS['sessionname']]['ho_ki']!=$tomb_user['ho_ki'])and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=='')
)
)
 $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$tomb_user['ho_ki'];

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['nap_ki']))or
(
 ($_SESSION[$GLOBALS['sessionname']]['nap_ki']!=$tomb_user['nap_ki'])and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=='')
)
)
 $_SESSION[$GLOBALS['sessionname']]['nap_ki']=$tomb_user['nap_ki'];

/*
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_rogzit']))or
($_SESSION[$GLOBALS['sessionname']]['ful_rogzit']!=$tomb_user['ful_rogzit'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_rogzit']=$tomb_user['ful_rogzit'];
*/
 $GLOBALS[$GLOBALS['sessionname']]['jog']['ful_rogzit']=$tomb_user['ful_rogzit'];

/*
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_jovahagy']))or
($_SESSION[$GLOBALS['sessionname']]['ful_jovahagy']!=$tomb_user['ful_jovahagy'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=$tomb_user['ful_jovahagy'];
*/
 $GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=$tomb_user['ful_jovahagy'];

/*
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_stat']))or
($_SESSION[$GLOBALS['sessionname']]['ful_stat']!=$tomb_user['ful_stat'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat']=$tomb_user['ful_stat'];
*/
 $GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']=$tomb_user['ful_stat'];

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_stat_all']))or
($_SESSION[$GLOBALS['sessionname']]['ful_stat_all']!=$tomb_user['ful_stat_all'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']=$tomb_user['ful_stat_all'];

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_stat_projekt_all']))or
($_SESSION[$GLOBALS['sessionname']]['ful_stat_projekt_all']!=$tomb_user['ful_stat_projekt_all'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']=$tomb_user['ful_stat_projekt_all'];

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['ful_riport']))or
($GLOBALS[$GLOBALS['sessionname']]['ful_riport']!=$tomb_user['ful_riport'])
)
 $GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']=$tomb_user['ful_riport'];

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['ful_riport_all']))or
($GLOBALS[$GLOBALS['sessionname']]['ful_riport_all']!=$tomb_user['ful_riport_all'])
)
 $GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=$tomb_user['ful_riport_all'];


if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ful_admin']))or
($_SESSION[$GLOBALS['sessionname']]['ful_admin']!=$tomb_user['ful_admin'])
)
 $_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']=$tomb_user['ful_admin'];
$GLOBALS[$GLOBALS['sessionname']]['ful_admin']=$tomb_user['ful_admin'];
//Felsőt vedd ki ha átírtad mindenhol.
 
/*if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']))or
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']!=$tomb_user['ful_admin_all'])
)*/
 $GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']=$tomb_user['ful_admin_all'];

$GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']='';
//Admin aljogok - eleje
if(
($full_admin=='1')and//Fionánál ezt nem mindig kérjük le, majd itt is....
($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']==1)and
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==0)
){
 foreach($tomb_user as $amezo => $aert){
	 //echo $amezo.'-'.$aert.'<br>';
	 if(($amezo!='admin_jog_user_ad')and($aert=='1')){
	  $admin_muv_jog=explode("admin_jog_",$amezo);
	  if(isset($admin_muv_jog[1])){
		if(!is_array($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']))$GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']=array();
	    $GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful'][$admin_muv_jog[1]]=1;
	  }
	 }
 }
}
//Admin aljogok - vége

//$GLOBALS['mira']['globalis_napi_ido_max_ora']=$tomb_user['napi_ido_max_ora'];
$GLOBALS['mira']['globalis_napi_ido_max_ora']=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];

//Kezdő hónap lekezelése - eleje
if(
($tomb_user['user_kezd_date']!="")and
($tomb_user['user_kezd_date']!="0000-00-00")and
(strlen($tomb_user['user_kezd_date'])=="10")
){
 $tomb_user_kezd_date=explode("-",$tomb_user['user_kezd_date']);
 $GLOBALS['mira']['rogzit_ev_kezdo_ev']=$tomb_user_kezd_date[0];
 
 $tmp_ev_kezdo_ho=$tomb_user_kezd_date[1]+1;
 $GLOBALS['mira']['rogzit_ev_kezdo_ho']=$tmp_ev_kezdo_ho-1;
 
 $tmp_ev_kezdo_nap=$tomb_user_kezd_date[2]+1;
 $GLOBALS['mira']['rogzit_ev_kezdo_nap']=$tmp_ev_kezdo_nap-1;

 //Ha a lementett mira_user_ker_jog hó kisebb mint ami usernek van növeljük meg.
 if($tomb_user['ev_ki']<$GLOBALS['mira']['rogzit_ev_kezdo_ev']){
  $tmp_modho_ki=array();
  $tmp_modho_ki[0]['ev_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ev'];
  $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$tmp_modho_ki[0]['ev_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_modho_ki[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  unset($tmp_modho_ki);
 }

 //Ha a lementett mira_user_ker_jog hó kisebb mint ami usernek van növeljük meg.
 //De csak ha a kezdő évnél vagyunk
 if(
 ($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])
 and
 ($tomb_user['ho_ki']<$GLOBALS['mira']['rogzit_ev_kezdo_ho'])
 ){
  $tmp_modho_ki=array();
  $tmp_modho_ki[0]['ho_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
  $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$tmp_modho_ki[0]['ho_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_modho_ki[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  unset($tmp_modho_ki);
 }
 
}else{
 //$GLOBALS['mira']['rogzit_ev_kezdo_ev']=$tomb_user['ev_kezdo_ev'];
 //$GLOBALS['mira']['rogzit_ev_kezdo_ho']=$tomb_user['ev_kezdo_ho'];
 $GLOBALS['mira']['rogzit_ev_kezdo_ev']=$GLOBALS['tagv_alap_ev_kezdo_ev'];
 $GLOBALS['mira']['rogzit_ev_kezdo_ho']=$GLOBALS['tagv_alap_ev_kezdo_ho'];
 $GLOBALS['mira']['rogzit_ev_kezdo_nap']="1";
}
//$GLOBALS['mira']['ev_kezdo_ev']=$tomb_user['ev_kezdo_ev'];
//$GLOBALS['mira']['ev_kezdo_ho']=$tomb_user['ev_kezdo_ho'];
$GLOBALS['mira']['ev_kezdo_ev']=$GLOBALS['tagv_alap_ev_kezdo_ev'];
$GLOBALS['mira']['ev_kezdo_ho']=$GLOBALS['tagv_alap_ev_kezdo_ho'];
//Kezdő hónap lekezelése - vége

//Vége hónap lekezelése - eleje
if(
($tomb_user['user_veg_date']!="")and
($tomb_user['user_veg_date']!="0000-00-00")and
(strlen($tomb_user['user_veg_date'])=="10")
){
 $tomb_user_kezd_date=explode("-",$tomb_user['user_veg_date']);
 $GLOBALS['mira']['rogzit_ev_veg_ev']=$tomb_user_kezd_date[0];
 
 $tmp_ev_kezdo_ho=$tomb_user_kezd_date[1]+1;
 $GLOBALS['mira']['rogzit_ev_veg_ho']=$tmp_ev_kezdo_ho-1;
 
 $tmp_ev_kezdo_nap=$tomb_user_kezd_date[2]+1;
 $GLOBALS['mira']['rogzit_ev_veg_nap']=$tmp_ev_kezdo_nap-1;
 
  //Ha a lementett mira_user_ker_jog hó nagyobb mint ami usernek van növeljük meg.
 if($tomb_user['ev_ki']>$GLOBALS['mira']['rogzit_ev_veg_ev']){
  $tmp_modho_ki=array();
  $tmp_modho_ki[0]['ev_ki']=$GLOBALS['mira']['rogzit_ev_veg_ev'];
  $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$tmp_modho_ki[0]['ev_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_modho_ki[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  unset($tmp_modho_ki);
 }
 
 //Ha a lementett mira_user_ker_jog hó nagyobb mint ami usernek van növeljük meg.
 if($tomb_user['ho_ki']>$GLOBALS['mira']['rogzit_ev_veg_ho']){
  $tmp_modho_ki=array();
  $tmp_modho_ki[0]['ho_ki']=$GLOBALS['mira']['rogzit_ev_veg_ho'];
  $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$tmp_modho_ki[0]['ho_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_modho_ki[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  unset($tmp_modho_ki);
 }
 
}else{
 $GLOBALS['mira']['rogzit_ev_veg_ev']="";
 $GLOBALS['mira']['rogzit_ev_veg_ho']="";
 $GLOBALS['mira']['rogzit_ev_veg_nap']="";
}
//Vége hónap lekezelése - vége

//Userhez kötött munkaidő - eleje
//if($tomb_user['user_napi_ido_max_ora']>0){
if(
($tomb_user['user_napi_ido_max_ora']>0)
or
(
 ($tomb_user['user_napi_ido_max_ora']==0)and
 ($tomb_user['user_napi_ido_max_perc']>0)
)
){
 $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":00";

 if($tomb_user['user_napi_ido_max_perc']>9){
  $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":".$tomb_user['user_napi_ido_max_perc'];
 }else{
  $GLOBALS['mira']['napi_ido_max']=$tomb_user['user_napi_ido_max_ora'].":0".$tomb_user['user_napi_ido_max_perc'];
 }
 
 $GLOBALS['mira']['napi_ido_max_ora']=$tomb_user['user_napi_ido_max_ora'];
 $GLOBALS['mira']['napi_ido_max_perc']=$tomb_user['user_napi_ido_max_perc'];
}else{
 //$GLOBALS['mira']['napi_ido_max']=$tomb_user['napi_ido_max_ora'].":00";//Ennél többet nem enged 1 napra rögzíteni
 //$GLOBALS['mira']['napi_ido_max_ora']=$tomb_user['napi_ido_max_ora'];//Ennél többet nem enged 1 napra rögzíteni
 $GLOBALS['mira']['napi_ido_max']=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'].":00";//Ennél többet nem enged 1 napra rögzíteni
 $GLOBALS['mira']['napi_ido_max_ora']=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];//Ennél többet nem enged 1 napra rögzíteni
 $GLOBALS['mira']['napi_ido_max_perc']='0';
}
//Userhez kötött munkaidő - vége

//$GLOBALS['mira']['napi_osszes_ido_min']=$tomb_user['napi_osszes_ido_min_ora'].":00";//Ha ennél kevesebbet ír, akkor piros lesz az összesítés
//$GLOBALS['mira']['napi_osszes_ido_min_ora']=$tomb_user['napi_osszes_ido_min_ora'];//Ha ennél kevesebbet ír, akkor piros lesz az összesítés
$GLOBALS['mira']['napi_osszes_ido_min']=$GLOBALS['tagv_alap_napi_osszes_ido_min_ora'].":00";//Ha ennél kevesebbet ír, akkor piros lesz az összesítés
$GLOBALS['mira']['napi_osszes_ido_min_ora']=$GLOBALS['tagv_alap_napi_osszes_ido_min_ora'];//Ha ennél kevesebbet ír, akkor piros lesz az összesítés

if(($full_admin=='1')and($tomb_user['ful_admin']=='1')){

$GLOBALS[$GLOBALS['sessionname']]['user_admin_muvelet']=$tomb_user['user_admin_muvelet'];

//admin - user_userlist_keres_talszam - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_userlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_userlist_keres_talszam']=$tomb_user['user_userlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['user_userlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['user_userlist_keres_order']=$tomb_user['user_userlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['user_userlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['user_userlist_keres_order_mod']=$tomb_user['user_userlist_keres_order_mod'];
//user_userlist_keres_talszam - vége

//admin -szerv_szervlist_keres_talszam - eleje
 if(!isset($GLOBALS['mira']['user_jog']['szervlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['szervlist_keres_talszam']=$tomb_user['szerv_szervlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['szervlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['szervlist_keres_order']=$tomb_user['szerv_szervlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']=$tomb_user['szerv_szervlist_keres_order_mod'];
//szerv_szervlist_keres_talszam - vége

//admin - projekt_projektlist_keres_talszam - eleje
 if(!isset($GLOBALS['mira']['user_jog']['projektlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['projektlist_keres_talszam']=$tomb_user['projekt_projektlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['projektlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['projektlist_keres_order']=$tomb_user['projekt_projektlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']=$tomb_user['projekt_projektlist_keres_order_mod'];
//projekt_projektlist_keres_talszam - vége

//admin - Árazási relevancia mező eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam']=$tomb_user['admin_arazasreflist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_order']=$tomb_user['admin_arazasreflist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_order_mod']=$tomb_user['admin_arazasreflist_keres_order_mod'];
//admin - Árazási relevancia mező vége

//admin - admin_tagv_kod - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam']=$tomb_user['admin_tagvkodlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_order']=$tomb_user['admin_tagvkodlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_order_mod']=$tomb_user['admin_tagvkodlist_keres_order_mod'];
//admin_tagv_kod - vége

//admin - admin_szolg_kod - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']=$tomb_user['admin_szolgkodlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order']=$tomb_user['admin_szolgkodlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']=$tomb_user['admin_szolgkodlist_keres_order_mod'];
//admin_szolg_kod - vége

//admin - Csoportosítási név - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam']=$tomb_user['admin_csopnevlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_order']=$tomb_user['admin_csopnevlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_order_mod']=$tomb_user['admin_csopnevlist_keres_order_mod'];
//Csoportosítási név - vége

//admin - Kategória - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam']=$tomb_user['admin_katnevlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_katnevlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_katnevlist_keres_order']=$tomb_user['admin_katnevlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_katnevlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_katnevlist_keres_order_mod']=$tomb_user['admin_katnevlist_keres_order_mod'];
//Kategória - vége

//Admin - Tulajdonosi joggyakorló lista - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam']=$tomb_user['admin_kapcstulajlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_order']=$tomb_user['admin_kapcstulajlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_order_mod']=$tomb_user['admin_kapcstulajlist_keres_order_mod'];
//Admin - Tulajdonosi joggyakorló lista - vége

//Admin - Kapcsolattartó törzsadatok - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam']=$tomb_user['admin_kapcstorzslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_order']=$tomb_user['admin_kapcstorzslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_order_mod']=$tomb_user['admin_kapcstorzslist_keres_order_mod'];
//Admin - Kapcsolattartó törzsadatok - vége

//Admin - Társasági és szolgáltatási kapcsolattartó összerendelés - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam']=$tomb_user['admin_kapcsosszelist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_order']=$tomb_user['admin_kapcsosszelist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_order_mod']=$tomb_user['admin_kapcsosszelist_keres_order_mod'];
//Admin - Társasági és szolgáltatási kapcsolattartó összerendelés - vége

//Admin - Tervezés - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam']=$tomb_user['admin_tervezeslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_order']=$tomb_user['admin_tervezeslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_order_mod']=$tomb_user['admin_tervezeslist_keres_order_mod'];
//Admin - Tervezés - vége

//Admin - Ténypótlás - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam']=$tomb_user['admin_tenypotlaslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_order']=$tomb_user['admin_tenypotlaslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_order_mod']=$tomb_user['admin_tenypotlaslist_keres_order_mod'];
//Admin - Ténypótlás - vége

//Admin - TénypótlásTIG - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_talszam']=$tomb_user['admin_tenypotlastiglist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_order']=$tomb_user['admin_tenypotlastiglist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tenypotlastiglist_keres_order_mod']=$tomb_user['admin_tenypotlastiglist_keres_order_mod'];
//Admin - TénypótlásTIG - vége

//Admin - Szerződés típus - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_talszam']=$tomb_user['admin_szerztipuslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_order']=$tomb_user['admin_szerztipuslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szerztipuslist_keres_order_mod']=$tomb_user['admin_szerztipuslist_keres_order_mod'];
//Admin - Szerződés típus - vége

//Admin - Szerződéses alapadatok - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_talszam']=$tomb_user['admin_szerzalapadatlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_order']=$tomb_user['admin_szerzalapadatlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szerzalapadatlist_keres_order_mod']=$tomb_user['admin_szerzalapadatlist_keres_order_mod'];
//Admin - Szerződéses alapadatok - vége

//Admin - Szerződéses feltöltés - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_talszam']=$tomb_user['admin_szerzfeltoltlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_order']=$tomb_user['admin_szerzfeltoltlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szerzfeltoltlist_keres_order_mod']=$tomb_user['admin_szerzfeltoltlist_keres_order_mod'];
//Admin - Szerződéses feltöltés - vége

//Admin - Társaság kategória - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_talszam']=$tomb_user['admin_tarskatlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_order']=$tomb_user['admin_tarskatlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tarskatlist_keres_order_mod']=$tomb_user['admin_tarskatlist_keres_order_mod'];
//Admin - Társaság kategória - vége

//Admin - Szolgáltatás csoport - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_talszam']=$tomb_user['admin_szolgcsoplist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_order']=$tomb_user['admin_szolgcsoplist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsoplist_keres_order_mod']=$tomb_user['admin_szolgcsoplist_keres_order_mod'];
//Admin - Szolgáltatás csoport - vége

//Admin - Szolgáltatás csoport szolgkod - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_talszam']=$tomb_user['admin_szolgcsophozszolgkodlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_order']=$tomb_user['admin_szolgcsophozszolgkodlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szolgcsophozszolgkodlist_keres_order_mod']=$tomb_user['admin_szolgcsophozszolgkodlist_keres_order_mod'];
//Admin - Szolgáltatás csoport szolgkod - vége

//Admin - Elszámolás típusa - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_talszam']=$tomb_user['admin_elsztipuslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_order']=$tomb_user['admin_elsztipuslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_elsztipuslist_keres_order_mod']=$tomb_user['admin_elsztipuslist_keres_order_mod'];
//Admin - Elszámolás típusa - vége

//Admin - Naturália típusa - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_talszam']=$tomb_user['admin_nattipuslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_order']=$tomb_user['admin_nattipuslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_nattipuslist_keres_order_mod']=$tomb_user['admin_nattipuslist_keres_order_mod'];
//Admin - Naturália típusa - vége

//Admin - Szerződésgazda - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_talszam']=$tomb_user['admin_szerzusergazdalist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_order']=$tomb_user['admin_szerzusergazdalist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szerzusergazdalist_keres_order_mod']=$tomb_user['admin_szerzusergazdalist_keres_order_mod'];
//Admin - Szerződésgazda - vége

//Admin - Szolgáltatáshoz kapcsolódó adatok - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_talszam']=$tomb_user['admin_szolgkapadatlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_order']=$tomb_user['admin_szolgkapadatlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_order_mod']=$tomb_user['admin_szolgkapadatlist_keres_order_mod'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_urlaprejt']))
	 $GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_urlaprejt']=$tomb_user['admin_szolgkapadatlist_keres_urlaprejt'];
//Admin - Szolgáltatáshoz kapcsolódó adatok - vége

//Admin - Szolgáltatás módosításához kapcsolódó adatok - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_talszam']=$tomb_user['admin_szolgmodadatlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_order']=$tomb_user['admin_szolgmodadatlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_szolgmodadatlist_keres_order_mod']=$tomb_user['admin_szolgmodadatlist_keres_order_mod'];
//Admin - Szolgáltatás módosításához kapcsolódó adatok - vége

//Admin - Tigelés sapszam - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_talszam']=$tomb_user['admin_tigadatsapszamlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_order']=$tomb_user['admin_tigadatsapszamlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatsapszamlist_keres_order_mod']=$tomb_user['admin_tigadatsapszamlist_keres_order_mod'];
//Admin - Tigelés sapszam - vége

//Admin - Tigelés co - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_talszam']=$tomb_user['admin_tigadatcolist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_order']=$tomb_user['admin_tigadatcolist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatcolist_keres_order_mod']=$tomb_user['admin_tigadatcolist_keres_order_mod'];
//Admin - Tigelés co - vége

//Admin - Vevő azonosító - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_talszam']=$tomb_user['admin_tigadatvevoazonlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_order']=$tomb_user['admin_tigadatvevoazonlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatvevoazonlist_keres_order_mod']=$tomb_user['admin_tigadatvevoazonlist_keres_order_mod'];
//Admin - Vevő azonosító - vége

//Admin - Nem szerződés alapján TIG-elendő tételek - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_talszam']=$tomb_user['admin_tigadatnemszerzlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_order']=$tomb_user['admin_tigadatnemszerzlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_tigadatnemszerzlist_keres_order_mod']=$tomb_user['admin_tigadatnemszerzlist_keres_order_mod'];
//Admin - Nem szerződés alapján TIG-elendő tételek - vége

//Admin - Intergációs adatok co - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_integadatlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_integadatlist_keres_talszam']=$tomb_user['admin_integadatlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_integadatlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_integadatlist_keres_order']=$tomb_user['admin_integadatlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_integadatlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_integadatlist_keres_order_mod']=$tomb_user['admin_integadatlist_keres_order_mod'];
//Admin - Intergációs adatok co - vége

//Admin - log- eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_loglist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_loglist_keres_talszam']=$tomb_user['admin_loglist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_loglist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_loglist_keres_order']=$tomb_user['admin_loglist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_loglist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_loglist_keres_order_mod']=$tomb_user['admin_loglist_keres_order_mod'];
//Admin - log vége


//Admin - szolgáltatás tevékenység eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_talszam']=$tomb_user['admin_ujszolgkapadatprojektlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_order']=$tomb_user['admin_ujszolgkapadatprojektlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_ujszolgkapadatprojektlist_keres_order_mod']=$tomb_user['admin_ujszolgkapadatprojektlist_keres_order_mod'];
//Admin - szolgáltatás tevékenység vége

//Szervezethez jóváhagyó tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']=$tomb_user['user_szervjovahagyo_keres_talszam'];
//Szervezethez jóváhagyó tallistszám - vége

//Tevékenységhez user tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']=$tomb_user['user_projuserhozza_keres_talszam'];
//Tevékenységhez user tallistszám - vége

//Userhez tevékenység hozzárendelés tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']=$tomb_user['user_projekthozza_keres_talszam'];
//Userhez tevékenység hozzárendelés tallistszám - vége

//Tevékenységhez user hozzárendelés tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']=$tomb_user['user_ujtevekenyseguserhozza_keres_talszam'];
//Tevékenységhez user hozzárendelés tallistszám - vége

//Userhez tevékenység hozzárendelés tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']=$tomb_user['user_ujtevekuserhozza_keres_talszam'];
//Userhez tevékenység hozzárendelés tallistszám - vége

//Admin felettes jóváhagyó hozzárendelés tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']=$tomb_user['user_felettesjovahagyo_keres_talszam'];
//Admin felettes jóváhagyó hozzárendelés tallistszám - vége

//Stat projekt jog user tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']=$tomb_user['user_stat_projekthozza_keres_talszam'];
//Stat projekt jog user tallistszám - vége

//Stat projekt user jóváhagyás tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']=$tomb_user['user_projuserjovahagyohozza_keres_talszam'];
//Stat projekt user jóváhagyás tallistszám - vége

//User projekt jóváhagyás tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']=$tomb_user['user_projektjovahagyohozza_keres_talszam'];
//User projekt jóváhagyás tallistszám - vége

//KPI szolg kód tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_talszam']=$tomb_user['admin_kpiszolgkodlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_order']=$tomb_user['admin_kpiszolgkodlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kpiszolgkodlist_keres_order_mod']=$tomb_user['admin_kpiszolgkodlist_keres_order_mod'];
//KPI szolg kód jóváhagyás tallistszám - vége

//KPI típus jóváhagyás tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_talszam']=$tomb_user['admin_kpitipuslist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_order']=$tomb_user['admin_kpitipuslist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kpitipuslist_keres_order_mod']=$tomb_user['admin_kpitipuslist_keres_order_mod'];
//KPI típus jóváhagyás tallistszám - vége

//KPI összekapcs tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_talszam']=$tomb_user['admin_kpiosszekaplist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_order']=$tomb_user['admin_kpiosszekaplist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_kpiosszekaplist_keres_order_mod']=$tomb_user['admin_kpiosszekaplist_keres_order_mod'];
//KPI összekapcs tallistszám - vége

}

//Jóváhagyói cuccok - eleje
if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']==1){
 if(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']))
	 $GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']=$tomb_user['jovahagy_szur_szerv_id'];
 if(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']))
	 $GLOBALS['mira']['user_jog']['jovahagy_szur_ev']=$tomb_user['jovahagy_szur_ev'];
 if(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']))
	 $GLOBALS['mira']['user_jog']['jovahagy_szur_ho']=$tomb_user['jovahagy_szur_ho'];
 if(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']))
	 $GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']=$tomb_user['jovahagy_szur_user_ad'];
}
//Jóváhagyói cuccok - vége

//Riport - szerződésnyilv - eleje
if($tomb_user['ful_riport']=='1'){
 if(!isset($GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam']=$tomb_user['admin_riportszerznyilvlist_keres_talszam'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_order']))
	 $GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_order']=$tomb_user['admin_riportszerznyilvlist_keres_order'];
 if(!isset($GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_order_mod']))
	 $GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_order_mod']=$tomb_user['admin_riportszerznyilvlist_keres_order_mod'];
}
//Riport - szerződésnyilv - vége

//Statisztika szűrés - eleje
if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==1){
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_ev']))
	 $GLOBALS['mira']['user_jog']['stat_leker_ev']=$tomb_user['stat_leker_ev'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_ho']))
	 $GLOBALS['mira']['user_jog']['stat_leker_ho']=$tomb_user['stat_leker_ho'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_nap']))
	 $GLOBALS['mira']['user_jog']['stat_leker_nap']=$tomb_user['stat_leker_nap'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_szerv_id']))
	 $GLOBALS['mira']['user_jog']['stat_leker_szerv_id']=$tomb_user['stat_leker_szerv_id'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_projekt_id']))
	 $GLOBALS['mira']['user_jog']['stat_leker_projekt_id']=$tomb_user['stat_leker_projekt_id'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_kiuser']))
	 $GLOBALS['mira']['user_jog']['stat_leker_kiuser']=$tomb_user['stat_leker_kiuser'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_user']))
	 $GLOBALS['mira']['user_jog']['stat_leker_user']=$tomb_user['stat_leker_user'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_tipus']))
	 $GLOBALS['mira']['user_jog']['stat_leker_tipus']=$tomb_user['stat_leker_tipus'];
 if(!isset($GLOBALS['mira']['user_jog']['stat_leker_maxuser']))
	 $GLOBALS['mira']['user_jog']['stat_leker_maxuser']=$tomb_user['stat_leker_maxuser'];
}
//Statisztika szűrés - vége

//Helyettes tallistszám - eleje
 if(!isset($GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam']))
	 $GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam']=$tomb_user['user_modhelyettes_keres_talszam'];
//Helyettes tallistszám - vége

}else{
 logout();//Ekkor nem kapott jogot egy modulra se.
}

}else{
 logout();
}

if(isset($_SESSION[$GLOBALS['sessionname']])){
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
 login_helyettes();
}

}

function nincs_joga(){
 echo "<div style='text-align:center;display: block;margin:auto;width:50%;'>";
 //echo "<span class='focim'>".$GLOBALS['rend_nev'].$GLOBALS['rend_str']."<br><br>";
 echo "<span class='focim'>".$GLOBALS['rend_nev'].$GLOBALS['rend_nev_tilte'];
 if($GLOBALS['tesztdevmod']!=""){
  echo " -".$GLOBALS['tesztdevmod'];
 }
 echo "<br><br>";
 echo "Nincs jogosultságod!<br><br>";
 if(isset($_SERVER['REMOTE_USER']))echo $_SERVER['REMOTE_USER'];
 echo "</span></div><br>";
 alairas_ki();
 echo '</body></html>';
 exit;
}

function logout(){
 unset($_SESSION[$GLOBALS['sessionname']]);
}


function keres_user_login($ad,$full_admin){
$eredmeny_keres="";
$ad=mysqli_real_escape_string($GLOBALS['mysqli'],$ad);

$sql="select 
mira_user.*,
mira_szerv.szerv_nev,
mira_user_ker_jog.*
";

if($full_admin=='1'){
 $sql.=',mira_user_admin_jog.*';
 $sql.=',mira_user_ker_jog_admin.*';
}

$sql.=" FROM mira_user
inner join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id
inner join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad ";
//inner join mira_tagv ON mira_tagv.tagv = mira_user.user_tagv

if($full_admin=='1'){
 $sql.='left join mira_user_admin_jog ON mira_user_admin_jog.admin_jog_user_ad = mira_user.user_ad and mira_user.ful_admin="1" ';
 $sql.='left join mira_user_ker_jog_admin ON mira_user_ker_jog_admin.user_ad = mira_user.user_ad ';
}

$sql.=" where
mira_user.user_ad='".$ad."'
and mira_user.user_inaktiv='0'";

 //print $sql."<br>";
 //exit;
 //$adat=mysqli_query($GLOBALS['mysqli'],$sql);
 /*
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom;
 }
 return $eredmeny_keres;
 */
 //return mysqli_fetch_assoc($adat);
 return mysqli_fetch_assoc(mysqli_query($GLOBALS['mysqli'],$sql));
}

?>
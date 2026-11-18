<?php
session_start();

include_once("config_uj.php"); 
include_once("function.php");
include_once("function_mysql.php");

if(
(isset($_POST['mod']))and(isset($_POST['ful']))and
($_POST['mod']=='ful_letolt')and
($_POST['ful']=='ful_admin')
){
 login('1');
}else{
 login();
}
 
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 echo "logout";
 exit;
}
	
//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
///////////////////header("Cache-Control: no-cache");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");
	
if(isset($_POST['mod'])){
switch($_POST['mod']){
case'ful_letolt':
 include_once("ajax_func.php");
 ful_letolt();
break;

/*
case'fo_table_ev_change':
 
 if(!isset($_POST['ev'])){
	 echo "Rendszerhiba$;$";
	 exit;
 }
 
 $tmp_mod[0]['ev_ki']=$_POST['ev'];
 mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 
 echo "ok$;$";
 ho_fotable_ki();
break;
*/

case'fo_table_ki':
 include_once("ajax_func.php");
 include_once("rogzit_table.php");
 echo "ok$;$";

 //Helyettes cucc - eleje
 if(
 (isset($_POST['hely_user_ad']))and
 ($_POST['hely_user_ad']!="")
 ){
  if(
  ($_POST['hely_user_ad']==$_SESSION[$GLOBALS['sessionname']]['login_ad'])and
  ($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
  ){
	  $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']="";
	  $GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev']="";
	  login();
  }else{
	  $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=$_POST['hely_user_ad'];
	  login_helyettes();
  }
	 
 }
 //Helyettes cucc - vége
 
 if(
 (!isset($_POST['ev']))and
 (!isset($_POST['ho']))and
 ($_POST['ev']=="")and
 ($_POST['ho']=="")
 ){
	 echo "paraméter hiba$;$";
 }else{

 $hotabla_ki=0;
 //Ha volt évváltás, akkor rendezzük le
 if($_SESSION[$GLOBALS['sessionname']]['ev_ki']!=$_POST['ho']){
  $tmp_mod[0]['ev_ki']=$_POST['ev'];
  
  //Év váltás esetén legyen mindig január, csak ha nem az első év - eleje
  if(
  ($_POST['ev']!=$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['ev']!=$_SESSION[$GLOBALS['sessionname']]['ev_ki'])
  ){
	$_POST['ho']=1;
  }
  //Év váltás esetén legyen mindig január, csak ha nem az első év - vége
  
  //Év váltás első év esetén a kezdő hó - eleje
  if(
  ($_POST['ev']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['ev']!=$_SESSION[$GLOBALS['sessionname']]['ev_ki'])
  ){
	$_POST['ho']=$GLOBALS['mira']['ev_kezdo_ho'];
  }
  //Év váltás első év esetén a kezdő hó - vége
  
  $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$_POST['ev'];
  
  if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!='') 
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']); 
  else
	  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']); 
  $hotabla_ki=1;
  
  //Ha az aktuális év-hó páros kisebb mint a minimum év, akkor hó átállítás
  if(
  ($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_SESSION[$GLOBALS['sessionname']]['ho_ki']<$GLOBALS['mira']['ev_kezdo_ho'])
  ){
	$_POST['ho']=$GLOBALS['mira']['ev_kezdo_ho'];  
  }

 }
 
 //Ha volt hóváltás, akkor rendezzük le
 if($_SESSION[$GLOBALS['sessionname']]['ho_ki']!=$_POST['ho']){
  $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$_POST['ho'];
  $tmp_mod[0]['ho_ki']=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
  if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!='') 
   mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);
  else
   mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  $hotabla_ki=1;
 }
 
 //Ha az év nem az akt ésvagy nem az akt hó, akkor a nap nem lehet az aktuális, legyen áll!
 $evmost=date("Y",time());
 $homost=date("n",time());
 if(
 ($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="ma")and
 (($_SESSION[$GLOBALS['sessionname']]['ev_ki']!=$evmost)or($_SESSION[$GLOBALS['sessionname']]['ho_ki']!=$homost))
 ){
  $_POST['nap']="all"; 
 }
 
  //Ha volt napváltás, akkor rendezzük le
 if($_SESSION[$GLOBALS['sessionname']]['nap_ki']!=$_POST['nap']){
  $_SESSION[$GLOBALS['sessionname']]['nap_ki']=$_POST['nap'];
  $tmp_mod[0]['nap_ki']=$_SESSION[$GLOBALS['sessionname']]['nap_ki'];
  if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!='') 
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);
  else
	  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  $hotabla_ki=1;
 }
 
 //if($hotabla_ki==1){//1.020 mindig van már....
  ho_fotable_ki();
 //}
 
 ////1.020//echo "$;$";
 
 //fo_bevitel_honap_kirajzol($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_POST['ho']);
 fo_bevitel_honap_kirajzol($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki']);
 
 }
break;

case'rogzit_ment':
 include_once("rogzit_table.php");
 rogzit_ment('');
break;
case'rogzit_elkuld_ell_allment':
 include_once("rogzit_table_allment.php");
 include_once("rogzit_table.php");
 rogzit_ment_allment();
break;
case'rogzit_elkuld_ell_allment_vanenet':
 include_once("rogzit_table.php");
 rogzitheto_ho_e_hanem_reload();
 echo 'ok$;$';
break;

case'tavollet_rogzit_ment':
 include_once("rogzit_table.php");
 tavollet_rogzit_ment();
break;

case'rogzit_megj_ment':
 include_once("rogzit_table.php");
 rogzit_megj_ment();
break;

case'tavollet_rogzit_del':
 include_once("rogzit_table.php");
 tavollet_rogzit_del();
break;

case'rogzit_elkuld_ell':
 include_once("rogzit_table.php");
 rogzit_elkuld_ell(); 
break;

case'rogzit_elkuld_ell_proc_kerd_utan':
 include_once("rogzit_table.php");
 rogzit_elkuld_ell_proc_kerd_utan("0"); 
break;
case'jovahagy_kezi_lezaras_proc_kerd_utan':
 include_once("rogzit_table.php");
  rogzit_elkuld_ell_proc_kerd_utan("1");  
break;

case'jovahagy_infok_leker':
  include_once("rogzit_jovahagy.php");
  jovahagy_infok_leker();  
break;

case'jovahagy_proc_visszakuldheto_e':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_visszakuldheto_e(); 
break;

case'jovahagy_proc_visszakuld_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_visszakuld_kerd_utan(); 
break;
case'jovahagy_proc_visszakuld_projvezeto_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_visszakuld_projvezeto_kerd_utan(); 
break;

case'jovahagy_proc_ok_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_ok_kerd_utan(); 
break;

case'jovahagy_proc_ok_projvezeto_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_ok_projvezeto_kerd_utan(); 
break;

case'jovahagy_proc_ok_tom_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_ok_tom_kerd_utan(); 
break;

case'jovahagy_proc_ok_tom_projvezeto_kerd_utan':
 include_once("rogzit_jovahagy.php");
 jovahagy_proc_ok_tom_projvezeto_kerd_utan(); 
break;

case'proj_kov_sor':
 include_once("ajax_func.php");
 proj_kov_sor();
break;

case'stat_leker':
 include_once("rogzit_stat_html_tal.php");
 stat_leker();
break;

case'fo_table_evho_elsoki':
 fo_table_evho_elsoki(); 
break;

case'user_modhelyettes_hozz_keress':
 include_once("ajax_func.php");
 user_modhelyettes_hozz_keress();
break;

case'user_modhelyettes_hozz_change':
 include_once("ajax_func.php");
 user_modhelyettes_hozz_change();
break;

case'inditTetrisz':
 $_SESSION[$GLOBALS['sessionname']]['login_nev']=$GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 echo 'ok$;$';
break;

case'rogzito_helyettes_beallit':
 
 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!=""){
  echo "nook$;$";
 }else{//Csak sajűt magára lehet ilyet beállítani, helyettesre nem!
 include_once("ajax_func.php");
 $_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 rogzito_helyettes_beallit();
 }
break;

case'jovahagy_keress':
 include_once("rogzit_jovahagy.php");
 jovahagy_ful_ki_tal(); 
break;

case'jovahagy_evvalt':
 include_once("rogzit_jovahagy.php");
 jovahagy_evvalt(); 
break;

case'jovahagyuser_sor_mouse':
 include_once("rogzit_jovahagy.php");
 jovahagyuser_sor_mouse(); 
break;

case'stat_leker_ev_change':
 include_once("rogzit_stat.php");
 stat_leker_ev_change(); 
break;

case'max_user_change':
 include_once("rogzit_stat.php");
 max_user_change(); 
break;

case'raford_projekt_meg_katt':
 include_once("ajax_func.php");
 include_once("rogzit_table.php");
 raford_projekt_meg_katt(); 
break;

case'raford_projekt_meg_katt_dialog_mentes':
 include_once("ajax_func.php");
 raford_projekt_meg_katt_dialog_mentes(); 
break;

case'riport_teny3_1_1_ev1_change':
 include_once("riport.php");
 riport_teny3_1_1_ev1_change(); 
break;
case'riport_teny3_2_ev1_change':
 include_once("riport.php");
 riport_teny3_2_ev1_change(); 
break;
case'riport_teny3_3_ev1_change':
 include_once("riport.php");
 riport_teny3_3_ev1_change(); 
break;
case'riport_teny3_ev1_change':
 include_once("riport.php");
 riport_teny3_ev1_change(); 
break;

case'riport_teny3_elteres_ev1_change':
 include_once("riport.php");
 riport_teny3_elteres_ev1_change(); 
break;

case'riport_nonp_ev1_change':
 include_once("riport.php");
 riport_nonp_ev1_change(); 
break;
case'riport_tipus_change':
 include_once("riport.php");
 riport_tipus_change(); 
break;
case'riport_kapcsosszelist_keres':
 include_once("riport_kapcsossze.php");
 riport_ful_ki_kapcs_ossze_html_keres(); 
break;

case'riport_tervteny_adat_ment':
  include_once("riport_func.php");
 riport_tervteny_adat_ment(); 
break;
case'riport_tervteny_ev_change_hole':
  include_once("riport_func.php");
 riport_tervteny_ev_change_hole(); 
break;
case'riport_tervteny_szerv_listle':
  include_once("riport_func.php");
 riport_tervteny_szerv_listle(); 
break;
case'riport_tervteny_projekt_listle':
  include_once("riport_func.php");
 riport_tervteny_projekt_listle(); 
break;
case'riport_tervteny_szolgkod_listle':
  include_once("riport_func.php");
 riport_tervteny_szolgkod_listle(); 
break;
case'riport_tervteny_tagv_listle':
  include_once("riport_func.php");
 riport_tervteny_tagv_listle(); 
break;
case'riport_tervteny_user_listle':
  include_once("riport_func.php");
 riport_tervteny_user_listle(); 
break;

case'rogzit_adatok_masol':
  include_once("rogzit_adatok_masol.php");
 rogzit_adatok_masol(); 
break;
case'rogzit_adatok_masol_proc_ment_proc':
  include_once("rogzit_adatok_masol.php");
 rogzit_adatok_masol_proc_ment_proc(); 
break;

}
}

function fo_table_evho_elsoki(){
  //include_once("function.php");

 include_once("ajax_func.php");
 include_once("rogzit_table.php");
 
 echo "ok$;$";
 
 ho_fotable_ki();
 
 ////1.020//echo "$;$";
 fo_bevitel_honap_kirajzol($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki']);

}
?>
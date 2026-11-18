<?php

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

//$_POST['mod']="ad_email";
//$_POST['ad']="a2675";

if(!isset($_POST['ad']))
	 exit;
/*
$ldaprdn = 'a2675@mvmh.local';
$ldappass = 'Retoocs38..';*/

ldap_set_option(NULL, LDAP_OPT_NETWORK_TIMEOUT,2);
ldap_set_option(NULL, LDAP_OPT_TIMELIMIT,2);

$ldaprdn = 'pa-kontoscan@mvmh.local';
$ldappass = 'Gorbe4Nora';
$sdn = 'OU=Domain Users,dc=mvmh,dc=local';
$sdn = 'dc=mvmh,dc=local';
//$sdn_tilt='OU=Collected Trash,dc=mvmh,dc=local';
$ldapconn = ldap_connect("ldap://mvmh.local") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

$GLOBALS['attributes'] = ['cn', 'mail', 'employeenumber', 'division','useraccountcontrol']; // Kívánt attribútumok

if ($ldapconn) {
if(strlen($_POST['ad'])==5){
// binding to ldap server
$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

//if($_POST['mod']=="ad_email"){
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn, $sdn, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn, $sr);
 ldap_close($ldapconn);
}
	
}else{
echo "LDAP conn sikertelen";exit;
}

//print_r($entry[0]['mail']);
echo "ok$;$";
if((strlen($_POST['ad'])==5)and(isset($entry[0]))and(is_array($entry[0]))){
 ered_ki($entry);
}else{//Ekkor üres meg vissza

  $entry_decom=con_decom();
  if((isset($entry_decom[0]))and(is_array($entry_decom[0]))and($entry_decom['count']!="0")){
   //$entry_decom[0]['tartomany']="decom01";
   ered_ki($entry_decom);
  }else{
	
	$entry_denet=con_denet();
	if((isset($entry_denet[0]))and(is_array($entry_denet[0]))and($entry_denet['count']!="0")){
	   //$entry_denet[0]['tartomany']="denet01";
	   ered_ki($entry_denet);  
	}else{
		
		$entry_fogaz=con_fogaz();
		if((isset($entry_fogaz[0]))and(is_array($entry_fogaz[0]))and($entry_fogaz['count']!="0")){
		  //$entry_fogaz[0]['tartomany']="fogaz";
	      ered_ki($entry_fogaz); 
		}else{
			
		 $entry_egaz_degaz=con_egaz_degaz();
		 if((isset($entry_egaz_degaz[0]))and(is_array($entry_egaz_degaz[0]))and($entry_egaz_degaz['count']!="0")){
		  //$entry_egaz_degaz[0]['tartomany']="egaz-degaz";
	      ered_ki($entry_egaz_degaz); 
		 }else{
			  //Csak a végén, ha nincs sehol semmi...
			  echo ""."$;$"."";
		 }
		}
	}
	  
  }
 
 //Csak a végén, ha nincs sehol semmi...
 //echo ""."$;$"."";
}

function ered_ki($entry){
if(isset($entry[0]['cn'][0]))
 echo $entry[0]['cn'][0];
echo "$;$";
if(isset($entry[0]['mail'][0]))
 echo $entry[0]['mail'][0];
else
 echo "";

echo "$;$";
if(isset($entry[0]['employeenumber'][0]))
 echo $entry[0]['employeenumber'][0];
else
 echo "";

//Részlegkód
echo "$;$";
if((isset($entry[0]["division"][0]))and($entry[0]["division"][0]!="")){
 $tomb_ad_kod=explode("[",$entry[0]["division"][0]);
 if((isset($tomb_ad_kod[1]))and($tomb_ad_kod[1]!="")){
  $tomb2_ad_kod=explode("]",$tomb_ad_kod[1]);
  
  if((isset($tomb2_ad_kod[0]))and($tomb2_ad_kod[0]!="")){
   echo $tomb2_ad_kod[0];
  }else{
   echo "";
  }
 
 }else{
  echo "";
 }
}else{
 echo "";
}

//Letiltott-e?
echo "$;$";
echo letiltott_e($entry);
}

function letiltott_e($entry){
$ret='';

if(
(isset($entry[0]['useraccountcontrol'][0]))and
($entry[0]['useraccountcontrol'][0]!="512")and($entry[0]['useraccountcontrol'][0]!="544")
){
 $ret.=' Letiltott: '.$entry[0]['useraccountcontrol'][0].' - ';
 switch($entry[0]['useraccountcontrol'][0]){
	 case"514":$ret.="Disabled Account";break;
	 case"546":$ret.="Disabled, Password Not Required";break;
	 case"546":$ret.="Disabled, Password Not Required";break;
	 case"66050":$ret.="Disabled, Password Doesn't Expire";break;
	 case"66080":$ret.="Enabled, Password Doesn't Expire & Not Required";break;
	 case"66082":$ret.="Disabled, Password Doesn't Expire & Not Required";break;
	 case"66082":$ret.="Disabled, Password Doesn't Expire & Not Required";break;
	 case"262656":$ret.="Disabled, Password Doesn't Expire & Not Required";break;
	 case"262658":$ret.="Disabled, Smartcard Required";break;
	 case"262688":$ret.="Enabled, Smartcard Required, Password Not Required";break;
	 case"262690":$ret.="Disabled, Smartcard Required, Password Not Required";break;
	 case"262692":$ret.="Enabled, Smartcard Required, Password Doesn't Expire";break;
	 case"262694":$ret.="Disabled, Smartcard Required, Password Doesn't Expire";break;
	 case"262224":$ret.="Enabled, Smartcard Required, Password Doesn't Expire & Not Required";break;
	 case"262226":$ret.="Disabled, Smartcard Required, Password Doesn't Expire & Not Required";break;
 }
}

return $ret;
}

function con_decom(){

$ldaprdn_decom01 = 'decom01-teszt-svc@decom01.net';
$ldappass_decom01 = '8YcyR785LX';

$sdn_decom01 = 'OU=Accounts,dc=decom01,dc=net';
$sdn_decom01 = 'dc=decom01,dc=net';

//$ldapconn_decom01 = ldap_connect("ldap://SECOMADDC001.decom01.net") or die("Not connect: $ldaphost ");
$ldapconn_decom01 = ldap_connect("ldap://decom01.net") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_decom01, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_decom01, LDAP_OPT_REFERRALS, 0);

if($ldapconn_decom01){
 $ldapbind = ldap_bind($ldapconn_decom01, $ldaprdn_decom01, $ldappass_decom01);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_decom01, $sdn_decom01, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn_decom01, $sr);
 ldap_close($ldapconn_decom01);
}else{
 echo "LDAP conn sikertelen decom";
 exit;
}
return $entry;
}

function con_denet(){

$ldaprdn_denet01 = 'denet01-teszt-svc@denet01.net';
$ldappass_denet01 = '8YcyR785LX';

$sdn_denet01 = 'OU=Accounts,dc=denet01,dc=net';
$sdn_denet01 = 'dc=denet01,dc=net';

//$ldapconn_denet01 = ldap_connect("ldap://SENETADDC001.denet01.net") or die("Not connect: $ldaphost ");
$ldapconn_denet01 = ldap_connect("ldap://denet01.net") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_denet01, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_denet01, LDAP_OPT_REFERRALS, 0);

if($ldapconn_denet01){
 $ldapbind = ldap_bind($ldapconn_denet01, $ldaprdn_denet01, $ldappass_denet01);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_denet01, $sdn_denet01, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn_denet01, $sr);
 ldap_close($ldapconn_denet01);
}else{
 echo "LDAP conn sikertelen decom";
 exit;
}
return $entry;
}


function con_fogaz(){

$ldaprdn_fogaz = 'fogaz-teszt-svc@fogaz.hu';
$ldappass_fogaz = 'dz2yOGPp7x';

$sdn_fogaz = 'OU=FOGAZ,dc=fogaz,dc=hu';
$sdn_fogaz = 'dc=fogaz,dc=hu';

//$ldapconn_fogaz = ldap_connect("ldap://fgmdc2.fogaz.hu") or die("Not connect: $ldaphost ");
$ldapconn_fogaz = ldap_connect("ldap://fogaz.hu") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_fogaz, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_fogaz, LDAP_OPT_REFERRALS, 0);

if($ldapconn_fogaz){
 $ldapbind = ldap_bind($ldapconn_fogaz, $ldaprdn_fogaz, $ldappass_fogaz);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_fogaz, $sdn_fogaz, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn_fogaz, $sr);
 ldap_close($ldapconn_fogaz);
}else{
 echo "LDAP conn sikertelen decom";
 exit;
}
return $entry;
}

function con_egaz_degaz(){

$ldaprdn_egaz_degaz = 'egaz-degaz-teszt-svc@egaz-degaz.hu';
$ldappass_egaz_degaz = 'ztNbZ1zfRn';

$sdn_egaz_degaz = 'OU=GDFSUEZ-Users,dc=egaz-degaz,dc=hu';
$sdn_egaz_degaz = 'dc=egaz-degaz,dc=hu';

//$ldapconn_egaz_degaz = ldap_connect("ldap://MASTER-DC.egaz-degaz.hu") or die("Not connect: $ldaphost ");
$ldapconn_egaz_degaz = ldap_connect("ldap://egaz-degaz.hu") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_egaz_degaz, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_egaz_degaz, LDAP_OPT_REFERRALS, 0);

if($ldapconn_egaz_degaz){
 $ldapbind = ldap_bind($ldapconn_egaz_degaz, $ldaprdn_egaz_degaz, $ldappass_egaz_degaz);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_egaz_degaz, $sdn_egaz_degaz, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn_egaz_degaz, $sr);
 ldap_close($ldapconn_egaz_degaz);
}else{
 echo "LDAP conn sikertelen decom";
 exit;
}
return $entry;
}

?>
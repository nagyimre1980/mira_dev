<?php
session_start();

include_once("config_uj.php"); 
include_once("function.php");
include_once("function_mysql.php");
login();

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

if(!isset($_POST['ad']))
	 exit;

echo "ok$;$";
//sleep(2);

/*
$ldaprdn = 'a2675@mvmh.local';
$ldappass = 'Retoocs38..';*/


ldap_set_option(NULL, LDAP_OPT_NETWORK_TIMEOUT,2);
ldap_set_option(NULL, LDAP_OPT_TIMELIMIT,2);

$ldaprdn = 'pa-kontoscan@mvmh.local';
$ldappass = 'Gorbe4Nora';
$sdn = 'OU=Domain Users,dc=mvmh,dc=local';
$sdn = 'dc=mvmh,dc=local';
$sdn_tilt='OU=Collected Trash,dc=mvmh,dc=local';
$ldapconn = ldap_connect("ldap://mvmh.local") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

$GLOBALS['attributes'] = ['cn', 'samaccountname', 'mail', 'company', 'division', 'title','telephonenumber','mobile','employeenumber','manager','jpegphoto','useraccountcontrol','accountexpires','lockouttime']; // Kívánt attribútumok

if ($ldapconn) {

if(strlen($_POST['ad'])==5){
// binding to ldap server
$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

//if($_POST['mod']=="ad_email"){
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn, $sdn, $filter,$GLOBALS['attributes']);
 $entry = ldap_get_entries($ldapconn, $sr);
}else{
 $entry="";
}

if((strlen($_POST['ad'])==5)and(isset($entry[0]))and(is_array($entry[0]))){
ldap_close($ldapconn);
//$entry[0]['tartomany']="mvmh";
ered_ki($entry);

}else{

/*
 $entry_nusz=con_nusz();
 if((isset($entry_nusz[0]))and(is_array($entry_nusz[0]))and($entry_nusz['count']!="0")){
  ered_ki($entry_nusz);
 }else{
*/

/*
  $entry_vszk=con_vszk();
  if((isset($entry_vszk[0]))and(is_array($entry_vszk[0]))and($entry_vszk['count']!="0")){
	ered_ki($entry_vszk);
  }else{
 */
 
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
			  //echo ""."$;$"."";
			  echo "&nbsp;&nbsp;<b>Nincs találat!</b>&nbsp;&nbsp;";
		 }
		}
	}
	  
  }
 //}
//}
}
	
}else{
//echo "LDAP conn sikertelen";
echo $_POST['ad'];
}

function ered_ki($entry){
echo "<table cellpadding=1 cellspacing=1 border=0 class='table_emre_sima_adinfo'>";
if(isset($entry[0]['cn'][0]))
 //echo "Név: ".$entry[0]['cn'][0];
 echo "<tr><td>Név: <td>".$entry[0]["cn"][0]."</tr>";
 echo "<tr><td>AD: <td>".$entry[0]["samaccountname"][0]."</tr>";
 if((isset($entry[0]["mail"][0]))and($entry[0]["mail"][0]!=""))
  echo "<tr><td>Email cim: <td>".$entry[0]["mail"][0]."</tr>";
 if(isset($entry[0]["company"][0]))
  echo "<tr><td>Cég: <td>".$entry[0]["company"][0]."</tr>";
 if((isset($entry[0]["division"][0]))and($entry[0]["division"][0]!=""))
  echo "<tr><td>Részleg: <td>".$entry[0]["division"][0]."</tr>";
 if((isset($entry[0]["title"][0]))and($entry[0]["title"][0]!=""))
  echo "<tr><td>Beosztás: <td>".$entry[0]["title"][0]."</tr>";
 if((isset($entry[0]["telephonenumber"][0]))and($entry[0]["telephonenumber"][0]!=""))
  echo "<tr><td>Telefon: <td>".$entry[0]["telephonenumber"][0]."</tr>";
 if(isset($entry[0]["mobile"][0]))
  echo "<tr><td>Mobil telefon: <td>".$entry[0]["mobile"][0]."</tr>";
 if((isset($entry[0]["employeenumber"][0]))and($entry[0]["employeenumber"][0]!=""))
  echo "<tr><td>Törzsszám: <td>".$entry[0]["employeenumber"][0]."</tr>";
 
 if((isset($entry[0]['manager']))and($entry[0]['manager'][0]!="")){
 $felettes1=explode(",",$entry[0]['manager'][0]);
 if(is_array($felettes1)){
 $felettes=explode("=",$felettes1[0]);
 if((is_array($felettes))and(isset($felettes[1])))
  echo "<tr><td>Felettes: <td>".$felettes[1]."</tr>";
 }
 }
 
//Letiltott AD - eleje
if(
(isset($entry[0]['useraccountcontrol'][0]))and
($entry[0]['useraccountcontrol'][0]!="512")and($entry[0]['useraccountcontrol'][0]!="544")
){
 echo "<tr><td colspan=2><span style='color:red;font-weight:bold'>Letiltva: ".$entry[0]['useraccountcontrol'][0]." - ";
 switch($entry[0]['useraccountcontrol'][0]){
	 case"514":echo "Disabled Account";break;
	 case"546":echo "Disabled, Password Not Required";break;
	 case"546":echo "Disabled, Password Not Required";break;
	 case"66050":echo "Disabled, Password Doesn't Expire";break;
	 case"66080":echo "Enabled, Password Doesn't Expire & Not Required";break;
	 case"66082":echo "Disabled, Password Doesn't Expire & Not Required";break;
	 case"66082":echo "Disabled, Password Doesn't Expire & Not Required";break;
	 case"262656":echo "Disabled, Password Doesn't Expire & Not Required";break;
	 case"262658":echo "Disabled, Smartcard Required";break;
	 case"262688":echo "Enabled, Smartcard Required, Password Not Required";break;
	 case"262690":echo "Disabled, Smartcard Required, Password Not Required";break;
	 case"262692":echo "Enabled, Smartcard Required, Password Doesn't Expire";break;
	 case"262694":echo "Disabled, Smartcard Required, Password Doesn't Expire";break;
	 case"262224":echo "Enabled, Smartcard Required, Password Doesn't Expire & Not Required";break;
	 case"262226":echo "Disabled, Smartcard Required, Password Doesn't Expire & Not Required";break;
 }
 echo "</span></tr>";
}else{

//Lejárt AD - eleje
if((isset($entry[0]["accountexpires"][0]))
	and($entry[0]["accountexpires"][0]!="9223372036854775807")
	and($entry[0]["accountexpires"][0]!="0")
)
 echo "<tr><td colspan=2><span style='color:red'><b>AD fiók lejárt:</b> ".date("Y.m.d. H:i:s - l",win_filetime_to_timestamp($entry[0]["accountexpires"][0]))."</span></tr>";
//Lejárt AD - vége

//Zárolt AD - eleje
if(
(isset($entry[0]['lockouttime'][0]))and
($entry[0]['lockouttime'][0]!="0")and($entry[0]['lockouttime'][0]!="")){
 echo "<tr><td colspan=2><span style='color:red;font-weight:bold'>Fiók Zárolva!</span></tr>";
}
//Zárolt AD - vége

}
//Letiltott AD - vége

 
 echo "<tr><td colspan=2 align=center>";
if((isset($entry[0]["jpegphoto"]))and($entry[0]["jpegphoto"][0]!="")){
 $imgData = base64_encode($entry[0]["jpegphoto"][0]);
 $src = 'data:jpeg;base64,'.$imgData;
 
}else{
 $imgData = base64_encode(file_get_contents("image/nokep.jpg"));
 $src = 'data:jpeg;base64,'.$imgData;
}
 echo '<img src="'.$src.'" style="max-width:100px">';
  echo "</tr>";
echo "</table>";
}

/*
function con_nusz(){
return false;
$entry="";
$sdn_nusz = 'OU=Domain Users,dc=nusz,dc=local';
$sdn_nusz = 'dc=nusz,dc=local';

$ldaprdn_nusz = '_konto_webadm';
$ldappass_nusz = 'H/Nbf4crpcnRWJ3yFG7%';

$ldapconn_nusz  = ldap_connect("ldaps://nusz.local") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_nusz , LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_nusz , LDAP_OPT_REFERRALS, 0);

if($ldapconn_nusz){
 $ldapbind = ldap_bind($ldapconn_nusz, $ldaprdn_nusz, $ldappass_nusz);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_nusz, $sdn_nusz, $filter);
 $entry = ldap_get_entries($ldapconn_nusz, $sr);
 ldap_close($ldapconn_nusz);
}else{
 echo "LDAP conn sikertelen nusz";
 exit;
}
return $entry;
}

function con_vszk(){
return false;
$entry="";
$sdn_vszk = 'OU=Domain Users,dc=vbszk,dc=local';
$sdn_vszk = 'dc=vbszk,dc=local';

$ldaprdn_vszk = '_konto_webadm';
$ldappass_vszk = 'BsaqxJ2QnQ6npM!PzUL!';

$ldapconn_vszk  = ldap_connect("ldaps://vbszk.local") or die("Not connect: $ldaphost ");
ldap_set_option($ldapconn_vszk , LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn_vszk , LDAP_OPT_REFERRALS, 0);

if($ldapconn_vszk){
 $ldapbind = ldap_bind($ldapconn_vszk, $ldaprdn_vszk, $ldappass_vszk);
 $filter="sAMAccountName=".$_POST['ad'];
 $sr = ldap_search($ldapconn_vszk, $sdn_vszk, $filter);
 $entry = ldap_get_entries($ldapconn_vszk, $sr);
 ldap_close($ldapconn_vszk);
}else{
 echo "LDAP conn sikertelen vszk";
 exit;
}
return $entry;
}

*/


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

function win_filetime_to_timestamp($timestamp) {
    return ceil(($timestamp/10000000) - 11644473600);
	//echo $timestamp."</br>";
	//echo (double)$timestamp/10000000;
    //return (($timestamp/10000000) - 11644473600);
}
?>
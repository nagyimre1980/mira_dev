<?php
//session_start();
session_start(['read_and_close' => true]);
include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
include_once("pdf_func.php");

login();
ini_set("pcre.jit", "0");
if(
(!isset($_POST['user']))
or
(
(isset($_POST['user']))and($_POST['user']=="")
)
){

 exit;
}elseif($_POST['user']=="akt"){
 $ev=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
 $ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
 
 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']==""){
  $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
  $GLOBALS['mira']['pdf_login_nev']=$GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 }else{//Helyettes
  $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
  $GLOBALS['mira']['pdf_login_nev']=$GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev'];
 }
 
}else{
 $user_ad=$_POST['user'];	
 $ev=$_POST['idoszak_ev'];	
 $ho=$_POST['idoszak_ho'];	
 $GLOBALS['mira']['pdf_login_nev']=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$user_ad,"user_nev");
 
}


//Jogosultság kezelés - eleje
if($_POST['mod_egyedi']=='xlsx_export_akt_user'){//Ha sima user
 if(
 (($user_ad!=$_SESSION[$GLOBALS['sessionname']]['login_ad'])and($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']==''))
  and
 (($user_ad!=$_SESSION[$GLOBALS['sessionname']]['login_ad'])and($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!=''))
 )
 {
	 echo 'Jogosultság hiba!';
	 exit;
 }
}elseif(
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user')
  and
 (!keres_jovahagyo_vanejogom_szerv($user_ad))
){//Jóváhagy
//Meg kell nézni, hogy van-e jóvéhagyási jogom erre a userre.
	 echo 'Jogosultság hiba!';
	 exit;
}elseif(
 ($_POST['mod_egyedi']=='xlsx_export_akt_user')
 and
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user')
 ){//Ilyen nem lehet
	 echo 'Általános jogosultság hiba!';
	 exit;
}
//Jogosultság kezelés - vége







$GLOBALS['mira']['pdf_ev']=$ev;
$GLOBALS['mira']['pdf_ho']=$ho;

include_once("pdf_tcpdf.php");

$tomb_mentve=keres_rogzit_egyho($user_ad,$ev,$ho);

if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;
$tomb_jovahagyva_ho=keres_mit2("rogzit_ho","user_ad",$user_ad,"rogzit_ho",$ev."-".$ho_ketto);

$naptimes=mktime("0","0","1",$ho,'1',$ev);
$ho_ut_nap=date('t',$naptimes);

if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva']=="0")
)
){
 $jovahagyva_ho=0;
}else{
 $jovahagyva_ho=1;
}

if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_ok']=="0")
)
){
 $ellenorzesre_ok_ho=0;
}else{
 $ellenorzesre_ok_ho=1;
}

$html='';

$html.='
<style>

.table_emre_bejovo td{
border: 1px solid #D3D8C5;
}

.table_emre_bejovo th{
background-color:#565656;
border: 1px solid #D3D8C5;
color:#ffffff;
text-align:center;
 font-size: 15px;
 font-weight: bold;
}

</style>';

if($jovahagyva_ho==0){
}else{
 $html.="<b>Lezárásra került</b>: ".$tomb_jovahagyva_ho[0]['ellenorzesre_lezarva_mikor']."</div>";
}

if($ellenorzesre_ok_ho=="1"){
 $html.="<b>Jóváhagyásra került</b>: ".$tomb_jovahagyva_ho[0]['ellenorzesre_lezarva_mikor']."";
 $html.="<br>";
}

$html.='<table cellpadding="4" cellspacing=1 border="1" id="table_emre_bejovo" class="table_emre_bejovo">';

$html.='<thead>';
/*
$html.='<tr class="table_cimsor">';

$html.='<th colspan="5" style="width:650px">';
$html.='Munkaidő ráfordítás: ';
$html.=$ev.". ".ho_ki($ho);
$html.='</th>';
$html.='</tr>';*/

$html.='<tr>';
$html.='<th colspan="2" style="width:130px">';
$html.='Dátum';
$html.='</th>';

$html.='<th style="width:360px">';
$html.='Tevékenység';
$html.='</th>';

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 $html.='<th style="width:70px">';
 $html.='Távollét';
 $html.='</th>';
}

$html.='<th style="width:90px">';
$html.='Összesítés';
$html.='</th>';

$html.='</tr>';

$html.='</thead>';

$html.='<tbody>';

$tomb_munkanap=keres_mit_munkanap($ev,$ho);
$tomb_munkanap_user=keres_mit_munkanap_user($ev,$ho,$user_ad);

$ora_globall=$perc_globall=0;

$ho_sor_munkanapszam=0;
for($nap_akt=1;$nap_akt<=$ho_ut_nap;$nap_akt++){
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi="";
 $html.=fo_pdf_honap_kirajzol_sor_ki($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$jovahagyva_ho);
}


$html.='<tr>';
$html.='<td>Összesen</td>';
$html.='<td></td>';
$html.='<td></td>';

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 $html.='<td></td>';//Távollét
}

$html.='<td style="text-align:center">';

$tomb_all_oraperc_globki=ora_perc_osszead($ora_globall,$perc_globall);
if($tomb_all_oraperc_globki['rogzit_perc']<10)$tomb_all_oraperc_globki_ert="0".$tomb_all_oraperc_globki['rogzit_perc'];
else $tomb_all_oraperc_globki_ert=$tomb_all_oraperc_globki['rogzit_perc'];
$html.=$tomb_all_oraperc_globki['rogzit_ora'].":".$tomb_all_oraperc_globki_ert;
$html.='</td>';

$html.='</tr>';


$html.='</tbody>';

$html.='</table>';

/*function encodeToIso($string) {
     return mb_convert_encoding($string, "ISO-8859-2", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}*/
$info = array(
    'Name' => 'Nemzeti Üzleti Szolgáltató Zrt.',
    'Location' => 'Paks',
    'Reason' => 'A digitális aláírás Nemzeti Üzleti Szolgáltató Zrt. termékével készült.',
    'ContactInfo' => 'http://www.mvm.hu',
    );
//$pdf->setSignature("services.cer","services.key",'Abc12345', '', 2, $info);
//$pdf->setSignature("konto.cer","konto.key",'Asdf1234', '', 2, $info);
//$pdf->setSignature('file://../../../files/keys/nusz.cer','file://../../../files/keys/konto.key','Hu4893', '', 2, $info);

//include("alairs.php");

if (tcpdf_v7()) {
    $html = html_tcpdf7_br($html);
	$html = html_tcpdf7_width($html);
}

$pdf->setHtmlVSpace(array(
    'ul'    => array(0=>array('h'=>0,'n'=>0), 1=>array('h'=>0,'n'=>0)),
    'p'     => array(0=>array('h'=>0,'n'=>0), 1=>array('h'=>0,'n'=>0)),
    'div'   => array(0=>array('h'=>0,'n'=>0), 1=>array('h'=>0,'n'=>0)),
    'table' => array(0=>array('h'=>0,'n'=>0), 1=>array('h'=>0,'n'=>0)),
));

$pdf->writeHTML($html, false, false, false, false, '',$autopadding=false);
//mb_internal_encoding("UTF-8");
//$filename="munkaido_".mb_strtolower($GLOBALS['mira']['pdf_login_nev'].".pdf");
//$filename=HuToEn("munkaido_".mb_strtolower(str_replace(" ","_",$GLOBALS['mira']['pdf_login_nev'])).".pdf");
$filename=HuToEn(mb_strtolower($GLOBALS['rend_nev'])."_".mb_strtolower(str_replace(" ","_",$GLOBALS['mira']['pdf_login_nev']))."_".$ev."_".$ho_ketto.".pdf");
//$filename=mb_strtolower($GLOBALS['rend_nev']."_".mb_strtolower(str_replace(" ","_",$GLOBALS['mira']['pdf_login_nev']))."_".$ev."_".$ho_ketto.".pdf");

//$filename=mb_convert_encoding("munkaido_".mb_strtolower(str_replace(" ","_",$GLOBALS['mira']['pdf_login_nev'])).".pdf", "UTF-8", "");
//$filename="Ékezet:íéáűőúöüó.pdf";
/*
echo '<pre>';
print_r(mb_list_encodings());
echo '</pre>';
exit;
*/
//$filename=mb_convert_encoding($filename, "ISO-8859-2", "UTF-8");
//$filename=mb_convert_encoding($filename, "Windows-1252", "UTF-8");
//$filename=mb_convert_encoding($filename, "ISO-8859-2", "UTF-8");
//$filename=iconv( "UTF-8", "Windows-1250", ($filename));
//$filename=iconv('UTF-8', 'ISO-8859-2', $filename);

//$filename=mb_convert_encoding("munkaido_".mb_strtolower(str_replace(" ","_",$GLOBALS['mira']['pdf_login_nev'])).".pdf", "iso-8859-2", "UTF-8");
//echo mb_detect_encoding($filename,null,false).'-----------'.$filename;exit;
//$mostani_code=mb_detect_encoding($filename);
//$filename="\xFE\xFF".iconv($mostani_code,"UTF-16BE",$filename);
$string=$pdf->Output($filename,'I');


function HuToEn($s)
{
 $hu=array('/é/','/É/','/á/','/Á/','/ó/','/Ó/','/ö/','/Ö/','/ő/','/Ő/','/ú/','/Ú/','/ű/','/Ű/','/ü/','/Ü/','/í/','/Í/','/ /');
 $en= array('e','E','a','A','o','O','o','O','o','O','u','U','u','U','u','U','i','I','_'); 
 $r=preg_replace($hu,$en,$s); 
 return $r;
} 
?>
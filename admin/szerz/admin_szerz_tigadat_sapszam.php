<?php

function admin_szerz_tigadat_sapszam(){
echo 'ok$;$';
admin_szerz_tigadatsapszam_kereses();
echo '<div id="admin_uj_tigadatsapszam_list_keres_tal" style="overflow-x:auto">';
admin_tigadatsapszam_user_list();
echo '</div>';
}

function admin_tigadatsapszamlist_keres(){
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']=$_POST['tagv_kod'];
if(isset($_POST['szerz_keret']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']=$_POST['szerz_keret'];
if(isset($_POST['szerztipusid']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']=$_POST['szerztipusid'];
if(isset($_POST['sapszam']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']=$_POST['sapszam'];
echo "ok$;$";
admin_tigadatsapszam_user_list();
}

function admin_szerz_tigadatsapszam_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']!="all"))
 $ker_tagv_kod=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod'];
else $ker_tagv_kod="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']!="all"))
 $ker_szerzkeret=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret'];
else $ker_szerzkeret="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']!="all"))
 $ker_szerztipusid=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid'];
else $ker_szerztipusid="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']!=""))
 $ker_sapszam=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam'];
else $ker_sapszam="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_tigadatsapszamlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Társaság';
echo '<td>';
echo '<select onchange="admin_tigadatsapszamlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatsapszamlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
if($ker_tagv_kod!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv_kod,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv_kod.'">'.$ker_tagv_kod.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>Keretszerződés';
echo '<td>';
echo '<select onchange="admin_tigadatsapszamlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatsapszamlist_keres_szerzkeret" class="select3" style="width:80px">';
 echo '<option value="all"';
 if($ker_szerzkeret=='all')echo ' selected';
 echo '>Összes';
 
 echo '<option value="0"';
 if($ker_szerzkeret=='0')echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ker_szerzkeret=='1')echo ' selected';
 echo '>Igen';
echo '</select>';

echo '<td>Szerződés típus';
echo '<td>';
echo '<select onchange="admin_tigadatsapszamlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatsapszamlist_keres_szerztipusid" class="select2_ajax" csonkolt=1 mod="admin_szerztipus_keres" style="width:311px">';
if($ker_szerztipusid!='all'){
 $ker_szerztipusid_nev=keres_mit1_mit1_csak_ertek('szerz_tipus','szerz_tipus_id',$ker_szerztipusid,'szerz_tipus_nev');
 echo '<option value="'.$ker_szerztipusid.'">'.$ker_szerztipusid_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>SAP szerződésszám';
echo '<td>';
echo '<input onkeyup="admin_tigadatsapszamlist_keres_proc(\'tallep_elso\',\'\')" value="'.$ker_sapszam.'" id="admin_tigadatsapszamlist_keres_sapszam" style="width:110px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tigadatsapszam_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatsapszam_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_tigadatsapszamlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_tigadatsapszamlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tigadatsapszamlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_keret";
echo "<th style='width:40px' class='link' onclick='admin_tigadatsapszamlist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatsapszamlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_date_hatalybelep";
echo "<th style='width:40px' class='link' onclick='admin_tigadatsapszamlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés hatályba lépésének időpontja ";
echo tabl_nyilak('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod',$order_mezo);

echo '<th>SAP szerződésszám';

echo '</tr></thead><tbody>';

admin_tigadatsapszam_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tigadatsapszam','admin_tigadatsapszamlist_keres_talszam','admin_tigadatsapszamlist_keres_proc');

}

function admin_tigadatsapszam_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
  
 echo '<td>';
 echo $ert['szerz_id'];
 
 $tilte='<b>'.$ert['tagv_kod_nev'].'</b>';
 $tilte.='<br><b>Szerződéses alapadat ID:</b> '.$ert['szerz_id'];
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte.='<br><b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>';
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].'</span>';
 
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);
 
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']);

 //SAP szerződés szám
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatsapszam_ment(\''.$ert['szerz_id'].'\')" id="admin_modtigadatsapszam_sapszam_'.$ert['szerz_id'].'" value="'.$ert['szerz_sapszam'].'" style="width:110px" maxlength="10" type="text">';

 echo '</tr>';
}
}
}
}

function admin_modtigadatsapszam_ment(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['sapszam']))and
 ($_POST['szerz_id']!='')and
 ($_POST['sapszam']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['szerz_sapszam']=$_POST['sapszam'];
 mod_egy_fel_tom('szerz',$tmp_mod[0],'szerz_id',$_POST['szerz_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>
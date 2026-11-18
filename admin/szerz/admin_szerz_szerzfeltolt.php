<?php

function admin_szerz_szerzfeltolt(){
echo 'ok$;$';
admin_szerz_szerzfeltolt_kereses();
echo '<div id="admin_uj_szerzfeltolt_list_keres_tal" style="overflow-x:auto">';
admin_szerzfeltolt_user_list();
echo '</div>';
}

function admin_szerzfeltoltlist_keres(){
if(isset($_POST['szerz_id']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']=$_POST['szerz_id'];
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']=$_POST['tagv_kod'];
if(isset($_POST['szerztipusid']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']=$_POST['szerztipusid'];
if(isset($_POST['szerzvane']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']=$_POST['szerzvane'];
if(isset($_POST['arvane']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']=$_POST['arvane'];
echo 'ok$;$';
admin_szerzfeltolt_user_list();
}

function admin_szerz_szerzfeltolt_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']!="all"))
 $ker_szerz_id=$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id'];
else $ker_szerz_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']!="all"))
 $ker_tagv_kod=$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod'];
else $ker_tagv_kod="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']!="all"))
 $ker_szerztipusid=$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid'];
else $ker_szerztipusid="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']!="all"))
 $ker_szerzvane=$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane'];
else $ker_szerzvane="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']!="all"))
 $ker_arvane=$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane'];
else $ker_arvane="all";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_szerzfeltoltlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';

echo '<td>ID';
echo '<td>';
echo '<input value="'.$ker_szerz_id.'" onkeyup="admin_szerzfeltoltlist_keres(\'tallep_elso\',\'\')" id="admin_szerzfeltoltlist_keres_szerzid" maxlength=3 style="width:50px" type="text">';

echo '<td>Társaság';
echo '<td>';
echo '<select onchange="admin_szerzfeltoltlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzfeltoltlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:271px">';
if($ker_tagv_kod!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv_kod,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv_kod.'">'.$ker_tagv_kod.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>Szerződés típus';
echo '<td>';
echo '<select onchange="admin_szerzfeltoltlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzfeltoltlist_keres_szerztipusid" class="select2_ajax" csonkolt=1 mod="admin_szerztipus_keres" style="width:231px">';
if($ker_szerztipusid!='all'){
 $ker_szerztipusid_nev=keres_mit1_mit1_csak_ertek('szerz_tipus','szerz_tipus_id',$ker_szerztipusid,'szerz_tipus_nev');
 echo '<option value="'.$ker_szerztipusid.'">'.$ker_szerztipusid_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>Szerződés';
echo '<td>';
echo '<select onchange="admin_szerzfeltoltlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzfeltoltlist_keres_szerzvane" class="select3" csonkolt=1 mod="admin_szerztipus_keres" style="width:136px">';

echo '<option value="all"';
if($ker_szerzvane=='all')echo ' selected';
echo '>Összes';

echo '<option value="1"';
if($ker_szerzvane=='1')echo ' selected';
echo '>Van feltöltött fájl';

echo '<option value="0"';
if($ker_szerzvane=='0')echo ' selected';
echo '>Nincs feltöltött fájl';

echo '</select>';

echo '<td>Árajánlat';
echo '<td>';
echo '<select onchange="admin_szerzfeltoltlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzfeltoltlist_keres_arvane" class="select3" csonkolt=1 mod="admin_szerztipus_keres" style="width:136px">';

echo '<option value="all"';
if($ker_arvane=='all')echo ' selected';
echo '>Összes';

echo '<option value="1"';
if($ker_arvane=='1')echo ' selected';
echo '>Van feltöltött fájl';

echo '<option value="0"';
if($ker_arvane=='0')echo ' selected';
echo '>Nincs feltöltött fájl';

echo '</select>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_szerzfeltolt_user_list(){

if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;
$tomb=keres_admin_szerzfeltolt_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_szerzalapadatlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_szerzfeltoltlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_szerzfeltoltlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szerz_tetel_modszam_kezi";
echo "<th title='Szerződés módosítás száma' style='width:40px' class='link' onclick='admin_szerzfeltoltlist_keres_proc(\"order\",\"".$order_mezo."\")'>Mód. szám ";
echo tabl_nyilak('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_szerzfeltoltlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_megj";
echo "<th style='width:40px' class='link' onclick='admin_szerzfeltoltlist_keres_proc(\"order\",\"".$order_mezo."\")'>Megjegyzés ";
echo tabl_nyilak('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod',$order_mezo);

echo '<th>Szerződés';
echo '<th>Árajánlat';

echo '</tr></thead><tbody>';

admin_szerzfeltolt_user_list_tal($tomb);

echo '</tbody></table>';

echo '<iframe id="szerzfeltoltes_upload_target" name="szerzfeltoltes_upload_target" style="display:none;width:0px;height:0px;border:0px;"></iframe>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szerzfeltolt','admin_szerzfeltoltlist_keres_talszam','admin_szerzfeltoltlist_keres_proc');

}

function admin_szerzfeltolt_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_id'];
 
 echo '<td>';
 echo $ert['tagv_kod'];

 echo '<td>';
 echo $ert['szerz_tetel_modszam_kezi'];
 
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>';
echo '<div class="div_szerz_fel_megj">';
 echo $ert['szerz_megj'];
 echo '</div>';
 
 //Szerződés feltöltése - eleje
 echo '<td>';
 if($ert['szerz_file_szerz_vane']=='1'){//Van file
	 echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'szerz\')" class="link">'.$ert['szerz_file_szerz_name'].'</span>';
	 echo ' <img title="Törlés" onclick="szerz_file_del(\''.$ert['szerz_file_id'].'\',\'szerz\',\''.str_replace("'","",$ert['szerz_file_szerz_name']).'\')" src="image\del.png" class="del_img">';
 }else{
  echo '<form style="display:block;margin:0px" id="file_upload_szerzfeltoltes_form_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" action="admin/szerz/admin_szerz_szerzfeltolt_upload.php" method="post" enctype="multipart/form-data" target="szerzfeltoltes_upload_target" onsubmit="return startUpload_szerzfeltoltes_file(\''.$ert['szerz_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\');">';
	echo '<input type=hidden name="szerzfeltoltes_tipus" value="szerz">';
	echo '<input type=hidden name="szerz_id" value="'.$ert['szerz_id'].'">'; 
	echo '<input type=hidden name="szerz_tetel_modszam_kezi" value="'.$ert['szerz_tetel_modszam_kezi'].'">'; 
  echo '<input onchange="szerzfeltoltes_form_file_input_change(\''.$ert['szerz_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\')" class="szerzfeltoltes_form_fileinput" id="szerzfeltoltes_form_file_input_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" type="file" name="datafile" accept="application/pdf">';//application/pdf, .pdfs1tyle="width:320px"
 
  echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="szerzfeltoltes_file_input_submit_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" type="submit">';
  echo '</form>';

  echo '<div style="display:none" class="upload_result_szerzfeltoltes_file_div" id="upload_result_szerzfeltoltes_file_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'">';
  echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
  echo '</div>';
 }
 //Szerződés feltöltése - vége
 
 //Árajánlat feltöltése - eleje
 echo '<td>';
 if($ert['szerz_file_ar_vane']=='1'){//Van file
	 echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'ar\')" class="link">'.$ert['szerz_file_ar_name'].'</span>';
	 echo ' <img onclick="szerz_file_del(\''.$ert['szerz_file_id'].'\',\'ar\',\''.str_replace("'","",$ert['szerz_file_ar_name']).'\')" src="image\del.png" class="del_img">';
 }else{
  echo '<form style="display:block;margin:0px" id="file_upload_szerzfeltoltes_ar_form_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" action="admin/szerz/admin_szerz_szerzfeltolt_upload.php" method="post" enctype="multipart/form-data" target="szerzfeltoltes_upload_target" onsubmit="return startUpload_szerzfeltoltes_ar_file(\''.$ert['szerz_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\');">';
	echo '<input type=hidden name="szerzfeltoltes_tipus" value="ar">'; 
	echo '<input type=hidden name="szerz_id" value="'.$ert['szerz_id'].'">';
	echo '<input type=hidden name="szerz_tetel_modszam_kezi" value="'.$ert['szerz_tetel_modszam_kezi'].'">';
  echo '<input onchange="szerzfeltoltes_ar_form_file_input_change(\''.$ert['szerz_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\')" class="szerzfeltoltes_ar_form_fileinput" id="szerzfeltoltes_ar_form_file_input_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" type="file" name="datafile" accept="application/pdf">';//s1tyle="width:320px"
 
  echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="szerzfeltoltes_ar_file_input_submit_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'" type="submit">';
  echo '</form>';

  echo '<div style="display:none" class="upload_result_szerzfeltoltes_ar_file_div" id="upload_result_szerzfeltoltes_ar_file_'.$ert['szerz_id'].'_'.$ert['szerz_tetel_modszam_kezi'].'">';
  echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
  echo '</div>';
 }
 //Árajánlat feltöltése - vége
 
 echo '</tr>';
}
}
}
}

function szerz_file_del_proc(){
if(
 (isset($_POST['szerz_file_id']))and
 (isset($_POST['tipus']))and
 ($_POST['szerz_file_id']!='')and
 ($_POST['tipus']!='')
){

if($_POST['tipus']=='szerz'){
 //Nézzük meg, hogy ar van-e, ha nincs, akkor törlés, amúgy módosítás kell!
 $ar_vane=keres_mit2_mit1_csak_ertek('szerz_file','szerz_file_id',$_POST['szerz_file_id'],'szerz_file_ar_vane','1','szerz_file_id');
 
 if($ar_vane!=''){//Mód
	$tmp_mod=array();
	$tmp_mod[0]['szerz_file_szerz_vane']='0';
	$tmp_mod[0]['szerz_file_szerz_name']=null;
	$tmp_mod[0]['szerz_file_szerz_kit']=null;
	$tmp_mod[0]['szerz_file_szerz_feltolt_ki']=null;
	$tmp_mod[0]['szerz_file_szerz_feltolt_mikor']=null;
	mod_egy_fel_tom('szerz_file',$tmp_mod[0],'szerz_file_id',$_POST['szerz_file_id']);
	unlink($GLOBALS['szerz_szerz'].$_POST['szerz_file_id'].'.pdf');
	echo 'ok$;$';
 }else{//Törlés
   torles('szerz_file','szerz_file_id',$_POST['szerz_file_id']);
   unlink($GLOBALS['szerz_szerz'].$_POST['szerz_file_id'].'.pdf');
   echo 'ok$;$';
 }
}elseif($_POST['tipus']=='ar'){
 //Nézzük meg, hogy szerz van-e, ha nincs, akkor törlés, amúgy módosítás kell!
 $szerz_vane=keres_mit2_mit1_csak_ertek('szerz_file','szerz_file_id',$_POST['szerz_file_id'],'szerz_file_szerz_vane','1','szerz_file_id');
 
 if($szerz_vane!=''){//Mód
	$tmp_mod=array();
	$tmp_mod[0]['szerz_file_ar_vane']='0';
	$tmp_mod[0]['szerz_file_ar_name']=null;
	$tmp_mod[0]['szerz_file_ar_kit']=null;
	$tmp_mod[0]['szerz_file_ar_feltolt_ki']=null;
	$tmp_mod[0]['szerz_file_ar_feltolt_mikor']=null;
	mod_egy_fel_tom('szerz_file',$tmp_mod[0],'szerz_file_id',$_POST['szerz_file_id']);
	unlink($GLOBALS['szerz_ar'].$_POST['szerz_file_id'].'.pdf');
	echo 'ok$;$';
 }else{//Törlés
   torles('szerz_file','szerz_file_id',$_POST['szerz_file_id']);
   unlink($GLOBALS['szerz_ar'].$_POST['szerz_file_id'].'.pdf');
   echo 'ok$;$';
 }
 
}

}
}
?>
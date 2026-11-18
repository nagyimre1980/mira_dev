<?php

function admin_szerz_tigadat_co(){
echo 'ok$;$';
admin_szerz_tigadatco_kereses();
echo '<div id="admin_uj_tigadatco_list_keres_tal" style="overflow-x:auto">';
admin_tigadatco_user_list();
echo '</div>';
}

function admin_tigadatcolist_keres(){
if(isset($_POST['mire1']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=$_POST['mire1'];
if(isset($_POST['mit1']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']=$_POST['mit1'];
if(isset($_POST['mit1_value']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1_value']=$_POST['mit1_value'];
if(isset($_POST['mire2']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=$_POST['mire2'];
if(isset($_POST['mit2']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']=$_POST['mit2'];
if(isset($_POST['mit2_value']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2_value']=$_POST['mit2_value'];
if(isset($_POST['mire3']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=$_POST['mire3'];
if(isset($_POST['mit3']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']=$_POST['mit3'];
if(isset($_POST['mit3_value']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3_value']=$_POST['mit3_value'];
if(isset($_POST['szerz_tetel_id']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']=$_POST['szerz_tetel_id'];
//if(isset($_POST['akt']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['akt']=$_POST['akt'];
if(isset($_POST['co']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']=$_POST['co'];
echo "ok$;$";
admin_tigadatco_user_list();
}

function admin_szerz_tigadatco_kereses(){

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']!=""))
 $ker_mire1=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1'];
else $ker_mire1="szerz";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']!=""))
 $ker_mit1=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1'];
else $ker_mit1="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1_value']!=""))
 $ker_mit1_value=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1_value'];
else $ker_mit1_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']!=""))
 $ker_mire2=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2'];
else $ker_mire2="tagv_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']!=""))
 $ker_mit2=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2'];
else $ker_mit2="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2_value']!=""))
 $ker_mit2_value=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2_value'];
else $ker_mit2_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']!=""))
 $ker_mire3=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3'];
else $ker_mire3="szolg_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']!=""))
 $ker_mit3=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3'];
else $ker_mit3="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3_value']!=""))
 $ker_mit3_value=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3_value'];
else $ker_mit3_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']!=""))
 $ker_szerz_tetel_id=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id'];
else $ker_szerz_tetel_id="";

/*
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['akt']!=""))
 $ker_akt=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['akt'];
else $ker_akt="";
*/

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']!=""))
 $ker_co=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co'];
else $ker_co="";

echo '<div class="div_kereshez"><b>Keresés</b>';//<br>
echo '<table id="admin_tigadatcolist_table" class="table_emre_kek">';

echo '<tr>';

echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_tigadatcolist_keres_mit1\',\'all\');admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mire1" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire1=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire1=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire1=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire1=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire1=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire1=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire1=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire1=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire1=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire1=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire1=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="penznem"';
if($ker_mire1=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';

echo '<td>';
echo '<select onchange="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mit1" class="select2_ajax" csonkolt=1 mit_id="admin_tigadatcolist_keres_mire1" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit1!=''and($ker_mit1!='all'))echo '<option value="'.$ker_mit1.'">'.$ker_mit1_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td>Szolgáltatás ID';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_id.'" onkeyup="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_szerztetelid" style="width:70px" type="text">';

echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_tigadatcolist_keres_mit2\',\'all\');admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mire2" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire2=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire2=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire2=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire2=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire2=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire2=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire2=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire2=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire2=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire2=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire2=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="penznem"';
if($ker_mire2=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';
echo '<td>';
echo '<select onchange="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mit2" class="select2_ajax" csonkolt=1 mit_id="admin_tigadatcolist_keres_mire2" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit2!=''and($ker_mit3!='all'))echo '<option value="'.$ker_mit2.'">'.$ker_mit2_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td colspan=2><label for="admin_szolgkapadatlist_keres_akt">Aktuális szerződések</label>';
/*if($ker_akt=='1') $akt_prop=' checked';
else $akt_prop='';
*/
echo '<input disabled id="admin_szolgkapadatlist_keres_akt" type="checkbox">';
/*
echo '<td>Aktiv';
echo '<td>';
echo '<select onchange="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_aktiv" class="select3" style="width:82px">';
echo '<option value="all">Összes';
echo '<option value="akt">Aktív';
echo '<option value="inakt">Inaktív';
echo '</select>';
*/
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_tigadatcolist_keres_mit3\',\'all\');admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mire3" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire3=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire3=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire3=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire3=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire3=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire3=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire3=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire3=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire3=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire3=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire3=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="penznem"';
if($ker_mire3=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';
echo '<td>';
echo '<select onchange="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatcolist_keres_mit3" class="select2_ajax" csonkolt=1 mit_id="admin_tigadatcolist_keres_mire3" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit3!=''and($ker_mit3!='all'))echo '<option value="'.$ker_mit3.'">'.$ker_mit3_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td>CO';
echo '<td>';
echo '<input value="'.$ker_co.'" onkeyup="admin_tigadatcolist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_co" style="width:70px" maxlength=14 type="text">';


echo '</tr>';
echo '</table></div>';
}

function admin_tigadatco_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatco_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Szerződések</b>';//<br>
echo '<table id="admin_szolgkapadatlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_tetel.szerz_tetel_id";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás<br>ID ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_keret";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_date_hatalybelep";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés hatályba<br>lépésének időpontja ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szerz_tetel_modszam";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Hatályos<br>szerződésmódosítás száma ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.szerz_csop_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás csoport ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_tigadatcolist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod',$order_mezo);

echo "<th>CO objektum";
echo '</tr></thead><tbody>';

admin_tigadatco_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tigadatco','admin_tigadatcolist_keres_talszam','admin_tigadatcolist_keres_proc');
}

function admin_tigadatco_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_tetel_id'];
 echo ' <img onclick="admin_szolgkapadat_reszlet(\''.$ert['szerz_tetel_id'].'\',\''.$ert['szerz_tetel_adat_id'].'\')" title="Részletezés" class="linkimg_tooltip img_resz" src="image/details_18_1.png">';

 $tilte='<b>'.$ert['tagv_kod_nev'].'</b>';
 $tilte.='<br><b>Szerződéses alapadat ID:</b> '.$ert['szerz_id'];
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte.='<br><b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>';
 //echo $ert['tagv_kod'];
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].'</span>';
 
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);
 
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']);
 
 echo '<td>';
 $statusz_str=szerz_statusz($ert['szerz_tetel_modszam'],$ert['szerz_tetel_szolg_kezd_date_folyamatban'],$ert['szerz_tetel_akt'],$ert['szerz_tetel_akt_folyamatban']);
 echo $statusz_str;

 echo '<td>';
 echo $ert['szerz_csop_nev'];
 
 echo '<td>';
 echo $ert['szolg_kod'];
 
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatco_ment(\''.$ert['szerz_tetel_id'].'\')" id="admin_modtigadatco_sapszam_'.$ert['szerz_tetel_id'].'" value="'.$ert['szerz_tetel_co'].'" style="width:140px" maxlength="14" type="text">';
 
 echo '</tr>';
}
}
}
}

function admin_modtigadatco_ment(){
if(
 (isset($_POST['szerz_tetel_id']))and
 (isset($_POST['co']))and
 ($_POST['szerz_tetel_id']!='')and
 ($_POST['co']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['szerz_tetel_co']=$_POST['co'];
 mod_egy_fel_tom('szerz_tetel',$tmp_mod[0],'szerz_tetel_id',$_POST['szerz_tetel_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>
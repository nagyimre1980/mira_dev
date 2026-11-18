<?php

function admin_tenypotlastig_mod(){
echo 'ok$;$';
admin_szerz_tenypotlastig_urlap();
admin_szerz_tenypotlastig_kereses();
echo "<div id='admin_uj_tenypotlastig_list_keres_tal' style='overflow-x:auto'>";
admin_tenypotlastig_user_list();
echo "</div>";
}

function admin_szerz_tenypotlastig_urlap(){
echo '<div class="div_kereshez" style="display:flex">';//;background-color:yellow

echo '<div style="flex:1">';//;background-color:red
admin_szerz_tenypotlastig_urlap_oszlop1();
echo '</div>';

echo '<div style="flex:1">';//;background-color:geeen
echo admin_szerz_tenypotlastig_urlap_oszlop2();
echo '</div>';

echo '<div style="flex:1">';//;background-color:blue
echo admin_szerz_tenypotlastig_urlap_oszlop3();
echo '</div>';

echo '</div>';
}

function admin_szerz_tenypotlastig_urlap_oszlop1(){
echo '<b>Új szerződés ID felvétele:</b>';

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Szolgáltatás ID';
echo '<td>';
echo '<input id="admin_ujtenypotlastig_id" type="text" style="width:60px" maxlength="6">';

echo '<td>Év';
echo '<td>';
echo '<select id="admin_ujtenypotlastig_ev" class="select3" style="width:60px">';
$ev_most=date('Y',time());
for($i='2026';$i<=$ev_most;$i++){
 echo '<option value="'.$i.'"';
 if($i==$ev_most) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

echo '<td>Hónap';
echo '<td>';
$ho_most=date('n',time());
echo '<select id="admin_ujtenypotlastig_ho" class="select3" style="width:45px">';
for($ho=1;$ho<=12;$ho++){
 echo '<option value="'.$ho.'"';
 if($ho==$ho_most) echo ' selected';
 echo '>'.$ho;
}
echo '</select>';
echo '</tr>';

echo "<tr><td colspan=6 align=left><input id='admin_ujtenypotlastig_submit' onclick='admin_ujtenypotlastig()' type=submit value='Új szolgáltatás ID felvitele' class='submit2'></tr>";

echo '</table>';
}

function admin_szerz_tenypotlastig_urlap_oszlop2(){
echo '<b>Excel adat betöltés (meglévő ID-hoz):</b>';

//Betöltés - eleje
 echo '<form style="display:block;margin:0px" id="file_upload_tenypotlastig_form" action="admin/ajax_ful_admin_tenypotlas_tig_betoltes.php" method="post" enctype="multipart/form-data" target="tenypotlastig_upload_target" onsubmit="return startUpload_tenypotlastig_file();">';

 echo '<input onchange="tenypotlastig_form_file_input_change()" class="tenypotlastig_form_fileinput" id="tenypotlastig_form_file_input" type="file" name="datafile" s1tyle="width:320px" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">';
 
 echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="tenypotlastig_file_input_submit" type="submit">';
 echo '</form>';

 echo '<div style="display:none" class="upload_result_tenypotlastig_file_div" id="upload_result_tenypotlastig_file">';
 echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
 echo '</div>';
 
 echo '<iframe id="tenypotlastig_upload_target" name="tenypotlastig_upload_target" style="display:none;width:0px; height:0px; border:0px;"></iframe>';
 echo '<div onclick="admin_tenypotlastig_tenybetoltomintaopen()" class="link" style="margin-top:5px">Ténybetöltő TIG táblához minta</div>';
//Betöltés - vége
}

function admin_szerz_tenypotlastig_urlap_oszlop3(){
echo '<input onclick="admin_szerz_tenypotlastig_generalas()"  id="admin_ujtenypotlastig3_submit" value="Szolgáltatás ID generálás" class="submit2" style="width:108px;margin-right:5px">';
echo 'Év: ';
echo '<select id="admin_ujtigadatnemszerz_ev" class="select3" style="width:60px">';
$ev_most=date('Y',time());
for($i='2026';$i<=$ev_most;$i++){
 echo '<option value="'.$i.'"';
 if($i==$ev_most) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

echo ' Hónap: ';
$ho_most=date('n',time());
echo '<select id="admin_ujtigadatnemszerz_ho" class="select3" style="width:45px">';
for($ho=1;$ho<=12;$ho++){
 echo '<option value="'.$ho.'"';
 if($ho==$ho_most) echo ' selected';
 echo '>'.$ho;
}
echo '</select>';

echo ' nap: ';
$nap_most=date('j',time());
echo '<select  id="admin_ujtigadatnemszerz_nap" class="select3" style="width:45px">';
for($nap=1;$nap<=31;$nap++){
 echo '<option value="'.$nap.'"';
 if($nap==$nap_most) echo ' selected';
 echo '>'.$nap;
}
echo '</select>';
echo '<br><b>MIRA órás</b> (ID:6) naturália típusokat ne generálja le<input checked id="admin_ujtigadatnemszerz_miraorakelle" type=checkbox>';
echo '<br>Generálás az adott hónap összes értékét teljesen kitörli!';
}

function admin_tenypotlastiglist_keres(){
if(isset($_POST['id']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']=$_POST['id'];
if(isset($_POST['ev']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']=$_POST['ev'];
if(isset($_POST['ho']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']=$_POST['ho'];
echo "ok$;$";
admin_tenypotlastig_user_list();
}

function admin_szerz_tenypotlastig_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']!=""))
 $ker_id=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id'];
else $ker_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']!=""))
 $ker_ev=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev'];
else $ker_ev='all';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']!=""))
 $ker_ho=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho'];
else $ker_ho="all";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_szervlist_table" class="table_emre">';
echo '<tbody>';
echo '<tr>';

echo '<td>Szolgáltatás ID';
echo '<td><input onkeyup="admin_tenypotlastiglist_keres(\'\',\'\')" id="admin_tenypotlastiglist_keres_id" value="'.$ker_id.'" style="width:60px" maxlength="6" type=text>';

echo '<td>Év';
echo '<td>';
echo '<select onchange="admin_tenypotlastiglist_keres(\'\',\'\')" id="admin_tenypotlastiglist_keres_ev" class="select3" style="width:70px">';
$ev_most=date('Y',time());
echo '<option value="all">Összes';
for($i='2026';$i<=$ev_most;$i++){
 echo '<option value="'.$i.'"';
 if($i==$ker_ev) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

echo '<td>Hó';
echo '<td>';
//$ho_most=date('n',time());
if($ker_ev=='all')$dis=' disabled';
else $dis='';
echo '<select'.$dis.' onchange="admin_tenypotlastiglist_keres(\'\',\'\')" id="admin_tenypotlastiglist_keres_ho" class="select3" style="width:70px">';
echo '<option value="all">Összes';
for($ho=1;$ho<=12;$ho++){
 echo '<option value="'.$ho.'"';
 if($ho==$ker_ho) echo ' selected';
 echo '>'.$ho;
}

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tenypotlastig_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tenypotlastig_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_tenypotlastiglist_table" class="table_emre">';
echo '<thead><tr>';

$order_mezo="szerz_tenybe_egyebnat.szerz_tetel_id";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás ID ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tenybe_egyebnat.tenybe_egyebnat_evho";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Év-hó ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

echo '<th>Egyéb naturália';

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.szerz_csop_nev";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás csoport ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szerz_elsz_tipus_id";
echo "<th style='width:40px' class='link' onclick='admin_tenypotlastigist_keres_proc(\"order\",\"".$order_mezo."\")'>Elszámolás típusa ";
echo tabl_nyilak('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_tenypotlastig_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tenypotlastig','admin_tenypotlastiglist_keres_talszam','admin_tenypotlastiglist_keres_proc');

}

function admin_tenypotlastig_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 $egyedi_id=$ert['szerz_tetel_id'].str_replace('.','',$ert['evho']);
 echo '<tr id="tr_tenypotlastig_'.$egyedi_id.'">';

 echo '<td>';
 echo '<img onclick="admin_modtenypotlastig_del(\''.$egyedi_id.'\',\''.$ert['szerz_tetel_id'].'\',\''.$ert['evho_orig'].'\')" src="image/del.png" title="Törlés" class="linkimg_tooltip" style="margin-right:5px">';
 echo $ert['szerz_tetel_id'];
 echo ' <img onclick="admin_szolgkapadat_reszlet(\''.$ert['szerz_tetel_id'].'\',\''.$ert['szerz_tetel_adat_id'].'\')" title="Részletezés" class="linkimg_tooltip img_resz" src="image/details_18_1.png">';

 //Év-hó
 echo '<td>';
 echo $ert['evho'];
 
 //Egyéb naturália
 echo '<td>';
 echo '<input onkeyup="admin_modtenypotlastig_ment(\''.$egyedi_id.'\',\''.$ert['szerz_tetel_id'].'\',\''.$ert['evho_orig'].'\')" id="admin_modtenypotlastig_egyebnat_'.$egyedi_id.'" value="'.$ert['egyebnat'].'" maxlength="30" type=text style="width:130px">';

 //Társaság
 echo '<td>';
 echo $ert['tagv_kod'];
 
 //Szolgáltatás csoport
 echo '<td>';
 echo $ert['szerz_csop_nev'];
 
 //Szolgáltatás kód
 echo '<td>';
 echo $ert['szolg_kod'];
 
 //Elszámolás típusa 
 echo '<td>';
 echo $ert['szerz_elsz_tipus_nev'];
 
 echo '</tr>';
}
}
}
}

function admin_ujtenypotlastig_ment(){
if((!isset($_POST['id']))or(
(isset($_POST['id'])and($_POST['id']==""))
)){
 echo "nook$;$"."Szolgáltatás ID kitöltése kötelező!";
 exit;
}

if((!isset($_POST['ev']))or(
(isset($_POST['ev'])and($_POST['ev']==""))
)){
 echo "nook$;$"."Év kitöltése kötelező!";
 exit;
}

if((!isset($_POST['ho']))or(
(isset($_POST['ho'])and($_POST['ho']==""))
)){
 echo "nook$;$"."Hó kitöltése kötelező!";
 exit;
}
if($_POST['ho']<10)$_POST['ho']='0'.$_POST['ho'];
$vane=keres_mit2_mit1('szerz_tenybe_egyebnat','szerz_tetel_id',$_POST['id'],'tenybe_egyebnat_evho',$_POST['ev'].'-'.$_POST['ho'].'-01','szerz_tetel_id');
if(is_array($vane)){
	echo "Hiba! Van már ilyen Szolgáltatás ID!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szerz_tetel_id']=$_POST['id'];
 $tmp_bk[0]['tenybe_egyebnat_evho']=$_POST['ev'].'-'.$_POST['ho'].'-01';
 be_visz_insert("szerz_tenybe_egyebnat",$tmp_bk);
 echo 'ok$;$';
}
}

function admin_modtenypotlastig_ment(){
if(
(isset($_POST['szerz_tetel_id']))and
(isset($_POST['evho_orig']))and
(isset($_POST['egyebnat']))and
($_POST['szerz_tetel_id']!="")and
($_POST['evho_orig']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['egyebnat']=$_POST['egyebnat'];
 mod_egy_fel_tom2('szerz_tenybe_egyebnat',$tmp_mod[0],'szerz_tetel_id',$_POST['szerz_tetel_id'],'tenybe_egyebnat_evho',$_POST['evho_orig']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modtenypotlastig_del(){
if(
(isset($_POST['szerz_tetel_id']))and($_POST['szerz_tetel_id']!='')and
(isset($_POST['evho']))and($_POST['evho']!='')
){
 torles2('szerz_tenybe_egyebnat','szerz_tetel_id',$_POST['szerz_tetel_id'],'tenybe_egyebnat_evho',$_POST['evho']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>
<?php

function admin_kpi_tipus(){
echo 'ok$;$';
admin_kpi_tipus_urlap();
admin_kpi_tipus_mod_kereses();
echo '<div id="admin_uj_kpitipus_list_keres_tal" style="overflow-x:auto">';
admin_kpi_tipus_mod_list();
echo '</div>';
}

function admin_kpi_tipus_urlap(){
echo '<div class="div_kereshez">';

echo '<b>Új KPI tipus:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>KPI szolgáltatás kód';
echo '<td>';
echo '<select onchange="admin_ujkpitipus_szolgkog_change()" class="select2_ajax" csonkolt="1" mod="admin_kpi_szolg_kod" id="admin_ujkpitipus_szolgkod" style="width:150px">';
 echo '<option value="keremv" selected>Kérem válassz';
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>KPI sorszám';
echo '<td>';
echo '<select onchange="admin_ujkpitipus_sorszam_change()" class="select2_ajax" mit_id="admin_ujkpitipus_szolgkod" mod="admin_kpi_sorszam" csonkolt="0" id="admin_ujkpitipus_sorszam" style="width:150px">';
echo '<option value="keremv" selected>Kérem válassz';
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>KPI';
echo '<td><span id="admin_ujkpitipus_kpispan"></span>';
echo '</tr>';

echo '<tr>';
echo '<td>KPI típus';
echo '<td>';
echo '<select id="admin_ujkpitipus_tipus" class="select3" style="width:150px">';
echo '<option value="keremv">Kérem válassz';
echo '<option value="1">1';
echo '<option value="2">2';
echo '</select>';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujkpitipus_submit" onclick="admin_ujkpitipus()" value="Új KPI típus felvitele" class="submit2" type=submit></tr>';

echo '</tbody>';
echo '</table>';

echo '</div>';
}

function admin_kpitipuslist_keres(){
if(isset($_POST['kpi_szolg_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']=$_POST['kpi_szolg_kod'];
echo "ok$;$";
admin_kpi_tipus_mod_list();
}

function admin_kpi_tipus_mod_kereses(){

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']!=""))
 $ker_kpi_szolg_kod=$_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod'];
else $ker_kpi_szolg_kod="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo "<table id='admin_kpitipuslist_keres_table' class='table_emre_kek'>";
echo '<tbody>';
echo '<tr>';
echo '<td>KPI szolgáltatás kód';
echo '<td>';
echo '<input value="'.$ker_kpi_szolg_kod.'" onkeyup="admin_kpitipuslist_keres_proc(\'tallep_elso\',\'\')" id="admin_kpitipuslist_keres_kpiszolgkod" maxlength="8" style="width:100px" type="text">';
echo '</tr>';
echo '</tbody>';

echo '</table></div>';
}

function admin_kpi_tipus_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpitipus_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_kpiszolgkodlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="kpi_tipus.kpi_tipus_id";
echo "<th style='width:40px' class='link' onclick='admin_kpitipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_kpitipuslist_keres_order','admin_kpitipuslist_keres_order_mod',$order_mezo);

/*
$order_mezo="kpi_tipus.kpi_szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_kpitipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>KPI szolgáltatás kód ";
echo tabl_nyilak('admin_kpitipuslist_keres_order','admin_kpitipuslist_keres_order_mod',$order_mezo);
*/

//echo "<th>KPI ";
$order_mezo="kpi_tipus.kpi_tipus_kpi";
echo "<th style='width:40px' class='link' onclick='admin_kpitipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>KPI ";
echo tabl_nyilak('admin_kpitipuslist_keres_order','admin_kpitipuslist_keres_order_mod',$order_mezo);

$order_mezo="kpi_tipus.kpi_tipus_tipus";
echo "<th style='width:40px' class='link' onclick='admin_kpitipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>KPI típus ";
echo tabl_nyilak('admin_kpitipuslist_keres_order','admin_kpitipuslist_keres_order_mod',$order_mezo);

echo "<th>Mutatószám megnevezése";
echo "<th>Mutatószám számítás módja";
echo "<th title='Célérték kategória 1'>Célérték kat. 1";
echo "<th title='Célérték kategória 2'>Célérték kat. 2";
echo "<th title='Célérték kategória 3'>Célérték kat. 3";
echo "<th title='Célérték kategória 4'>Célérték kat. 4";
echo "<th>Szakció mértéke";
echo "<th>Törlés";

echo '</tr></thead><tbody>';

admin_uj_kpi_tipus_list_tal($tomb);
echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_kpitipus','admin_kpitipuslist_keres_talszam','admin_kpitipuslist_keres_proc');
}

function admin_uj_kpi_tipus_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['kpi_tipus_id'];
 
 //echo '<td>';
 //echo $ert['kpi_szolg_kod'];

 echo '<td>';
 //s$kpi=kpi_sorszam_ki($ert['kpi_szolg_kod'],$ert['kpi_tipus_sorszam']);
 echo $ert['kpi_tipus_kpi'];
 
 //KPI típus
 echo '<td>';
 echo '<select id="admin_modkpitipus_tipus_'.$ert['kpi_tipus_id'].'" class="select3" style="width:110px">';
 echo '<option value="keremv">Kérem válassz';
 echo '<option value="1"';
 if($ert['kpi_tipus_tipus']=='1')echo' selected';
 echo '>1';
 
 echo '<option value="2"';
 if($ert['kpi_tipus_tipus']=='2')echo' selected';
 echo '>2';
 echo '</select>';

 //Mutatószám megnevezése
 echo '<td>';
 echo '<textarea onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" rows="2" id="admin_modkpitipus_mutmegn_'.$ert['kpi_tipus_id'].'" style="width:230px">';
 echo $ert['kpi_tipus_mutmegn'];
 echo '</textarea>';
 
 //Mutatószám számítás módja
 echo '<td>';
 echo '<textarea onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" rows="2" id="admin_modkpitipus_mutszmod_'.$ert['kpi_tipus_id'].'" style="width:230px">';
 echo $ert['kpi_tipus_mutszmod'];
 echo '</textarea>';
 
 //Célérték kategória 1
 echo '<td>';
 if($ert['kpi_tipus_ck_1']!='')$ki_ck1=str_replace(".",",",$ert['kpi_tipus_ck_1']);
 else $ki_ck1=0;
 echo '<input value="'.$ki_ck1.'" onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" id="admin_modkpitipus_ck1_'.$ert['kpi_tipus_id'].'" class="number_penz_2tizedes" style="width:80px" maxlength="6" type="text">';
 
 //Célérték kategória 2
 echo '<td>';
 if($ert['kpi_tipus_ck_2']!='')$ki_ck2=str_replace(".",",",$ert['kpi_tipus_ck_2']);
 else $ki_ck2=0;
 echo '<input value="'.$ki_ck2.'" onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" id="admin_modkpitipus_ck2_'.$ert['kpi_tipus_id'].'" class="number_penz_2tizedes" style="width:80px" maxlength="6" type="text">';
  
 //Célérték kategória 3
 echo '<td>';
 if($ert['kpi_tipus_ck_3']!='')$ki_ck3=str_replace(".",",",$ert['kpi_tipus_ck_3']);
 else $ki_ck3=0;
 echo '<input value="'.$ki_ck3.'" onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" id="admin_modkpitipus_ck3_'.$ert['kpi_tipus_id'].'" class="number_penz_2tizedes" style="width:80px" maxlength="6" type="text">';
   
 //Célérték kategória 4
 echo '<td>';
 if($ert['kpi_tipus_ck_4']!='')$ki_ck4=str_replace(".",",",$ert['kpi_tipus_ck_4']);
 else $ki_ck4=0;
 echo '<input value="'.$ki_ck4.'" onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" id="admin_modkpitipus_ck4_'.$ert['kpi_tipus_id'].'" class="number_penz_2tizedes" style="width:80px" maxlength="6" type="text">';
 
 //Szakció mértéke
 echo '<td>';
 if($ert['kpi_tipus_szm']!='')$ki_szm=str_replace(".",",",$ert['kpi_tipus_szm']);
 else $ki_szm=0;
 echo '<input value="'.$ki_szm.'" onkeyup="admin_modkpitipus_ment(\''.$ert['kpi_tipus_id'].'\')" id="admin_modkpitipus_szm4_'.$ert['kpi_tipus_id'].'" class="number_penz_2tizedes" style="width:80px" maxlength="6" type="text">';
 
 //Törlés
 echo '<td align=center>';
 echo '<img onclick="admin_modkpitipus_del(\''.$ert['kpi_tipus_id'].'\',\''.$ert['kpi_tipus_kpi'].'\')" src="image/del.png" style="width:16px" title="Törlés" class="linkm_tooltip">';
 
 echo '</tr>';
}
}
}
}

function kpi_sorszam_ki($kpi_szolg_kod,$sorszam){
if($sorszam<10){
 $ki_sorszam='0'.$sorszam;
}else{
 $ki_sorszam=$sorszam;
}
$ret=$kpi_szolg_kod.'_KPI'.$ki_sorszam;
return $ret;
}

function admin_ujkpitipus_ment(){

if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and
($_POST['szolgkod']==""))
)){
 echo "nook$;$"."KPI szolgáltatás kód megadása kötelező!";
 exit;
}

if((!isset($_POST['sorszam']))or(
(isset($_POST['sorszam'])and
($_POST['sorszam']==""))
)){
 echo "nook$;$"."Sorszám megadása kötelező!";
 exit;
}

if((!isset($_POST['tipus']))or(
(isset($_POST['tipus'])and
($_POST['tipus']==""))
)){
 echo "nook$;$"."Típus megadása kötelező!";
 exit;
}

//2: Van-e ilyen KPI szolgáltatás kód
$kpi_tipus_id=keres_mit2_mit1('kpi_tipus','kpi_szolg_kod',$_POST['szolgkod'],'kpi_tipus_sorszam',$_POST['sorszam'],'kpi_tipus_id');
if(is_array($kpi_tipus_id)){
 echo 'nook$;$Hiba! Van már ilyen KPI!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['kpi_szolg_kod']=$_POST['szolgkod'];
 $tmp_bk[0]['kpi_tipus_sorszam']=$_POST['sorszam'];
 
 $tmp_bk[0]['kpi_tipus_kpi']=kpi_sorszam_ki($_POST['szolgkod'],$_POST['sorszam']);
 
 $tmp_bk[0]['kpi_tipus_tipus']=$_POST['tipus'];
 be_visz_insert('kpi_tipus',$tmp_bk);
 echo "ok$;$";
}
}

function admin_modkpitipus_ment(){
if(
(isset($_POST['kpi_tipus_id']))and
(isset($_POST['tipus']))and
(isset($_POST['mutmegn']))and
(isset($_POST['mutszmod']))and
(isset($_POST['ck1']))and
(isset($_POST['ck2']))and
(isset($_POST['ck3']))and
(isset($_POST['ck4']))and
(isset($_POST['szm4']))and
($_POST['kpi_tipus_id']!="")
){

 $tmp_mod=array();
 
 if($_POST['tipus']!='')
  $tmp_mod[0]['kpi_tipus_tipus']=$_POST['tipus'];
 else $tmp_mod[0]['kpi_tipus_tipus']=null;
 
 if($_POST['mutmegn']!='')
  $tmp_mod[0]['kpi_tipus_mutmegn']=$_POST['mutmegn'];
 else $tmp_mod[0]['kpi_tipus_mutmegn']=null;
 
 if($_POST['mutszmod']!='')
  $tmp_mod[0]['kpi_tipus_mutszmod']=$_POST['mutszmod'];
 else $tmp_mod[0]['kpi_tipus_mutszmod']=null; 
 
 if($_POST['ck1']!='')
  $tmp_mod[0]['kpi_tipus_ck_1']=$_POST['ck1'];
 else $tmp_mod[0]['kpi_tipus_ck_1']=null; 
 
 if($_POST['ck2']!='')
  $tmp_mod[0]['kpi_tipus_ck_2']=$_POST['ck2'];
 else $tmp_mod[0]['kpi_tipus_ck_2']=null; 
 
 if($_POST['ck3']!='')
  $tmp_mod[0]['kpi_tipus_ck_3']=$_POST['ck3'];
 else $tmp_mod[0]['kpi_tipus_ck_3']=null; 
 
 if($_POST['ck4']!='')
  $tmp_mod[0]['kpi_tipus_ck_4']=$_POST['ck4'];
 else $tmp_mod[0]['kpi_tipus_ck_4']=null;
   
 if($_POST['szm4']!='')
  $tmp_mod[0]['kpi_tipus_szm']=$_POST['szm4'];
 else $tmp_mod[0]['kpi_tipus_szm']=null;

 mod_egy_fel_tom('kpi_tipus',$tmp_mod[0],'kpi_tipus_id',$_POST['kpi_tipus_id']);
 echo 'ok$;$'; 
}else{
 echo 'adathiány';
}
}

function admin_modkpitipus_del_proc(){
if((isset($_POST['kpi_tipus_id']))and($_POST['kpi_tipus_id']!='')){

torles('kpi_tipus','kpi_tipus_id',$_POST['kpi_tipus_id']);
echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>
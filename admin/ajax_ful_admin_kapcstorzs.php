<?php
//Kapcsolattartó törzsadatok

function admin_kapcstorzs_mod(){
echo "ok$;$";
unset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']);
admin_kapcstorzs_mod_urlap();
admin_kapcstorzs_mod_kereses();
echo "<div id='admin_uj_kapcstorzs_list_keres_tal' style='overflow-x:auto'>";
admin_kapcstorzs_mod_list();
echo "</div>";
}

function admin_kapcstorzs_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új kapcsolattartó törzsadatok:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Név *';
echo '<td>';
echo '<input id="admin_ujkapcstorzs_nev" type=text style="width:400px" maxlength="255">';
echo '</tr>';

echo '<tr>';
echo '<td>Társaság *';
echo '<td>';
 echo '<select id="admin_ujkapcstorzs_tagvkod" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Beosztás *';
echo '<td>';
echo '<input id="admin_ujkapcstorzs_beosztas" type=text style="width:400px" maxlength="255">';
echo '</tr>';

echo '<tr>';
echo '<td>Telefonszám';
echo '<td>';
echo '<input id="admin_ujkapcstorzs_tel" type=text style="width:200px" maxlength="50">';
echo '</tr>';

echo '<tr>';
echo '<td>Email';
echo '<td>';
echo '<input id="admin_ujkapcstorzs_email" type=text style="width:400px" maxlength="100">';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujkapcstorzs_submit' onclick='admin_ujkapcstorzs()' type=submit value='Új kapcsolattartó törzsadatok felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_kapcstorzslist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']=$_POST['nev'];
if(isset($_POST['tagv']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']=$_POST['tagv'];
if(isset($_POST['beosztas']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']=$_POST['beosztas'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_kapcstorzs_mod_list();
}

function admin_kapcstorzs_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']!=""))
 $ker_tagv=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv'];
else $ker_tagv="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']!=""))
 $ker_beosztas=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas'];
else $ker_beosztas="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_kapcstorzslist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>Név";
echo "<td><input style='width:200px' maxlength='255' onkeyup='admin_kapcstorzslist_keres(\"tallep_elso\",\"\")' id='admin_kapcstorzslist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Társaság";
 echo '<td><select onchange="admin_kapcstorzslist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcstorzslist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:211px">';
 echo '<option value="all">Összes';
 echo '</select>';

echo "<td>Beosztás";
echo "<td><input style='width:200px' maxlength='255' onkeyup='admin_kapcstorzslist_keres(\"tallep_elso\",\"\")' id='admin_kapcstorzslist_keres_beosztas' value='".$ker_beosztas."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_kapcstorzslist_keres_proc(\"tallep_elso\",\"\")' id='admin_kapcstorzslist_keres_inaktiv' style='width:150px'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo "</select>";

echo "</tr>";
echo '</table></div>';
}

function admin_kapcstorzs_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcstorzs_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";
echo "<table id='admin_kapcstorzslist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="kapcs_torzs.kapcs_torzs_id";
echo "<th style='width:20px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs.kapcs_torzs_nev";
echo "<th style='width:200px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>Név ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs.tagv_kod";
echo "<th style='width:200px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs.kapcs_torzs_beosztas";
echo "<th style='width:200px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>Beosztás ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs.kapcs_torzs_tel";
echo "<th style='width:200px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>Telefonszám ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs.kapcs_torzs_email";
echo "<th style='width:200px' class='link' onclick='admin_kapcstorzslist_keres_proc(\"order\",\"".$order_mezo."\")'>Email ";
echo tabl_nyilak('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_kapcstorzs_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_kapcstorzslist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam'],"admin_kapcstorzslist_keres_proc","admin_kapcstorzslist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_kapcstorzslist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_kapcstorzslist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_kapcstorzslist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_kapcstorzslist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_kapcstorzslist_keres",$th);
}

}

function admin_kapcstorzs_list_tal($tomb){

$tomb_tagvkod_nev=keres_tagvkod_nev_tomb();

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr title="'.$ert['kapcs_torzs_nev'].'" class="ttooltip">';

//ID
echo '<td>';
echo $ert['kapcs_torzs_id'];
 
//Név
echo '<td>';
if($ert['kapcs_torzs_inaktiv']==0)
 echo "<input type='text' style='width:300px' maxlength='100' onkeyup='admin_modkapcstorzs_ment(\"".$ert['kapcs_torzs_id']."\")' id='admin_modkapcstorzs_nev_".$ert['kapcs_torzs_id']."' value='".$ert['kapcs_torzs_nev']."'>";
else
 echo $ert['kapcs_torzs_nev'];

//tagv
echo '<td>';
if($ert['kapcs_torzs_inaktiv']==0){
 echo '<select onchange="admin_modkapcstorzs_ment(\''.$ert['kapcs_torzs_id'].'\')" id="admin_modkapcstorzs_tagvkod_'.$ert['kapcs_torzs_id'].'" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:211px">';
 
 if($ert['tagv_kod']==''){
  echo '<option value="keremv">Kérem válassz';
 }else{
 echo '<option value="'.$ert['tagv_kod'].'">'.$ert['tagv_kod'];
 if(isset($tomb_tagvkod_nev[$ert['tagv_kod']]))
	  echo ' - '.$tomb_tagvkod_nev[$ert['tagv_kod']];
 }
 echo '</select>';
}

//Beosztás
echo '<td>';
if($ert['kapcs_torzs_inaktiv']==0)
 echo "<input type='text' style='width:300px' maxlength='255' onkeyup='admin_modkapcstorzs_ment(\"".$ert['kapcs_torzs_id']."\")' id='admin_modkapcstorzs_beosztas_".$ert['kapcs_torzs_id']."' value='".$ert['kapcs_torzs_beosztas']."'>";
else
 echo $ert['kapcs_torzs_beosztas'];

//Tel
echo '<td>';
if($ert['kapcs_torzs_inaktiv']==0)
 echo "<input type='text' style='width:200px' maxlength='50' onkeyup='admin_modkapcstorzs_ment(\"".$ert['kapcs_torzs_id']."\")' id='admin_modkapcstorzs_tel_".$ert['kapcs_torzs_id']."' value='".$ert['kapcs_torzs_tel']."'>";
else
 echo $ert['kapcs_torzs_tel'];

//Email
echo '<td>';
if($ert['kapcs_torzs_inaktiv']==0)
 echo "<input type='text' style='width:250px' maxlength='100' onkeyup='admin_modkapcstorzs_ment(\"".$ert['kapcs_torzs_id']."\")' id='admin_modkapcstorzs_email_".$ert['kapcs_torzs_id']."' value='".$ert['kapcs_torzs_email']."'>";
else
 echo $ert['kapcs_torzs_email'];

//Inaktív
echo "<td align=center>";
if($ert['kapcs_torzs_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modkapcstorzs_inaktiv(\"".$ert['kapcs_torzs_id']."\")' class='link' type='checkbox' id='admin_modkapcstorzs_inaktiv_".$ert['kapcs_torzs_id']."'>";

echo '</tr>';

}
}
}
}

function admin_ujkapcstorzs_ment(){

if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."Név kitöltése kötelező";
 exit;
}

if((!isset($_POST['tagvkod']))or(
(isset($_POST['tagvkod'])and($_POST['tagvkod']==""))
)){
 echo "nook$;$"."Társaság kitöltése kötelező";
 exit;
}

if((!isset($_POST['beosztas']))or(
(isset($_POST['beosztas'])and($_POST['beosztas']==""))
)){
 echo "nook$;$"."Beosztás kitöltése kötelező";
 exit;
}

$vane=keres_mit4_mit1("kapcs_torzs","kapcs_torzs_nev",$_POST['nev'],"tagv_kod",$_POST['tagvkod'],"kapcs_torzs_beosztas",$_POST['beosztas'],"kapcs_torzs_inaktiv","0","kapcs_torzs_id");
if(is_array($vane)){
	echo "Hiba! Van már ilyen Tulajdonosi törzsadat!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['kapcs_torzs_nev']=$_POST['nev'];
 $tmp_bk[0]['tagv_kod']=$_POST['tagvkod'];
 $tmp_bk[0]['kapcs_torzs_beosztas']=$_POST['beosztas'];
 if(isset($_POST['tel']))
  $tmp_bk[0]['kapcs_torzs_tel']=$_POST['tel'];
 if(isset($_POST['email']))
 $tmp_bk[0]['kapcs_torzs_email']=$_POST['email'];
 be_visz_insert("kapcs_torzs",$tmp_bk);
 echo 'ok$;$';
}

}

function admin_modkapcstorzs_ment(){
if(
(isset($_POST['id']))and
(isset($_POST['nev']))and
(isset($_POST['tagv']))and
(isset($_POST['beosztas']))and
(isset($_POST['tel']))and
(isset($_POST['email']))and
($_POST['id']!="")and
($_POST['nev']!="")and
($_POST['tagv']!="")and
($_POST['beosztas']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['kapcs_torzs_nev']=$_POST['nev'];
 
 //$kell_torolni='0';
 if($_POST['tagv']=='keremv'){
  $tmp_mod[0]['tagv_kod']=null;
  
  //Ekkor minden mira_tagv_kod kapcs adatát törölni kell
  //$kell_torolni='1';
  
 }else{
  $tmp_mod[0]['tagv_kod']=$_POST['tagv'];
  
  //Ekkor csak akkor kell törölni, ha változott a társasága.
  /*
  $orig_tagv=keres_mit1_mit1_csak_ertek('kapcs_torzs','kapcs_torzs_id',$_POST['id'],'tagv_kod');
  if($orig_tagv!=$_POST['tagv']){
	$kell_torolni='1';  
  }
  */
 }

 $tmp_mod[0]['kapcs_torzs_beosztas']=$_POST['beosztas'];
 $tmp_mod[0]['kapcs_torzs_tel']=$_POST['tel'];
 $tmp_mod[0]['kapcs_torzs_email']=$_POST['email'];
 mod_egy_fel_tom('kapcs_torzs',$tmp_mod[0],'kapcs_torzs_id',$_POST['id']);

 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modkapcstorzs_inaktiv(){
if(
(isset($_POST['id']))and
(isset($_POST['inaktiv']))and
($_POST['id']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){
 
 mysqli_autocommit($GLOBALS['mysqli'],false);

//Kapcsolattartó törlések - eleje
 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1']=null;
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod_kapcs_torzs_id_vezeto_1',$_POST['id']);

 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1_t']=null;
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod_kapcs_torzs_id_vezeto_1_t',$_POST['id']);

 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_2']=null;
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod_kapcs_torzs_id_vezeto_2',$_POST['id']);

 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_kapcs_torzs_id_kapcstarto']=null;
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod_kapcs_torzs_id_kapcstarto',$_POST['id']);


 $tmp_mod=array();
 $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_mvms']=null;
 mod_egy_fel_tom('kapcs_ossze',$tmp_mod[0],'kapcs_ossze_kapcs_torzs_id_mvms',$_POST['id']);

 $tmp_mod=array();
 $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_sla']=null;
 mod_egy_fel_tom('kapcs_ossze',$tmp_mod[0],'kapcs_ossze_kapcs_torzs_id_sla',$_POST['id']);

 torles('kapcs_ossze_kapcs','kapcs_torzs_id',$_POST['id']);


//Inaktiválás 
 $tmp_mod=array();
 $tmp_mod[0]['kapcs_torzs_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('kapcs_torzs',$tmp_mod[0],'kapcs_torzs_id',$_POST['id']);
 
mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

 echo 'ok$;$';
 
 
}else{
 echo 'adathiány';
}
}

?>
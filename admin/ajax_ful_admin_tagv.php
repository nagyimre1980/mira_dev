<?php

function admin_tagv_kod_mod(){
echo 'ok$;$';
admin_tagv_kod_mod_urlap();
admin_tagv_kod_mod_kereses();
echo "<div id='admin_uj_tagv_kod_list_keres_tal' style='overflow-x:auto'>";
admin_tagv_kod_mod_list();
echo "</div>";
}

function admin_tagv_kod_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új társaság:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>SAP kód *';
echo '<td>';
echo '<input id="admin_ujtagvkod_tagvkod" type=text style="width:80px" maxlength="4">';
echo '</tr>';

echo "<tr>";
echo "<td>Társaság neve *";
echo "<td>";
echo "<input id='admin_ujtagvkod_nev' type=text style='width:400px' maxlength=100>";
echo "</tr>";

echo "<tr><td colspan=2 align=left><input id='admin_ujtagvkod_submit' onclick='admin_ujtagvkod()' type=submit value='Új társasági SAP kód felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_tagvkodlist_keres(){
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']=$_POST['tagv_kod'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_tagv_kod_mod_list();
}

function admin_tagv_kod_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']!=""))
 $ker_kod=$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod'];
else $ker_kod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_tagvkodlistker_table' class='table_emre'>";

echo "<tr>";
echo "<td>SAP kód";
echo "<td><input style='width:80px' maxlength='4' onkeyup='admin_tagvkodlist_keres(\"tallep_elso\",\"\")' id='admin_tagvkodlist_keres_tagv_kod' value='".$ker_kod."' type=text>";

echo "<td>Társaság neve";
echo "<td><input style='width:200px' maxlength='100' onkeyup='admin_tagvkodlist_keres(\"tallep_elso\",\"\")' id='admin_tagvkodlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_tagvkodlist_keres_proc(\"tallep_elso\",\"\")' id='admin_tagvkodlist_keres_inaktiv' style='width:150px'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo "</select>";

echo '</table></div>';
}

function admin_tagv_kod_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tagvkod_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő jogok módosítása</b>";

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo "<table cellpadding='1' cellspacing='1' id='admin_tagvkodlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="mira_tagv_kod.tagv_kod";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>SAP kód ";//s1tyle='width:80px'
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="mira_tagv_kod.tagv_kod_nev";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság neve ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

$order_mezo="kapcs_tulaj.kapcs_tulaj_kod";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>Tulajdonosi joggyakorló ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="mira_tagv_kod.tagv_kod_cim";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>Cím ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="mira_tagv_kod.tagv_kod_adoszam";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>Adószám ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs_vezeto_1.kapcs_torzs_nev";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>1. számú vezető ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs_vezeto_1_t.kapcs_torzs_nev";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>1. számú vezető (több esetén) ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs_vezeto_2.kapcs_torzs_nev";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>2. számú vezető/gazdasági vezető ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_torzs_kapcst.kapcs_torzs_nev";
echo "<th class='link' onclick='admin_tagvkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>Kapcsolattartó (gazdasági ügyekben) ";
echo tabl_nyilak('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod',$order_mezo);

echo "</tr></thead><tbody>";

admin_uj_tagv_kod_list_tal($tomb);

echo "</tbody></table>";
echo '</div>';

elozo_kovetkezo_gombok("admin_tagvkodlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam'],"admin_tagvkodlist_keres_proc","admin_tagvkodlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_tagvkodlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_tagvkodlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_tagvkodlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_tagvkodlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_tagvkodlist_keres",$th);
}

}


function admin_uj_tagv_kod_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr title="'.$ert['tagv_kod'].'" class="ttooltip">';

echo '<td>';
echo $ert['tagv_kod'];
echo '<input value="'.$ert['tagv_kod'].'" id="admin_ujtagvkodmod_tagv_kod_'.$ert['tagv_kod'].'" type="hidden">';

//Társaság neve
echo '<td>';
if($ert['tagv_kod_inaktiv']==0)
 echo "<input type='text' style='width:350px' maxlength='100' onkeyup='admin_modtagvkod_ment(\"".$ert['tagv_kod']."\")' id='admin_ujtagvkodmod_nev_".$ert['tagv_kod']."' value='".$ert['tagv_kod_nev']."'>";
else
 echo $ert['tagv_kod_nev'];

//Inaktív
echo "<td align=center>";
if($ert['tagv_kod_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modtagvkod_inaktiv(\"".$ert['tagv_kod']."\")' class='link' type='checkbox' id='admin_ujtagvkodmod_inaktiv_".$ert['tagv_kod']."'>";

//Tulajdonosi jog gyakorló - eleje
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
echo '<select onchange="admin_modtagvkod_ment(\''.$ert['tagv_kod'].'\')" id="admin_ujtagvkodmod_kapcstulaj_'.$ert['tagv_kod'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_tulaj" style="width:211px">';
if($ert['kapcs_tulaj_kod']=='')
 echo '<option value="keremv">Kérem válassz';
else
 echo '<option value="'.$ert['kapcs_tulaj_kod'].'" selected>'.$ert['kapcs_tulaj_kod'].' - '.$ert['kapcs_tulaj_nev'];
echo '</select>';
}
//Tulajdonosi jog gyakorló - vége

//Cím
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
 echo "<input onkeyup='admin_modtagvkod_ment(\"".$ert['tagv_kod']."\")' id='admin_ujtagvkodmod_cim_".$ert['tagv_kod']."' value='".$ert['tagv_kod_cim']."' style='width:250px' maxlength='255' type='text'>";
}/*else{
 echo $ert['tagv_kod_cim'];
}*/

//Adószám
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
 echo "<input onkeyup='admin_modtagvkod_ment(\"".$ert['tagv_kod']."\")' id='admin_ujtagvkodmod_adoszam_".$ert['tagv_kod']."' value='".$ert['tagv_kod_adoszam']."' style='width:120px' maxlength='30' type='text'>";
}
	
//1. számú vezető - eleje
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
echo '<select onchange="admin_modtagvkod_ment_proc(\''.$ert['tagv_kod'].'\')" id="admin_ujtagvkodmod_vezeto_1_'.$ert['tagv_kod'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_ujtagvkodmod_tagv_kod_'.$ert['tagv_kod'].'" style="width:211px">';
if($ert['tagv_kod_kapcs_torzs_id_vezeto_1']=='')
 echo '<option value="keremv">Kérem válassz';
else
 echo '<option value="'.$ert['tagv_kod_kapcs_torzs_id_vezeto_1'].'" selected>'.$ert['kapcs_torzs_vezeto_1_nev'].' ('.$ert['kapcs_torzs_vezeto_1_tagv_kod'].')';
echo '</select>';
}
//1. számú vezető - vége

//1. számú vezető (több esetén) - eleje
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
echo '<select onchange="admin_modtagvkod_ment_proc(\''.$ert['tagv_kod'].'\')" id="admin_ujtagvkodmod_vezeto_1_t_'.$ert['tagv_kod'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_ujtagvkodmod_tagv_kod_'.$ert['tagv_kod'].'" style="width:211px">';
if($ert['tagv_kod_kapcs_torzs_id_vezeto_1_t']=='')
 echo '<option value="keremv">Kérem válassz';
else
 echo '<option value="'.$ert['tagv_kod_kapcs_torzs_id_vezeto_1_t'].'" selected>'.$ert['kapcs_torzs_vezeto_1_t_nev'].' ('.$ert['kapcs_torzs_vezeto_1_t_tagv_kod'].')';
echo '</select>';
}
//1. számú vezető (több esetén) - vége

//2. számú vezető/gazdasági vezető - eleje
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
echo '<select onchange="admin_modtagvkod_ment_proc(\''.$ert['tagv_kod'].'\')" id="admin_ujtagvkodmod_vezeto_2_'.$ert['tagv_kod'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_ujtagvkodmod_tagv_kod_'.$ert['tagv_kod'].'" style="width:211px">';
if($ert['tagv_kod_kapcs_torzs_id_vezeto_2']=='')
 echo '<option value="keremv">Kérem válassz';
else
 echo '<option value="'.$ert['tagv_kod_kapcs_torzs_id_vezeto_2'].'" selected>'.$ert['kapcs_torzs_vezeto_2_nev'].' ('.$ert['kapcs_torzs_vezeto_2_tagv_kod'].')';
echo '</select>';
}
//2. számú vezető/gazdasági vezető - vége

//Kapcsolattartó (gazdasági ügyekben) - eleje
echo '<td>';
if($ert['tagv_kod_inaktiv']==0){
echo '<select onchange="admin_modtagvkod_ment_proc(\''.$ert['tagv_kod'].'\')" id="admin_ujtagvkodmod_kapcst_'.$ert['tagv_kod'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_ujtagvkodmod_tagv_kod_'.$ert['tagv_kod'].'" style="width:211px">';
if($ert['tagv_kod_kapcs_torzs_id_kapcstarto']=='')
 echo '<option value="keremv">Kérem válassz';
else
 echo '<option value="'.$ert['tagv_kod_kapcs_torzs_id_kapcstarto'].'" selected>'.$ert['kapcs_torzs_kapcst_nev'].' ('.$ert['kapcs_torzs_kapcst_tagv_kod'].')';
echo '</select>';
}
//Kapcsolattartó (gazdasági ügyekben) - vége

echo '</tr>';
}
}
}
}

function admin_modtagvkod_inaktiv(){
if(
(isset($_POST['tagv_kod']))and
(isset($_POST['inaktiv']))and
($_POST['tagv_kod']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){
 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod',$_POST['tagv_kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modtagvkod_ment(){
if(
(isset($_POST['tagv_kod']))and
(isset($_POST['nev']))and
(isset($_POST['kapcstulaj']))and
(isset($_POST['cim']))and
(isset($_POST['adoszam']))and
(isset($_POST['vezeto_1']))and
(isset($_POST['vezeto_1_t']))and
(isset($_POST['vezeto_2']))and
(isset($_POST['kapcst']))and
($_POST['tagv_kod']!="")and
($_POST['nev']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_nev']=$_POST['nev'];
 
 $tmp_mod[0]['tagv_kod_adoszam']=$_POST['adoszam'];
 $tmp_mod[0]['tagv_kod_cim']=$_POST['cim'];
 
 if($_POST['kapcstulaj']=='keremv')
  $tmp_mod[0]['kapcs_tulaj_kod']=null;
 else
  $tmp_mod[0]['kapcs_tulaj_kod']=$_POST['kapcstulaj'];

 if($_POST['vezeto_1']=='keremv')
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1']=null;
 else
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1']=$_POST['vezeto_1'];
 
 if($_POST['vezeto_1_t']=='keremv')
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1_t']=null;
 else
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_1_t']=$_POST['vezeto_1_t'];
  
 if($_POST['vezeto_2']=='keremv')
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_2']=null;
 else
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_vezeto_2']=$_POST['vezeto_2'];
   
 if($_POST['kapcst']=='keremv')
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_kapcstarto']=null;
 else
  $tmp_mod[0]['tagv_kod_kapcs_torzs_id_kapcstarto']=$_POST['kapcst'];
 
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod',$_POST['tagv_kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_ujtagvkod_ment(){

if((!isset($_POST['tagvkod']))or(
(isset($_POST['tagvkod'])and($_POST['tagvkod']==""))
)){
 echo "nook$;$"."Társasági SAP kód kitöltése kötelező!";
 exit;
}

if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."Társaság nevének kitöltése kötelező!";
 exit;
}

$vane=keres_mit1_mit1("mira_tagv_kod","tagv_kod",$_POST['tagvkod'],"tagv_kod");
if(is_array($vane)){
	echo "Hiba! Van már ilyen Társasági SAP kód!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['tagv_kod']=$_POST['tagvkod'];
 $tmp_bk[0]['tagv_kod_nev']=$_POST['nev'];
 be_visz_insert("mira_tagv_kod",$tmp_bk);
 echo 'ok$;$';
}

}

?>
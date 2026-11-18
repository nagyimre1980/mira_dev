<?php
//Szolgáltatási kapcsolattartó összerendelés

function admin_kapcsossze_mod(){
echo "ok$;$";

unset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']);
unset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']);
admin_kapcsossze_mod_urlap();
admin_kapcsossze_mod_kereses();
echo "<div id='admin_uj_kapcsossze_list_keres_tal' style='overflow-x:auto'>";
admin_kapcsossze_mod_list();
echo "</div>";

}

function admin_kapcsossze_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új társasági szolgáltatási kapcsolattartó összerendelés:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Társaság *';
echo '<td>';
 echo '<select id="admin_ujkapcsossze_tagvkod" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

//Szervezeti szolgáltatás kód
echo '<tr>';
echo '<td>Szolgáltatás *';
echo '<td>';
echo '<select id="admin_ujkapcsossze_szolgkod" class="select2_ajax" csonkolt=1 mod="admin_szolgkod_ujtorzsossze" style="width:411px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujkapcsossze_submit' onclick='admin_ujkapcsossze()' type=submit value='Új társasági kapcsolattartó összerendelés felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_kapcsosszelist_keres(){
if(isset($_POST['tagv']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']=$_POST['tagv'];
if(isset($_POST['szolg_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']=$_POST['szolg_kod'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']=$_POST['nev'];
echo "ok$;$";
admin_kapcsossze_mod_list();
}

function admin_kapcsossze_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']!=""))
 $ker_tagv=$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv'];
else $ker_tagv="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']!=""))
 $ker_szolg_kod=$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod'];
else $ker_szolg_kod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev'];
else $ker_nev="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_kapcsosszelist_table' class='table_emre'>";

echo "<tr>";
echo "<td>Társaság";
 //echo '<td><select onchange="admin_kapcsosszelist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcsosszelist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
 $tomb_tagvkod_nev=keres_tagvkod_nev_tomb();
 echo '<td><select onchange="admin_kapcsosszelist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcsosszelist_keres_tagv" class="select2_csonkolt" style="width:311px">';
 echo '<option value="all">Összes';
 if(is_array($tomb_tagvkod_nev)){
  foreach($tomb_tagvkod_nev as $tagv_kod => $nev){
   echo '<option value="'.$tagv_kod.'">'.$tagv_kod.' - '.$nev;	 
  }
 }
 echo '</select>';

echo "<td>Szolgáltatás";
 //echo '<td><select onchange="admin_kapcsosszelist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcsosszelist_keres_szolgkod" class="select2_ajax" csonkolt=1 mod="admin_szolgkod_uj_all" style="width:311px">';
 $tomb_szolgkod_nev=keres_szolgkod_nev_tomb();
 echo '<td><select onchange="admin_kapcsosszelist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcsosszelist_keres_szolgkod" class="select2_csonkolt" style="width:311px">';
 echo '<option value="all">Összes';
 if(is_array($tomb_szolgkod_nev)){
  foreach($tomb_szolgkod_nev as $szolg_kod => $nev){
   echo '<option value="'.$szolg_kod.'">'.$szolg_kod.' - '.$nev;	 
  }
 }
 echo '</select>';

echo '<td>Kapcsolattartó neve';
echo '<td><input value="'.$ker_nev.'" onkeyup="admin_kapcsosszelist_keres_proc(\'tallep_elso\',\'\')" id="admin_kapcsosszelist_keres_nev" style="width:250px"  maxlength="255" type="text">';

echo "</tr>";
echo '</table></div>';
}

function admin_kapcsossze_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcsossze_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";
echo "<table id='admin_kapcstulajlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="kapcs_ossze.kapcs_ossze_id";
echo "<th style='width:20px' class='link' onclick='admin_kapcsosszelist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod',$order_mezo);

echo "<th>Törlés";

$order_mezo="kapcs_ossze.tagv_kod";
echo "<th style='width:20px' class='link' onclick='admin_kapcsosszelist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_ossze.szolg_kod";
echo "<th style='width:20px' class='link' onclick='admin_kapcsosszelist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás ";
echo tabl_nyilak('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod',$order_mezo);

echo "<th>Kapcsolattartó<br>általános ügyekben";
echo "<th>Kapcsolattartó<br>szolgáltatás specifikus ügyekben";
echo "<th>MVMS kapcsolattartó<br>szolgáltatás specifikus ügyekben";
echo "<th>MVMS kapcsolattartó<br>SLA/KPI";

echo "</tr></thead><tbody>";

admin_kapcsossze_list_tal($tomb);

echo "</tbody></table>";


elozo_kovetkezo_gombok("admin_kapcsosszelist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam'],"admin_kapcsosszelist_keres_proc","admin_kapcsosszelist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_kapcsosszelist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_kapcsosszelist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_kapcsosszelist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_kapcsosszelist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_kapcsosszelist_keres",$th);
}
}

function admin_kapcsossze_list_tal($tomb){

$tomb_tagvkod_nev=keres_tagvkod_nev_tomb();
$tomb_szolgkod_nev=keres_szolgkod_nev_tomb();
$tomb_nev=keres_tagv_kapcsolattartok_nev_all();
$tomb_kapcs=keres_tagv_kapcsossze_kapcs($tomb);

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr style="vertical-align:top" title="'.$ert['tagv_kod'].' - '.$ert['szolg_kod'].'" class="ttooltip">';

//ID
echo '<td>';
echo $ert['kapcs_ossze_id'];

//Törlés
echo '<td align=center>';
echo '<img onclick="admin_modkapcsossze_del(\''.$ert['kapcs_ossze_id'].'\')" title="Törlés" class="linkimg_tooltip" src="image\del.png">';

//tagv
echo '<td>';
echo '<span id="admin_modkapcstorzs_tagvkod_'.$ert['kapcs_ossze_id'].'">'.$ert['tagv_kod'].' - '.$tomb_tagvkod_nev[$ert['tagv_kod']].'</span>';
echo '<input value="'.$ert['tagv_kod'].'" id="admin_modkapcstorzs_hid_tagvkod_'.$ert['kapcs_ossze_id'].'" type="hidden">';

//Szolgáltatás kód
echo '<td>';
echo '<span id="admin_modkapcstorzs_szolgkod_'.$ert['kapcs_ossze_id'].'">'.$ert['szolg_kod'].' - '.$tomb_szolgkod_nev[$ert['szolg_kod']].'</span>';

//Kapcsolattartó általános ügyekben - eleje
echo '<td id="td_admin_modkapcsossze_kapcs1_'.$ert['kapcs_ossze_id'].'">';
if((isset($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs1']))and(is_array($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs1']))){
 $i=0;
 foreach($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs1'] as $kapcs_ossze_kapcs_id => $ert_k1){
  $i++;
  echo '<div';
  if($i>1)echo ' style="margin-top:5px"';
  echo '>';
    
  echo '<select onchange="admin_modkapcsossze_kapcs1_ment(\''.$ert['kapcs_ossze_id'].'\',\''.$kapcs_ossze_kapcs_id.'\',\''.$i.'\')" id="admin_modkapcsossze_kapcs1_'.$ert['kapcs_ossze_id'].'_'.$i.'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'.$ert['kapcs_ossze_id'].'" style="width:211px">';
  echo '<option value="'.$ert_k1['kapcs_torzs_id'].'" selected>'.$ert_k1['kapcs_torzs_nev'].' ('.$ert_k1['tagv_kod'].')';
  echo '</select>';
  if($i==sizeof($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs1']))
   echo '<img onclick="admin_modkapcsossze_kapcs1_add(\''.$ert['kapcs_ossze_id'].'\',\''.$i.'\')" src="image\add_16.png" class="admin_modkapcsossze_kapcs1_img_add">';
  echo '</div>';
 }
}else{//Ha nincs még kiválasztva...
 echo '<select onchange="admin_modkapcsossze_kapcs1_ment(\''.$ert['kapcs_ossze_id'].'\',\'\',\'1\')" id="admin_modkapcsossze_kapcs1_'.$ert['kapcs_ossze_id'].'_1" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'.$ert['kapcs_ossze_id'].'" style="width:211px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
 echo '<img onclick="admin_modkapcsossze_kapcs1_add(\''.$ert['kapcs_ossze_id'].'\',\'1\')" src="image\add_16.png" class="admin_modkapcsossze_kapcs1_img_add" style="margin-left:5px">';
}
//Kapcsolattartó általános ügyekben - vége

//Kapcsolattartó szolgáltatás specifikus ügyekben - eleje
echo '<td id="td_admin_modkapcsossze_kapcs2_'.$ert['kapcs_ossze_id'].'">';
if((isset($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs2']))and(is_array($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs2']))){
 $i=0;
 foreach($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs2'] as $kapcs_ossze_kapcs_id => $ert_k1){
  $i++;
  echo '<div';
  if($i>1)echo ' style="margin-top:5px"';
  echo '>';
    
  echo '<select onchange="admin_modkapcsossze_kapcs2_ment(\''.$ert['kapcs_ossze_id'].'\',\''.$kapcs_ossze_kapcs_id.'\',\''.$i.'\')" id="admin_modkapcsossze_kapcs2_'.$ert['kapcs_ossze_id'].'_'.$i.'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'.$ert['kapcs_ossze_id'].'" style="width:211px">';
  echo '<option value="'.$ert_k1['kapcs_torzs_id'].'" selected>'.$ert_k1['kapcs_torzs_nev'].' ('.$ert_k1['tagv_kod'].')';
  echo '</select>';
  if($i==sizeof($tomb_kapcs[$ert['kapcs_ossze_id']]['kapcs2']))
   echo '<img onclick="admin_modkapcsossze_kapcs2_add(\''.$ert['kapcs_ossze_id'].'\',\''.$i.'\')" src="image\add_16.png" class="admin_modkapcsossze_kapcs2_img_add">';
  echo '</div>';
 }
}else{//Ha nincs még kiválasztva...
 echo '<select onchange="admin_modkapcsossze_kapcs2_ment(\''.$ert['kapcs_ossze_id'].'\',\'\',\'1\')" id="admin_modkapcsossze_kapcs2_'.$ert['kapcs_ossze_id'].'_1" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'.$ert['kapcs_ossze_id'].'" style="width:211px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
 echo '<img onclick="admin_modkapcsossze_kapcs2_add(\''.$ert['kapcs_ossze_id'].'\',\'1\')" src="image\add_16.png" class="admin_modkapcsossze_kapcs2_img_add" style="margin-left:5px">';
}
//Kapcsolattartó szolgáltatás specifikus ügyekben - vége

//MVMS kapcsolattartó szolgáltatás specifikus ügyekben
echo '<td>';
echo '<select onchange="admin_modkapcsossze_ment(\''.$ert['kapcs_ossze_id'].'\')" id="admin_modkapcstorzs_mvms_'.$ert['kapcs_ossze_id'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit3="NKMH" style="width:211px">';
if($ert['kapcs_ossze_kapcs_torzs_id_mvms']!='')
 echo '<option value="'.$ert['kapcs_ossze_kapcs_torzs_id_mvms'].'" selected>'.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_mvms']]['tagv_kod'].')';
else
 echo '<option value="keremv">Kérem válassz';
echo '</select>';

//MVMS kapcsolattartó SLA/KPI
echo '<td>';
echo '<select onchange="admin_modkapcsossze_ment(\''.$ert['kapcs_ossze_id'].'\')" id="admin_modkapcstorzs_sla_'.$ert['kapcs_ossze_id'].'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit3="NKMH" style="width:211px">';
if($ert['kapcs_ossze_kapcs_torzs_id_sla']!='')
 echo '<option value="'.$ert['kapcs_ossze_kapcs_torzs_id_sla'].'" selected>'.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['kapcs_torzs_nev'].' ('.$tomb_nev[$ert['kapcs_ossze_kapcs_torzs_id_sla']]['tagv_kod'].')';
else
 echo '<option value="keremv">Kérem válassz';	
echo '</select>';

echo '</tr>';
}
}
}
}

function admin_ujkapcsossze_ment(){

if((!isset($_POST['tagvkod']))or(
(isset($_POST['tagvkod'])and($_POST['tagvkod']==""))
)){
 echo "nook$;$"."Társaság kitöltése kötelező";
 exit;
}

if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and($_POST['szolgkod']==""))
)){
 echo "nook$;$"."Szolgáltatás kód kitöltése kötelező";
 exit;
}

$vane=keres_mit2_mit1("kapcs_ossze","tagv_kod",$_POST['tagvkod'],"szolg_kod",$_POST['szolgkod'],"kapcs_ossze_id");
if(is_array($vane)){
	echo "nook$;$"."Hiba!<br><br>Van már ilyen társaság - szogláltatás kód összerendelés!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['tagv_kod']=$_POST['tagvkod'];
 $tmp_bk[0]['szolg_kod']=$_POST['szolgkod'];
 be_visz_insert("kapcs_ossze",$tmp_bk);
 echo 'ok$;$';
}
}

function admin_modkapcsossze_ment(){
if(
(isset($_POST['kapcs_ossze_id']))and
(isset($_POST['torzs_id_mvms']))and
(isset($_POST['torzs_id_sla']))and
($_POST['kapcs_ossze_id']!='')
){

 $tmp_mod=array();
 if($_POST['torzs_id_mvms']=='keremv'){
  $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_mvms']=null;
 }else{
  $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_mvms']=$_POST['torzs_id_mvms'];
 }

 if($_POST['torzs_id_sla']=='keremv'){
  $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_sla']=null;
 }else{
  $tmp_mod[0]['kapcs_ossze_kapcs_torzs_id_sla']=$_POST['torzs_id_sla'];
 }

 mod_egy_fel_tom('kapcs_ossze',$tmp_mod[0],'kapcs_ossze_id',$_POST['kapcs_ossze_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modkapcsossze_kapcs_ment(){
if(
(isset($_POST['kapcs_ossze_kapcs_id']))and
(isset($_POST['kapcs_ossze_id']))and
(isset($_POST['kapcs_ossze_kapcs_tipus']))and
(isset($_POST['kapcs_torzs_id']))and
($_POST['kapcs_ossze_id']!='')and
($_POST['kapcs_torzs_id']!='')and
(
 ($_POST['kapcs_ossze_kapcs_tipus']=='kapcs1')or
 ($_POST['kapcs_ossze_kapcs_tipus']=='kapcs2')
)
){

//Nézzük meg, hogy van-e már ilyan kiválasztva.
if(
($_POST['kapcs_torzs_id']!='keremv')and
(keres_mit3_mit1_csak_ertek('kapcs_ossze_kapcs','kapcs_ossze_id',$_POST['kapcs_ossze_id'],'kapcs_torzs_id',$_POST['kapcs_torzs_id'],"kapcs_ossze_kapcs_tipus",$_POST['kapcs_ossze_kapcs_tipus'],'kapcs_ossze_kapcs_id')!='')
){
 echo 'nook$;$';
 echo 'Hiba!<br><br>Van már ilyen kiválasztott kapcsolattartó ehhez a társasághoz és szolgáltatáshoz!';
 exit;
}

if(($_POST['kapcs_ossze_kapcs_id']=='')and($_POST['kapcs_torzs_id']!='keremv')){//Bevitel
 $tmp_bk=array();
 $tmp_bk[0]['kapcs_ossze_id']=$_POST['kapcs_ossze_id'];
 $tmp_bk[0]['kapcs_ossze_kapcs_tipus']=$_POST['kapcs_ossze_kapcs_tipus'];
 $tmp_bk[0]['kapcs_torzs_id']=$_POST['kapcs_torzs_id'];
 be_visz_insert('kapcs_ossze_kapcs',$tmp_bk);
}elseif($_POST['kapcs_torzs_id']!='keremv'){//Módosítás
  $tmp_mod=array();
  $tmp_mod[0]['kapcs_torzs_id']=$_POST['kapcs_torzs_id'];
  mod_egy_fel_tom2('kapcs_ossze_kapcs',$tmp_mod[0],'kapcs_ossze_kapcs_id',$_POST['kapcs_ossze_kapcs_id'],'kapcs_ossze_id',$_POST['kapcs_ossze_id']);
}else{//Törlés
 torles2('kapcs_ossze_kapcs','kapcs_ossze_kapcs_id',$_POST['kapcs_ossze_kapcs_id'],'kapcs_ossze_id',$_POST['kapcs_ossze_id']);
}
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modkapcsossze_del_proc(){
if(
(isset($_POST['kapcs_ossze_id']))and
($_POST['kapcs_ossze_id']!='')
){
 torles('kapcs_ossze','kapcs_ossze_id',$_POST['kapcs_ossze_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>
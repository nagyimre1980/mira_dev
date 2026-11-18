<?php

function riport_ful_ki_szerznyilv(){

echo '<div id="riport_div_szerznyilv"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['szerznyilv']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_szerznyilv_leker()" id="riport_leker_szerznyilv_submit" value="Szerződésnyilvántartó excel letöltése" class="submit2" type="submit" >';

echo '</div>';
}

function riport_ful_ki_szerznyilv_html(){
//echo 'Szerződésnyilvántartó találati lista<br>';
//riport_ful_ki_szerznyilv_html_fo('teljes');
}

function riport_ful_ki_szerznyilv_html_fo($mod){
//if(!isset($_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv']))
// $_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv']=$_POST['tagv']='all';
riport_ful_ki_szerznyilv_html_fo_kereses($mod);
echo '<div id="admin_uj_szerznyilv_list_keres_tal" style="overflow-x:auto">';
riport_ful_ki_szerznyilv_html_fo_list($mod);
echo '</div>';
}

function riport_ful_ki_szerznyilv_html_keres(){
if(
(!isset($_POST['mod']))
or
 (
  (isset($_POST['mod']))and
   ($_POST['mod']!='teljes')and
   ($_POST['mod']!='elo')
 )
){
 echo "adathiány";
 exit;
}

if(isset($_POST['tagv']))$_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv']=$_POST['tagv'];
echo "ok$;$";
riport_ful_ki_szerznyilv_html_fo_list($_POST['mod']);
}

function riport_ful_ki_szerznyilv_html_fo_kereses($mod){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv']!=""))
 $ker_tagv=$_SESSION[$GLOBALS['sessionname']]['riport_szerznyilvlist_keres']['tagv'];
else $ker_tagv="all";

if($mod=='teljes'){
 echo "<br><b>Szerződésnyilvántartó - teljes</b>";
}else{
 echo "<br><b>Szerződésnyilvántartó - elő</b>";
}

echo "<table id='admin_szerznyilvlist_table' class='table_emre'>";

echo '<tr>';
echo '<td>Társaság';
echo '<td>';
echo '<select onchange="riport_szerznyilvlist_keres_proc(\'tallep_elso\',\'\')" id="riport_szerznyilvlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
if($ker_tagv!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv.'">'.$ker_tagv.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>Aktuális szerződések';
$akt_prop=' checked';
echo '<input'.$akt_prop.' onchange="riport_szerznyilvlist_keres_proc(\'tallep_elso\',\'\')" id="riport_szerznyilvlist_keres_akt" type="checkbox">';


echo '</table></div>';
}

function riport_ful_ki_szerznyilv_html_fo_list($mod){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

include_once('riport/riport_szerznyilv_leker.php');
$tomb_szerz_jog=keres_riport_szerznyilv_jog();
$tomb=keres_riport_szerznyilv_uj($mod,$tomb_szerz_jog);

/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
*/

echo "<br><b>Szerződésnyilvántartó</b>";
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo "<table cellpadding='1' cellspacing='1' id='admin_riportszerznyilvkodlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="szerz_tetel.szerz_tetel_id";
echo "<th class='link' onclick='riport_szerznyilvlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_riportszerznyilvlist_keres_order','admin_riportszerznyilvlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.tagv_kod";
echo "<th class='link' onclick='riport_szerznyilvlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_riportszerznyilvlist_keres_order','admin_riportszerznyilvlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_keret";
echo "<th class='link' onclick='riport_szerznyilvlist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_riportszerznyilvlist_keres_order','admin_riportszerznyilvlist_keres_order_mod',$order_mezo);

echo "</tr></thead><tbody>";
riport_ful_ki_szerznyilv_html_fo_list_tal($tomb);

echo "</tbody></table>";
echo '</div>';

elozo_kovetkezo_gombok("riport_szerznyilvlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam'],"riport_szerznyilvlist_keres_proc","admin_riportszerznyilvlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_riportszerznyilvlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_riportszerznyilvlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_riportszerznyilvlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>riport_szerznyilvlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
//excel_export("admin_tagvkodlist_keres",$th);
}

}

function riport_ful_ki_szerznyilv_html_fo_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_tetel_id'];
 
 echo '<td>';
 echo $ert['tagv_kod']; 
 
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);

 echo '</tr>';
}
}
}
}

function keres_riport_szerznyilv_uj($mod,$tomb_szerz_jog){
$eredmeny_keres="";

$talszam=keres_talszam('admin_riportszerznyilvlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_riportszerznyilvlist_keres_order','admin_riportszerznyilvlist_keres_order_mod');
//Rendezés - vége

$sql_t='';
if(is_array($tomb_szerz_jog)){
 if($tomb_szerz_jog[0]['ful_riport_all']=='0'){//Ekkor nincs teljes joga
 $tomb_user_szerz_csop_all=keres_mit1_mit1_csak_ertek('mira_user','user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad'],'ful_riport_szerz_csop_all');
	 if($tomb_user_szerz_csop_all=='0'){
	 foreach($tomb_szerz_jog as $ert){
		if($ert['szerz_csop_id']!=''){
		 if($sql_t!='')$sql_t.='or';
		 $sql_t.='(szerz_tetel_adat.szerz_csop_id="'.$ert['szerz_csop_id'].'")';
		}
	 }
	 }
 }
}


 $sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal
 
 FROM `szerz_tetel` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt='1'
 
 left join szerz_tetel_integ ON szerz_tetel_integ.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id ";

 if($mod=='elo'){
  $sql1.=" where
  szerz_tetel.szerz_tetel_vege='0' and 
  (
   (szerz_tetel.szerz_tetel_szolg_origveg_date is null)
   or
   (szerz_tetel.szerz_tetel_szolg_origveg_date>='".date("Y-m-d",time())."')
  )
  and
  (
   (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='1')
   or
   (
    (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0')and
	(szerz_tetel_adat.szerz_tetel_akt='1')and
	(szerz_tetel_adat.szerz_tetel_akt_folyamatban='0')
   )
  )
  ";
  if($sql_t!=''){
	  $sql.=' and ('.$sql_t.')';
	 }
	 
 }else{
	 if($sql_t!=''){
	  $sql.=' where ('.$sql_t.')';
	 }
 }
 
 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev
 ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,mira_user_mod.user_nev
 ,szerz_tagvkat.szerz_tagvkat_kat
 ,szerz_tagvkat.szerz_tagvkat_date_kezd
 ,szerz_tetel_integ.szerz_tetel_integ_tobblet
 ,szerz_tetel_integ.szerz_tetel_integ_tobblet_ho
 ,szerz_tetel_integ.szerz_tetel_integ_megj
 FROM `szerz_tetel` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt='1'
 
 left join szerz_tetel_integ ON szerz_tetel_integ.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id ";

 if($mod=='elo'){
  $sql.=" where
  szerz_tetel.szerz_tetel_vege='0' and 
  (
   (szerz_tetel.szerz_tetel_szolg_origveg_date is null)
   or
   (szerz_tetel.szerz_tetel_szolg_origveg_date>='".date("Y-m-d",time())."')
  )
  and
  (
   (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='1')
   or
   (
    (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0')and
	(szerz_tetel_adat.szerz_tetel_akt='1')and
	(szerz_tetel_adat.szerz_tetel_akt_folyamatban='0')
   )
  )
  ";
  
  if($sql_t!=''){
	  $sql.=' and ('.$sql_t.')';
	 }
	 
 }else{
	 if($sql_t!=''){
	  $sql.=' where ('.$sql_t.')';
	 }
 }
 
 $sql.="order by szerz.tagv_kod asc,szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc
 LIMIT ".$_POST['oldalholvagyok'].", ".$talszam;

 //print $sql."<br>";

  $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
return $eredmeny_keres;
}

?>
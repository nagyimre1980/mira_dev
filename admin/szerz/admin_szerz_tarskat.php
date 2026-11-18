<?php

function admin_szerz_tarskat(){
echo 'ok$;$';
//admin_szerz_tarskat_urlap();
admin_szerz_tarskat_kereses();
echo '<div id="admin_uj_tarskat_list_keres_tal" style="overflow-x:auto">';
admin_tarskat_user_list();
echo '</div>';
}

/*function admin_szerz_tarskat_urlap(){

}*/

function admin_tarskatlist_keres(){
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']=$_POST['tagv_kod'];
echo "ok$;$";
admin_tarskat_user_list();
}

function admin_szerz_tarskat_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']!="all"))
 $ker_tagv_kod=$_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod'];
else $ker_tagv_kod="all";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_tarskatlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Társaság';
echo '<td>';
echo '<select onchange="admin_tarskatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tarskatlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
if($ker_tagv_kod!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv_kod,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv_kod.'">'.$ker_tagv_kod.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tarskat_user_list(){

if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tarskat_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_tarskatlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tarskatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_tarskatlist_keres_order','admin_tarskatlist_keres_order_mod',$order_mezo);

echo '<th>Társasági kategória';
echo '<th>Hatályos eleje';
echo '<th>Hatályos vége';
echo '<th>Módosítás';

echo '</tr></thead><tbody>';

admin_tarskat_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tarskat','admin_tarskatlist_keres_talszam','admin_tarskatlist_keres_proc');

}

function admin_tarskat_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';

 echo '<td>';
 echo $ert['tagv_kod'];

 echo '<td>';
 echo kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tagvkat_date_kezd']);
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tagvkat_date_veg']);
 
 echo '<td align=center>';
 echo '<img onclick="admin_szerz_tagvkat_mod(\''.$ert['tagv_kod'].'\')" src="image\mod15_2.png" class="link">';
 
 echo '</tr>';
}
}
}
}

function admin_szerz_tagvkat_mod(){
if((isset($_POST['tagv_kod']))and($_POST['tagv_kod']!='')){
echo 'ok$;$';
$tomb=keres_admin_tarskat_mod($_POST['tagv_kod']);

echo '<table id="admin_szerztagvkatmodlist_table" class="table_emre_kek" style="min-width:500px">';
echo '<thead>';
echo '<tr>';
echo '<th>Aktuális';
echo '<th>Társasági kategória';
echo '<th>Hatályos eleje';
echo '<th>Hatályos vége';
echo '<th>Művelet';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
if(is_array($tomb)){
$last=array_key_last($tomb);
 foreach($tomb as $i => $ert){
	 echo '<tr>';
	 
	 echo '<td>';
	 echo igennem_kod_ki($ert['szerz_tagvkat_akt']);
	 
	 echo '<td>';
	 echo kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
	 
	 echo '<td>';
	 echo kidate_format_ev($ert['szerz_tagvkat_date_kezd']);	 
	 
	 echo '<td>';
	 echo kidate_format_ev($ert['szerz_tagvkat_date_veg']);
	 
	 echo '<td>';
	 if($last==$i){
		 echo '<img onclick="admin_szerz_tagvkat_uj_del(\''.$_POST['tagv_kod'].'\',\''.$ert['szerz_tagvkat_id'].'\')" src="image/del.png" title="Törlés" class="link">';		 
	 }
	 echo '</tr>';
 }
}

echo '</tbody>';

echo '<tfoot>';
echo '<tr>';

echo '<td>Új';

echo '<td>';
echo '<select id="admin_szerz_tagvkat_uj_tagvkat" class="select3" style="width:110px">';
echo '<option value="keremv">Kérem válassz';
echo '<option value="0">'.kiert_szerz_tagvkat_kat('0');
echo '<option value="1">'.kiert_szerz_tagvkat_kat('1');
echo '<option value="2">'.kiert_szerz_tagvkat_kat('2');
echo '<option value="3">'.kiert_szerz_tagvkat_kat('3');
echo '</select>';

echo '<td>';
echo '<input id="admin_szerz_tagvkat_uj_date_kezd" class="date_tol" style="width:100px" type="text">';

echo '<td>';
echo '<input id="admin_szerz_tagvkat_uj_date_veg" class="date_tol" style="width:100px" type="text">';

echo '<td>';
echo '<img onclick="admin_szerz_tagvkat_uj_ment(\''.$_POST['tagv_kod'].'\')" src="image/save2.png" title="Mentés" class="link">';
echo '</tr>';
echo '</tfoot>';

echo '</table>';

}else{
 echo 'Adathiány';
}
}

function admin_szerz_tagvkat_uj_ment(){
if(
 (isset($_POST['tagv_kod']))and
 (isset($_POST['tagvkat']))and
 (isset($_POST['date_kezd']))and
 (isset($_POST['date_veg']))and
 ($_POST['tagv_kod']!='')
){
mysqli_autocommit($GLOBALS['mysqli'],false);

$_POST['date_kezd']=str_replace(".","-",$_POST['date_kezd']);
$_POST['date_veg']=str_replace(".","-",$_POST['date_veg']);
 $tmp_rmod=array();
 $tmp_rmod[0]['szerz_tagvkat_akt']=0;
 $tmp_rmod[0]['szerz_tagvkat_date_veg']=date("Y-m-d", strtotime(str_replace(".","-",$_POST['date_kezd']).' -1 day'));
 //mod_egy_fel_tom('szerz_tagvkat',$tmp_rmod[0],'tagv_kod',$_POST['tagv_kod']);
 mod_egy_fel_tom2('szerz_tagvkat',$tmp_rmod[0],'tagv_kod',$_POST['tagv_kod'],'szerz_tagvkat_akt','1');

 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod']=$_POST['tagv_kod'];
 $tmp_mod[0]['szerz_tagvkat_akt']='1';
 $tmp_mod[0]['szerz_tagvkat_kat']=$_POST['tagvkat'];
 $tmp_mod[0]['szerz_tagvkat_date_kezd']=$_POST['date_kezd'];
 if($_POST['date_veg']!='')
  $tmp_mod[0]['szerz_tagvkat_date_veg']=$_POST['date_veg'];
 be_visz_insert("szerz_tagvkat",$tmp_mod);

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo 'ok$;$';
//Mutassuk meg a listát
admin_szerz_tagvkat_mod();

}else{
 echo 'adathiány';
}
}

function admin_szerz_tagvkat_uj_del(){
if(
 (isset($_POST['tagv_kod']))and
 (isset($_POST['szerz_tagvkat_id']))and
 ($_POST['tagv_kod']!='')and
 ($_POST['szerz_tagvkat_id']!='')
){
 mysqli_autocommit($GLOBALS['mysqli'],false);
 
 torles2('szerz_tagvkat','szerz_tagvkat_id',$_POST['szerz_tagvkat_id'],'tagv_kod',$_POST['tagv_kod']);
 
 //Akt legyen a megmagasabb érték
 $tomblast=keres_mit1_order('szerz_tagvkat','tagv_kod',$_POST['tagv_kod'],'szerz_tagvkat_id','DESC');
 
 if(is_array($tomblast)){
  $tmp_rmod=array();
  $tmp_rmod[0]['szerz_tagvkat_akt']=1;
  mod_egy_fel_tom('szerz_tagvkat',$tmp_rmod[0],'szerz_tagvkat_id',$tomblast[0]['szerz_tagvkat_id']);
 }
 
 mysqli_commit($GLOBALS['mysqli']);
 mysqli_autocommit($GLOBALS['mysqli'],true);
 
 echo 'ok$;$';
 admin_szerz_tagvkat_mod();
 
}else{
 echo 'adathiány';
}
}

?>
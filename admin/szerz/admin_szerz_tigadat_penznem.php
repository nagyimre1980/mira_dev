<?php

function admin_szerz_tigadat_penznem(){
echo 'ok$;$';

if(!isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']))
	$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']=(int) date('Y');

admin_szerz_penznem_urlap();
admin_szerz_tigadatpenznem_kereses();
echo '<div id="admin_uj_tigadatpenznem_list_keres_tal" style="overflow-x:auto">';
admin_tigadatpenznem_user_list();
echo '</div>';
}

function admin_szerz_penznem_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új devizanem:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Devizanem kódja *';
echo '<td>';
echo '<input id="admin_ujpenznem_penznem" maxlength="3" style="width:50px" type="text">';
echo '</tr>';

echo '<tr>';
echo '<td>Devizanem neve *';
echo '<td>';
echo '<input id="admin_ujpenznem_penznem_nev" maxlength="100" style="width:120px" type="text">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujpenznem_submit" onclick="admin_ujpenznem()" value="Új devizanem felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_tigadatpenznemlist_keres(){
if(isset($_POST['penznem']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']=$_POST['penznem'];
if(isset($_POST['ev']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']=$_POST['ev'];
echo "ok$;$";
admin_tigadatpenznem_user_list();
}

function admin_szerz_tigadatpenznem_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']!=""))
 $ker_penznem=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem'];
else $ker_penznem="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']!=""))
 $ker_ev=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev'];
else $ker_ev=(int) date('Y');

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_tigadatsapszamlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Devizanem kódja';
echo '<td>';
echo '<input onkeyup="admin_tigadatpenznemlist_keres(\'tallep_elso\',\'\')" value="'.$ker_penznem.'" id="admin_tigadatpenznemlist_keres_penznem" maxlength="3" style="width:50px" type="text">';

echo '<td>Év';
echo '<td>';
echo '<select onchange="admin_tigadatpenznemlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatpenznemlist_keres_ev" class="select3" style="width:60px">';
$startYear = (int) date('Y');
$endYear = 2024;
for ($ev = $startYear; $ev >= $endYear; $ev--) {
    echo "<option value='".$ev."'";
	if($ker_ev==$ev) echo ' selected';
	echo ">".$ev;
}
echo '</select>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tigadatpenznem_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatpenznem_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Módosítás</b>';

//if(is_array($tomb)){

echo '<table id="admin_tigadatpenznemlist_table" class="table_emre_kek">';
echo '<thead><tr>';
echo '<th>';
//Első cell üres

if(is_array($tomb)){
foreach($tomb as $penznem => $ert){
 echo '<th>';
 echo $penznem;
 echo '<br><input onkeyup="admin_modpenznem_nevment(\''.$penznem.'\')" id="admin_modelsztipus_tipusnev_'.$penznem.'" value="'.$ert['nev'].'" maxlength="100" style="width:120px" type="text">';
}
}

echo '</tr></thead><tbody>';

admin_tigadatpenznem_user_list_tal($tomb);

echo '</tbody></table>';

//}
echo '</div>';

}

function admin_tigadatpenznem_user_list_tal($tomb){
$ev=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev'];

if($ev==(int) date('Y')){
$startMonth = (int) date('n'); // Aktuális hónap (1-12)
}else{
 $startMonth=12;
}
for ($ho = $startMonth; $ho >= 1; $ho--) {
    echo '<tr>';
    echo '<td>';
	echo $ev;
	echo ' ';
	echo admin_penznem_hoki($ho);
	
	if(is_array($tomb)){
	foreach($tomb as $penznem => $ert){
		echo '<td class="ttooltip" title="'.$penznem.' - '.$ev.' '.admin_penznem_hoki($ho).'">';
		if($penznem!='HUF'){
		if(isset($ert['arfolyam'][$ev.'-'.$ho])){
			$value=str_replace('.',',',$ert['arfolyam'][$ev.'-'.$ho]);
		}else{
			$value='';
		}
		echo '<input onkeyup="admin_modpenznem_arfolyamment(\''.$penznem.'\',\''.$ev.'\',\''.$ho.'\')" id="admin_modpenznem_arfolyam_'.$penznem.'_'.$ev.'-'.$ho.'" value="'.$value.'" maxlength="7" style="width:60px" class="number_penz_2tizedes" type="text">';
		}
	}
	}
	echo '</tr>';
}

}

function admin_penznem_hoki($ho){
switch($ho){
 case'1':$ret='január';break;
 case'2':$ret='február';break;
 case'3':$ret='március';break;
 case'4':$ret='április';break;
 case'5':$ret='május';break;
 case'6':$ret='június';break;
 case'7':$ret='július';break;
 case'8':$ret='augusztus';break;
 case'9':$ret='szeptember';break;
 case'10':$ret='október';break;
 case'11':$ret='november';break;
 case'12':$ret='december';break;
 default:$ret=$ho;break;
}
return $ret;
}

function admin_ujpenznem_ment(){
if((!isset($_POST['penznem']))or(
(isset($_POST['penznem'])and
($_POST['penznem']==""))
)){
 echo "nook$;$"."Devizanem kódja megadása kötelező!";
 exit;
}

if((!isset($_POST['penznem_nev']))or(
(isset($_POST['penznem_nev'])and
($_POST['penznem_nev']==""))
)){
 echo "nook$;$"."Devizanem neve megadása kötelező!";
 exit;
}

//2: Van-e Ilyen Elszámolás típusa
$penznem=keres_mit1_mit1('szerz_penznem','penznem',$_POST['penznem'],'penznem');
if(is_array($penznem)){
 echo 'nook$;$Hiba! Van már ilyen Devizanem kódja!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['penznem']=$_POST['penznem'];
 $tmp_bk[0]['penznem_nev']=$_POST['penznem_nev'];
 be_visz_insert('szerz_penznem',$tmp_bk);

 echo "ok$;$";
}
}

function admin_modpenznem_nevment(){
if(
 (isset($_POST['penznem']))and
 (isset($_POST['penznem_nev']))and
 ($_POST['penznem']!='')and
 ($_POST['penznem_nev']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['penznem_nev']=$_POST['penznem_nev'];
 mod_egy_fel_tom('szerz_penznem',$tmp_mod[0],'penznem',$_POST['penznem']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modpenznem_arfolyamment(){
if(
 (isset($_POST['penznem']))and
 (isset($_POST['arfolyam_date']))and
 (isset($_POST['arfolyam_ert']))and
 ($_POST['penznem']!='')and
 ($_POST['arfolyam_date']!='')and
 ($_POST['arfolyam_ert']!='')
){
 $tmp_bk=array();
 $tmp_bk[0]['penznem']=$_POST['penznem'];
 $tmp_bk[0]['arfolyam_date']=$_POST['arfolyam_date'];
 $tmp_bk[0]['arfolyam_ert']=$_POST['arfolyam_ert'];
 be_visz_insert('szerz_penznem_arfolyam',$tmp_bk);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>
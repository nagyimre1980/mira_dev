<?php

function admin_kpi_osszekap(){
echo 'ok$;$';
admin_szerz_kpiosszekap_kereses();
echo '<div id="admin_uj_kpiosszekap_list_keres_tal" style="overflow-x:auto">';
admin_kpiosszekap_user_list();
echo '</div>';
}

function admin_kpiosszekaplist_keres(){
if(isset($_POST['mire1']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire1']=$_POST['mire1'];
if(isset($_POST['mit1']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1']=$_POST['mit1'];
if(isset($_POST['mit1_value']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1_value']=$_POST['mit1_value'];
if(isset($_POST['mire2']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire2']=$_POST['mire2'];
if(isset($_POST['mit2']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2']=$_POST['mit2'];
if(isset($_POST['mit2_value']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2_value']=$_POST['mit2_value'];
if(isset($_POST['mire3']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire3']=$_POST['mire3'];
if(isset($_POST['mit3']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3']=$_POST['mit3'];
if(isset($_POST['mit3_value']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3_value']=$_POST['mit3_value'];

if(isset($_POST['mire4']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire4']=$_POST['mire4'];
if(isset($_POST['mit4']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4']=$_POST['mit4'];
if(isset($_POST['mit4_value']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4_value']=$_POST['mit4_value'];

if(isset($_POST['mire5']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire5']=$_POST['mire5'];
if(isset($_POST['mit5']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5']=$_POST['mit5'];
if(isset($_POST['mit5_value']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5_value']=$_POST['mit5_value'];


if(isset($_POST['szerz_tetel_id']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']=$_POST['szerz_tetel_id'];
if(isset($_POST['szerzmodszam']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerzmodszam']=$_POST['szerzmodszam'];

if(isset($_POST['ellenorizendo']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo']=$_POST['ellenorizendo'];

if(isset($_POST['kpitipus_allapot']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus_allapot']=$_POST['kpitipus_allapot'];
if(isset($_POST['kpi_nemrelevans']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']=$_POST['kpi_nemrelevans'];
if(isset($_POST['kpi_tipus']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']=$_POST['kpi_tipus'];
if(isset($_POST['akt']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']=$_POST['akt'];

if(isset($_POST['szerz_tetel_szerz_date_hatalybelep_tol']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']=$_POST['szerz_tetel_szerz_date_hatalybelep_tol'];
if(isset($_POST['szerz_tetel_szerz_date_hatalybelep_ig']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']=$_POST['szerz_tetel_szerz_date_hatalybelep_ig'];

if(isset($_POST['szerz_tetel_szolg_kezd_date_tol']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']=$_POST['szerz_tetel_szolg_kezd_date_tol'];
if(isset($_POST['szerz_tetel_szolg_kezd_date_ig']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']=$_POST['szerz_tetel_szolg_kezd_date_ig'];

if(isset($_POST['szerz_tetel_szerz_tetel_alair_date_tol']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']=$_POST['szerz_tetel_szerz_tetel_alair_date_tol'];
if(isset($_POST['szerz_tetel_szerz_tetel_alair_date_ig']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']=$_POST['szerz_tetel_szerz_tetel_alair_date_ig'];

if(isset($_POST['szerz_tetel_szolg_mod_date_tol']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']=$_POST['szerz_tetel_szolg_mod_date_tol'];
if(isset($_POST['szerz_tetel_szolg_mod_date_ig']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']=$_POST['szerz_tetel_szolg_mod_date_ig'];

echo "ok$;$";
admin_kpiosszekap_user_list();
}

function admin_szerz_kpiosszekap_kereses(){
$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']='';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']!=""))
 $ker_szerz_tetel_id=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id'];
else $ker_szerz_tetel_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ker_szerz_mod_szam']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ker_szerz_mod_szam']!=""))
 $ker_szerz_mod_szam=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ker_szerz_mod_szam'];
else $ker_szerz_mod_szam="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']!=""))
 $ker_akt=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt'];
else $ker_akt="1";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']!=""))
 $ker_nemrelevans=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans'];
else $ker_nemrelevans="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus']!=""))
 $ker_kpitipus=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus'];
else $ker_kpitipus="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire1']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire1']!=""))
 $ker_mire1=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire1'];
else $ker_mire1="tagv_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1']!=""))
 $ker_mit1=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1'];
else $ker_mit1="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1_value']!=""))
 $ker_mit1_value=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit1_value'];
else $ker_mit1_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire2']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire2']!=""))
 $ker_mire2=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire2'];
else $ker_mire2="tagv_kat";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2']!=""))
 $ker_mit2=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2'];
else $ker_mit2="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2_value']!=""))
 $ker_mit2_value=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit2_value'];
else $ker_mit2_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire3']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire3']!=""))
 $ker_mire3=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire3'];
else $ker_mire3="szolg_csop";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3']!=""))
 $ker_mit3=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3'];
else $ker_mit3="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3_value']!=""))
 $ker_mit3_value=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit3_value'];
else $ker_mit3_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire4']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire4']!=""))
 $ker_mire4=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire4'];
else $ker_mire4="szolg_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4']!=""))
 $ker_mit4=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4'];
else $ker_mit4="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4_value']!=""))
 $ker_mit4_value=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit4_value'];
else $ker_mit4_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire5']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire5']!=""))
 $ker_mire5=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire5'];
else $ker_mire5="kpi_szolg_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5']!=""))
 $ker_mit5=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5'];
else $ker_mit5="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5_value']!=""))
 $ker_mit5_value=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit5_value'];
else $ker_mit5_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo']!=""))
 $ker_ellenorizendo=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo'];
else $ker_ellenorizendo="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']!=""))
 $ker_szerz_tetel_szerz_date_hatalybelep_tol=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol'];
else $ker_szerz_tetel_szerz_date_hatalybelep_tol="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']!=""))
 $ker_szerz_tetel_szerz_date_hatalybelep_ig=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig'];
else $ker_szerz_tetel_szerz_date_hatalybelep_ig="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']!=""))
 $ker_szerz_tetel_szolg_kezd_date_tol=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol'];
else $ker_szerz_tetel_szolg_kezd_date_tol="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']!=""))
 $ker_szerz_tetel_szolg_kezd_date_ig=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig'];
else $ker_szerz_tetel_szolg_kezd_date_ig="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']!=""))
 $ker_szerz_tetel_szerz_tetel_alair_date_tol=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol'];
else $ker_szerz_tetel_szerz_tetel_alair_date_tol="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']!=""))
 $ker_szerz_tetel_szerz_tetel_alair_date_ig=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig'];
else $ker_szerz_tetel_szerz_tetel_alair_date_ig="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']!=""))
 $ker_szerz_tetel_szolg_mod_date_tol=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol'];
else $ker_szerz_tetel_szolg_mod_date_tol="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']!=""))
 $ker_szerz_tetel_szolg_mod_date_ig=$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig'];
else $ker_szerz_tetel_szolg_mod_date_ig="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_kpiosszekaplist_table_ker" class="table_emre_kek">';

echo '<tbody>';

//1.sor - eleje
echo '<tr>';
echo '<td>Szolgáltatás ID';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_id.'" id="admin_kpiosszekaplist_keres_szerztetelid" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" style="width:40px" type="text">';

echo '<td>KPI típus állapot';
echo '<td>';
echo '<select id="admin_kpiosszekaplist_keres_kpitipus_allapot" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="select3" style="width:130px">';
echo '<option value="all"';
if($ker_kpitipus=='all')echo ' selected';
echo '>Összes';

echo '<option value="1"';
if($ker_kpitipus=='1')echo ' selected';
echo '>KPI típussal';//KPI típussal rendelkező szerződések

echo '<option value="0"';
if($ker_kpitipus=='0')echo ' selected';
echo '>KPI típus nélkül';

echo '</select>';

admin_szerz_kpiosszekap_kereses_altki('1',$ker_mire1,$ker_mit1,$ker_mit1_value);

echo '<td>Szerződés hatályba lépése';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_szerz_date_hatalybelep_tol.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_tol" date_ig_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_ig" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_tol2" datemod="hu5" data-maxdate="" style="width:75px" type="text">';
echo ' - ';
echo '<input value="'.$ker_szerz_tetel_szerz_date_hatalybelep_ig.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_ig" date_tol_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_tol" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_ig2" datemod="hu5" data-mindate="" style="width:75px" type="text">';


echo '</tr>';
//1.sor - vége

//2.sor - eleje
echo '<tr>';
echo '<td><label for="admin_kpiosszekaplist_keres_akt">Aktuális szerződések</label>';
echo '<td>';
if($ker_akt=='1') $akt_prop=' checked';
else $akt_prop='';
echo '<input'.$akt_prop.' onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" id="admin_kpiosszekaplist_keres_akt" type="checkbox">';

echo '<td>KPI nem releváns';
echo '<td>';
echo '<select id="admin_kpiosszekaplist_keres_nemrelevans" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="select3" style="width:130px">';
echo '<option value="all"';
if($ker_nemrelevans=='all')echo ' selected';
echo '>Összes';

echo '<option value="0"';
if($ker_nemrelevans=='0')echo ' selected';
echo '>KPI releváns';

echo '<option value="1"';
if($ker_nemrelevans=='1')echo ' selected';
echo '>KPI nem releváns';

echo '</select>';

admin_szerz_kpiosszekap_kereses_altki('2',$ker_mire2,$ker_mit2,$ker_mit2_value);

echo '<td>';
echo 'Szolgáltásnyújtás megkezdése';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_szolg_kezd_date_tol.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_tol" date_ig_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_ig" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_tol2" datemod="hu5" data-maxdate="" style="width:75px" type="text">';
echo ' - ';
echo '<input value="'.$ker_szerz_tetel_szolg_kezd_date_ig.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_ig" date_tol_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_tol" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_ig2" datemod="hu5" data-mindate="" style="width:75px" type="text">';


echo '</tr>';
//2.sor - vége

//3.sor - eleje
echo '<tr>';

echo '<td>Ellenőrizendő';
echo '<td>';
if($ker_ellenorizendo=='1')$ck_ell=' checked';
else $ck_ell='';
echo '<input'.$ck_ell.' onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" id="admin_kpiosszekaplist_keres_ck" type="checkbox">';

echo '<td>';
echo 'KPI típus';
echo '<td>';
	echo '<select name="admin_kpiosszekaplist_keres_kpitipus" multiple id="admin_kpiosszekaplist_keres_kpitipus" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="select4_multiajax_search" style="width:130px">';
	
	echo '<option only_radio_delete_fo=fo value="all" selected>Összes';
	$tomb_kpi=keres_all_order('kpi_tipus','kpi_tipus_kpi','asc');
	if(is_array($tomb_kpi)){
		foreach($tomb_kpi as $ert_kpi){
		 $title='<b>Mutatószám megnevezése</b>:<br>'.$ert_kpi['kpi_tipus_mutmegn'];
		 $title.='<br><br><b>Mutatószám számítás módja</b>:<br>'.$ert_kpi['kpi_tipus_mutszmod'];
		 echo '<option title="'.$title.'" only_radio_delete_fo=al value="'.$ert_kpi['kpi_tipus_kpi'].'">'.$ert_kpi['kpi_tipus_kpi'];	
		}
	}
	
	echo '</select>';

//echo '<td>';
//echo 'Szolgáltatás csoport';
admin_szerz_kpiosszekap_kereses_altki('3',$ker_mire3,$ker_mit3,$ker_mit3_value);

echo '<td>';
echo 'Szerződés aláírás dátuma';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_szerz_tetel_alair_date_tol.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_tol" date_ig_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_ig" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_tol2" datemod="hu5" data-maxdate="" style="width:75px" type="text">';
echo ' - ';
echo '<input value="'.$ker_szerz_tetel_szerz_tetel_alair_date_ig.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_ig" date_tol_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_tol" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_ig2" datemod="hu5" data-mindate="" style="width:75px" type="text">';


echo '</tr>';
//3.sor - vége

//4.sor - eleje
echo '<tr>';

echo '<td>';
echo 'Szerz. módosítás száma';
echo '<td>';
echo '<input value="'.$ker_szerz_mod_szam.'" id="admin_kpiosszekaplist_keres_szerzmodszam" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" style="width:40px" type="text">';

//echo '<td>KPI szolgáltatás kód';
admin_szerz_kpiosszekap_kereses_altki('5',$ker_mire5,$ker_mit5,$ker_mit5_value);

//echo '<td>Szolgáltatás kód';
admin_szerz_kpiosszekap_kereses_altki('4',$ker_mire4,$ker_mit4,$ker_mit4_value);

echo '<td>Szerződésmódosítás hatályba lépése';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_szolg_mod_date_tol.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_tol" date_ig_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_ig" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_tol2" datemod="hu5" data-maxdate="" style="width:75px" type="text">';
echo ' - ';
echo '<input value="'.$ker_szerz_tetel_szolg_mod_date_ig.'" id="admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_ig" date_tol_mezo="admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_tol" onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" onkeyup="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" class="date_ig2" datemod="hu5" data-mindate="" style="width:75px" type="text">';


echo '</tr>';
//4.sor - vége


echo '</tbody>';
echo '</table></div>';

}

function admin_szerz_kpiosszekap_kereses_altki($hanyas,$ker_mire,$ker_mit,$ker_mit_value){
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_kpiosszekaplist_keres_mit'.$hanyas.'\',\'all\');admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" id="admin_kpiosszekaplist_keres_mire'.$hanyas.'" class="select3" style="width:151px">';//171

echo '<option value="tagv_kod"';
if($ker_mire=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="tagv_kat"';
if($ker_mire=='tagv_kat') echo ' selected';
echo '>Társaság kategória';

echo '<option value="szerz_tipus"';
if($ker_mire=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="szolg_csop"';
if($ker_mire=='szolg_csop') echo ' selected';
echo '>Szolgáltatás csoport';

echo '<option value="kpi_szolg_kod"';
if($ker_mire=='kpi_szolg_kod') echo ' selected';
echo '>KPI Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire=='szolg_erv') echo ' selected';
echo '>Szolgáltatás megszünés dátuma';

echo '<option value="integ_erintett"';
if($ker_mire=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="penznem"';
if($ker_mire=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';
echo '<td>';
echo '<select onchange="admin_kpiosszekaplist_keres_proc(\'tallep_elso\',\'\')" id="admin_kpiosszekaplist_keres_mit'.$hanyas.'" class="select2_ajax" csonkolt=1 mit_id="admin_kpiosszekaplist_keres_mire'.$hanyas.'" mod="admin_szolgkapadat_ker1" style="width:242px">';//311
if($ker_mit!=''and($ker_mit!='all'))echo '<option value="'.$ker_mit.'">'.$ker_mit_value;
else echo '<option value="all">Összes';
echo '</select>';
}

function admin_kpiosszekap_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpiosszekap_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Szerződés módosítás</b>';//<br>

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';
echo '<table id="admin_kpiosszekaplist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Alapdat<br>ID ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

//$order_mezo="szerz_tetel.szerz_tetel_id";
//echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
//echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);
echo '<th>Szolgáltatás<br>ID';

echo '<th>KPI<br>nem releváns';

echo '<th>KPI típus';

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

//echo '<th>Társasági kategória';
$order_mezo="szerz_tagvkat.szerz_tagvkat_kat";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Társasági kategória ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_date_hatalybelep";
echo "<th title='Szerződés hatályba lépésének időpontja' style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés<br>hatályba lépése ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

//Szolgáltásnyújtás megkezdésének időpontja
//szerz_tetel_szolg_kezd_date
$order_mezo="szerz_tetel.szerz_tetel_szolg_kezd_date";
echo "<th title='Szolgáltásnyújtás megkezdésének időpontja' style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltásnyújtás<br>megkezdése ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

//Szerződés aláírás dátuma
//szerz_tetel_alair_date
$order_mezo="szerz_tetel_adat.szerz_tetel_alair_date";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés<br>aláírás dátuma ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

//Szerződésmódosítás hatályba lépésének dátuma
//szerz_tetel_szolg_mod_date
$order_mezo="szerz_tetel_adat.szerz_tetel_szolg_mod_date";
echo "<th title='Szerződésmódosítás hatályba lépésének dátuma' style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződésmódosítás<br>hatályba lépése ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);


/*
$order_mezo="szerz.szerz_sapszam";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>SAP szerződésszám ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);
*/

/*
$order_mezo="szerz_tetel_adat.szerz_tetel_modszam";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Módosítás ID ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);
*/

echo '<th>Szolgáltatás<br>megszünés dátuma';

$order_mezo="szerz_tetel_adat.szerz_tetel_modszam_kezi";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés<br>módosítás száma ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.szerz_csop_nev";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás csoport ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

/*
$order_mezo="szerz_tetel_adat.szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szolg_kod_nev";
echo "<th style='width:40px' class='link' onclick='admin_kpiosszekaplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás neve ";
echo tabl_nyilak('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod',$order_mezo);
*/

echo '<th>Megjegyzés';

echo '</tr></thead><tbody>';

admin_kpiosszekap_user_list_tal($tomb);

echo '</tbody></table></div>';
//echo '</div>';
table_alja_lepeget('0',$th,'admin_kpiosszekap','admin_kpiosszekaplist_keres_talszam','admin_kpiosszekaplist_keres_proc');

}

function admin_kpiosszekap_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr id="tr_admin_kpiosszekap_user_list_tal_'.$i.'">';
 
 echo '<td>';
 echo $ert['szerz_id'];
 
 echo '<td id="admin_modkpiosszekap_tdsor_'.$i.'">';
 $tomb_szerz_tetel_id=explode(',',$ert['szerz_tetel_id_tomeges']);
 if(is_array($tomb_szerz_tetel_id)){
 foreach($tomb_szerz_tetel_id as $ert_id){
  $tomb_tmp_idek=explode('-',$ert_id);
  echo '<span class="linkm_tooltip" title="Módosítás ID: '.$tomb_tmp_idek[2].'">';
  echo $tomb_tmp_idek[0];
  echo '</span>';
  echo ' <img onclick="admin_szolgkapadat_reszlet(\''.$tomb_tmp_idek[0].'\',\''.$tomb_tmp_idek[1].'\')" title="Részletezés" class="linkimg_tooltip img_resz" src="image/details_18_1.png">';
  }
 }
 
 //KPI nem releváns
 echo '<td align=center>';
 if($ert['kpi_nemrelevans']=='1')$kpi_nemrelevans_ck=' checked';
 else $kpi_nemrelevans_ck='';
 //title="<b>Figyelem</b>: Nem releváns beállítása töröl minden KPI típus beállítást"
 echo '<input'.$kpi_nemrelevans_ck.' onclick="admin_kpiosszekap_nemrelevans(\''.$ert['szerz_id'].'\',\''.$ert['szerz_csop_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\',\''.$i.'\')" id="admin_modkpiosszekap_nemrelevans_'.$i.'" type="checkbox">';
 
 //KPI típus
 echo '<td>';
 if($ert['kpi_nemrelevans']!='1'){
 if($ert['kpi_osszekapcs_ck']=='1'){
	 $kpi_color=' style="color:red"';
 }else $kpi_color='';
 echo '<span'.$kpi_color.' onclick="admin_kpiosszekap_kpiadd(\''.$ert['szerz_id'].'\',\''.$ert['szerz_csop_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\',\''.$i.'\',\''.sizeof($tomb_szerz_tetel_id).'\')" class="link">';
  if($ert['kpi_osszekapcs_ck']=='1'){
	 echo 'Ellenőrizendő: ';
  }
  
  if($ert['kpi_tipus_str']==''){
   echo 'Hozzáadás';
  }else{
   echo $ert['kpi_tipus_str'];
  }
 echo '</span>';
 }
 
 //tagv
 $tilte='<b>'.$ert['tagv_kod_nev'].'</b>';
 $tilte.='<br><b>Szerződéses alapadat ID:</b> '.$ert['szerz_id'];
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte.='<br><b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>';
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].'</span>';
 
 echo '<td>';
 echo kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
 
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']); 
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_kezd_date_uj']);  
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_alair_date_uj']); 
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_mod_date_uj']); 

 $title_msz='';
 $title_table='<table border=1 class=\'table_emre_kek\'>';
 if($ert['szerz_tetel_vege_date_uj']!=''){
  $title_msz=$title_table."<tr><td><b>Szolgáltatás megszünése - vége dátum</b>:<td>".kidate_format_ev($ert['szerz_tetel_vege_date_uj']).'</tr>';
 }
 
 if($ert['szerz_tetel_szolg_origveg_date_uj']!=''){
  if($title_msz=='')$title_msz=$title_table;
  $title_msz.="<tr><td><b>Szerződés időtartam eredeti (határozott esetén)</b>:<td>".kidate_format_ev($ert['szerz_tetel_szolg_origveg_date_uj']).'</tr>';
 }
 
 if($ert['szerz_tetel_szolg_aktveg_date_uj']!=''){
  if($title_msz=='')$title_msz=$title_table;
  $title_msz.="<tr><td><b>Szerződés időtartam aktuális (határozott esetén)</b>:<td>".kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date_uj']).'</tr>';
 }
 if($title_msz!='')$title_msz.='</table>';
 
 echo '<td>';
 // 1. Betesszük a dátumokat egy tömbbe
 $datumok = [
    $ert['szerz_tetel_vege_date_uj'],
    $ert['szerz_tetel_szolg_origveg_date_uj'],
    $ert['szerz_tetel_szolg_aktveg_date_uj']
 ];
 // 2. Kiszűrjük az üres/NULL értékeket
 $szurt_datumok = array_filter($datumok);
 // 3. Ha maradt legalább egy érvényes dátum, kiírjuk a legkisebbet, különben semmit ('')
 echo '<span title="'.$title_msz.'" class="linkm_tooltip">';
 echo $szurt_datumok ? kidate_format_ev(min($szurt_datumok)) : '';
 echo '</span>';

 echo '<td>';
 echo $ert['szerz_tetel_modszam_kezi'];
 
 echo '<td>';
 echo $ert['szerz_csop_nev'];
 
 /*
 echo '<td>';
 if($ert['kpi_szolg_kod']!='')
  echo $ert['szolg_kod'].' - '.$ert['kpi_szolg_kod'];
 else
  echo $ert['szolg_kod'];
 
 echo '<td>';
 echo $ert['szolg_kod_nev'];
 */

 //Megjegyzés
 echo '<td>';
 echo '<textarea maxlength=255 onkeyup="admin_modkpiosszekap_ment(\''.$ert['szerz_id'].'\',\''.$ert['szerz_csop_id'].'\',\''.$ert['szerz_tetel_modszam_kezi'].'\',\''.$i.'\')" id="admin_modkpiosszekap_megj_'.$i.'" rows="2" style="width:230px">';
 echo $ert['kpi_megj'];
 echo '</textarea>';

 echo '</tr>';
}
}
}
}

function admin_modkpiosszekap_ment_proc(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['szerz_tetel_modszam_kezi']))and
 (isset($_POST['megj']))and
 ($_POST['szerz_id']!='')and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['szerz_tetel_modszam_kezi']!='')
 ){
  
  //szerz_kpi_id kitalálása, azaz a szerz_kpi létezik-e már!
  $szerz_kpi_id=keres_mit3_mit1_csak_ertek('szerz_kpi','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi'],'szerz_kpi_id');
  
  if($szerz_kpi_id!=''){
  $tmp_mod=array();
  $tmp_mod[0]['kpi_megj']=$_POST['megj'];
  mod_egy_fel_tom('szerz_kpi',$tmp_mod[0],'szerz_kpi_id',$szerz_kpi_id);
  echo 'ok$;$';
  }else{
	$tmp_bk_alap=array();
	$tmp_bk_alap[0]['szerz_id']=$_POST['szerz_id'];
	$tmp_bk_alap[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
	$tmp_bk_alap[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
	$tmp_bk_alap[0]['kpi_megj']=$_POST['megj'];
	be_visz_insert('szerz_kpi',$tmp_bk_alap);
  }
 }else{
  echo 'Adathiány';
 }
}

function admin_kpiosszekap_nemrelevans(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['szerz_tetel_modszam_kezi']))and
 (isset($_POST['kpi_nemrelevans']))and
 ($_POST['szerz_id']!='')and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['szerz_tetel_modszam_kezi']!='')and
 (
  ($_POST['kpi_nemrelevans']=='0')or
  ($_POST['kpi_nemrelevans']=='1')
 )
){

mysqli_autocommit($GLOBALS['mysqli'],false);

//szerz_kpi_id kitalálása, azaz a szerz_kpi létezik-e már!
$szerz_kpi_id=keres_mit3_mit1_csak_ertek('szerz_kpi','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi'],'szerz_kpi_id');

if($szerz_kpi_id==''){
	$tmp_bk_alap=array();
	$tmp_bk_alap[0]['szerz_id']=$_POST['szerz_id'];
	$tmp_bk_alap[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
	$tmp_bk_alap[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
	be_visz_insert('szerz_kpi',$tmp_bk_alap);
}else{

 $tmp_mod=array();
 if($_POST['kpi_nemrelevans']=='1')
  $tmp_mod[0]['kpi_nemrelevans']='1';
 else $tmp_mod[0]['kpi_nemrelevans']=null;
 mod_egy_fel_tom3('szerz_kpi',$tmp_mod[0],'szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi']);
}


//KPI törlése
if($_POST['kpi_nemrelevans']=='1'){
 torles('szerz_kpi_osszekapcs','szerz_kpi_id',$szerz_kpi_id);
}

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_kpiosszekap_kpiadd(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['szerz_tetel_modszam_kezi']))and
 (isset($_POST['reszl_html']))and
 ($_POST['szerz_id']!='')and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['szerz_tetel_modszam_kezi']!='')and
 ($_POST['reszl_html']!='')
){
 echo 'ok$;$';
 echo 'KPI típus hozzárendelése '.$_POST['reszl_html'];
 if($_POST['darab']=='1')
  echo ' szerződéshez';
 else echo ' szerződésekhez';

admin_kpiosszekap_kpiadd_tipusok($_POST['szerz_id'],$_POST['szerz_csop_id'],$_POST['szerz_tetel_modszam_kezi']);

$kell_e_ellenorizni=keres_mit3_mit1_csak_ertek('szerz_kpi','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi'],'kpi_osszekapcs_ck');

if($kell_e_ellenorizni=='1'){
 admin_kpiosszekap_kpiadd_ell($_POST['szerz_id'],$_POST['szerz_csop_id'],$_POST['szerz_tetel_modszam_kezi']);
}

}else{
 echo 'adathiány';
}
}

function admin_kpiosszekap_kpiadd_ell($szerz_id,$szerz_csop_id,$szerz_tetel_modszam_kezi){
 echo '<div id="admin_kpiosszekap_kpiadd_ell_submit" style="margin-top:10px"><input onclick="admin_kpiosszekaplist_kpiadd_ck(\''.$szerz_id.'\',\''.$szerz_csop_id.'\',\''.$szerz_tetel_modszam_kezi.'\')" value="Ellenőrizve státusz lementése" class="submit2" type="submit"></div>';
}

function admin_kpiosszekap_kpiadd_tipusok($szerz_id,$szerz_csop_id,$szerz_tetel_modszam_kezi){
//echo 'szerz_tetel_adat_id: '.$szerz_tetel_adat_id;
echo '<div style="margin-top:10px">';
$tomb=keres_kapiadd_kpi_tipusok($szerz_csop_id);
$tomb_van=keres_kapiadd_kpi_tipusok_meglevok($szerz_id,$szerz_csop_id,$szerz_tetel_modszam_kezi);

if(is_array($tomb)){
 echo '<table id="admin_kpiosszekaplist_kpiadd_table" class="table_emre_kek">';
 echo '<thead><tr>';
 echo '<th>KPI típus';
 echo '<th>Hozzárendelés';
 echo '</tr></thead><tbody>';
 foreach($tomb as $ert){
  echo '<tr>';
  
  echo '<td>';
  $title='<b>Mutatószám megnevezése</b>:<br>'.$ert['kpi_tipus_mutmegn'];
  $title.='<br><br><b>Mutatószám számítás módja</b>:<br>'.$ert['kpi_tipus_mutszmod'];
  echo '<label title="'.$title.'" class="linkm_tooltip" for="admin_kpiosszekaplist_kpiadd_ck_'.$ert['kpi_tipus_id'].'">';
  echo $ert['kpi_tipus_kpi'];
  echo '</label>';
  
  echo '<td align=center>';
  if(isset($tomb_van[$ert['kpi_tipus_id']]))$ck=' checked';
  else $ck='';
  echo '<input'.$ck.' onchange="admin_kpiosszekaplist_kpiadd_change(\''.$szerz_id.'\',\''.$szerz_csop_id.'\',\''.$szerz_tetel_modszam_kezi.'\',\''.$ert['kpi_tipus_id'].'\')" id="admin_kpiosszekaplist_kpiadd_ck_'.$ert['kpi_tipus_id'].'" type="checkbox">';
  
  echo '</tr>';
 }
 echo '</tbody></table>';
}else{
 $szerz_csop_nev=keres_mit1_mit1_csak_ertek('szerz_csop','szerz_csop_id',$_POST['szerz_csop_id'],'szerz_csop_nev');
 echo '<span class="pir_vas">Nincs KPI típus beállítva a '.$szerz_csop_nev.' szolgáltatás csoporthoz</span>';
}

echo '</div>';
}

function admin_kpiosszekaplist_kpiadd_change(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['szerz_tetel_modszam_kezi']))and
 (isset($_POST['kpi_tipus_id']))and
 (isset($_POST['mit']))and
 ($_POST['szerz_id']!='')and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['szerz_tetel_modszam_kezi']!='')and
 ($_POST['kpi_tipus_id']!='')and
 (
  ($_POST['mit']=='0')or
  ($_POST['mit']=='1')
 )
){

//szerz_kpi_id kitalálása, azaz a szerz_kpi létezik-e már!
$szerz_kpi_id=keres_mit3_mit1_csak_ertek('szerz_kpi','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi'],'szerz_kpi_id');

if($_POST['mit']=='1'){//Bepipálás történt
 
 if($szerz_kpi_id==''){//Ha nincs, akkor létre kell hozni
	$tmp_bk_alap=array();
	$tmp_bk_alap[0]['szerz_id']=$_POST['szerz_id'];
	$tmp_bk_alap[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
	$tmp_bk_alap[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
	be_visz_insert('szerz_kpi',$tmp_bk_alap);
	$szerz_kpi_id = mysqli_insert_id($GLOBALS['mysqli']);
 }
  $tmp_bk=array();
  $tmp_bk[0]['szerz_kpi_id']=$szerz_kpi_id;
  $tmp_bk[0]['kpi_tipus_id']=$_POST['kpi_tipus_id'];
  be_visz_insert('szerz_kpi_osszekapcs',$tmp_bk);
 
	
 
}else{//Kipipáltuk
 if($szerz_kpi_id!=''){
  torles2('szerz_kpi_osszekapcs','szerz_kpi_id',$szerz_kpi_id,'kpi_tipus_id',$_POST['kpi_tipus_id']);
 }else{//Ilyen nem lehet, de ha mégis.
	 echo 'Hiba! Nincs szerz_kpi_id';
 }
}
echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_kpiosszekaplist_kpiadd_ck(){
if(
 (isset($_POST['szerz_id']))and
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['szerz_tetel_modszam_kezi']))and
 ($_POST['szerz_id']!='')and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['szerz_tetel_modszam_kezi']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['kpi_osszekapcs_ck']=null;
 mod_egy_fel_tom3('szerz_kpi',$tmp_mod[0],'szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>
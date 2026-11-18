<?php

function riport_ful_ki_tervteny(){

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus1']='teny';
}

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus2'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus2']='terv';
}

echo '<div id="riport_div_tervteny"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

//s1tyle=''
echo "<table id='riport_table_tervteny_1' cellpadding=1 cellspacing=1 class='table_emre'>";

//Adat1
echo '<tr>';
echo '<td colspan=5 style="font-size:18px;font-weight:bold;text-align:center">';
echo 'Adat1';
echo '</tr>';

//Időszak sor - eleje
echo '<tr>';
echo '<th>';
echo 'Időszak';

echo '<th>';
echo 'Év';
echo '<td>';
	echo '<select onchange="riport_tervteny_ev1_change()" id="riport_tervteny_sel_ev1" mod="riport_tervteny_sel_ev1" mit_id="riport_tervteny_sel_tipus1" csonkolt="0" rejt_kereses="1" class="select2_ajax" style="width:120px">';
	echo '<option value="keremv">Kérem válassz';
	echo '</select>';

echo '<th>';
echo 'Hó';
echo '<td style="width:150px">';//name="ice-cream" multiple
	//echo '<select name="riport_tervteny_sel_ho1" multiple id="riport_tervteny_sel_ho1" mod="riport_tervteny_sel_ho1" mit_id="riport_tervteny_sel_tipus1" mit2_id="riport_tervteny_sel_ev1" class="select4_multiajax" style="width:120px">';
	echo '<select onkeyup="riport_tervteny_listupdate1_listle()" style="display:none" name="riport_tervteny_sel_ho1" multiple id="riport_tervteny_sel_ho1" class="select4_multiajax" style="width:150px">';	
	echo '</select>';
echo '</tr>';
//Időszak sor - vége

//Típus - eleje
echo '<tr>';
echo '<th>';
echo 'Típus';
echo '<td colspan=5>';
	echo '<select onchange="riport_tervteny_tipus1_change()" id="riport_tervteny_sel_tipus1" class="select3" style="width:76px">';
	
	//echo '<option value="keremv">Kérem válassz';
	
	echo '<option value="teny"';
	if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus1']=='teny')echo ' selected';
	echo '>Tény';
	
	echo '<option value="terv"';
	if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus1']=='terv')echo ' selected';
	echo '>Terv';
	
	echo '</select>';

//Terv alaptípusok - eleje
echo '<span title="Altípus" class="linkm_tooltip"> ';
echo '<select id="riport_tervteny_sel_tervalaptipus1" mod="riport_tervteny_sel_tervalaptipus1" mit_id="riport_tervteny_sel_ev1" class="select2_ajax" style="display:none;width:150px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</span>';
//Terv alaptípusok - vége

echo '</tr>';
//Típus - vége

//Szervezeti egység - eleje
echo '<tr>';
echo '<th>';
echo 'Szervezeti egység';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_szerv1" multiple id="riport_tervteny_sel_szerv1" class="select4_multiajax_search" style="width:311px">';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Tevékenység';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_proj1" multiple id="riport_tervteny_sel_proj1" class="select4_multiajax_search" style="width:311px">';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Tevékenység kód';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_szolgkod1" multiple id="riport_tervteny_sel_szolgkod1" class="select4_multiajax_search" style="width:311px">';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Társaság';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_tagv1" multiple id="riport_tervteny_sel_tagv1" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Munkavállaló';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_user1" multiple id="riport_tervteny_sel_user1" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Részletesség';
echo '<td colspan=4>';
	echo '<div id="riport_tervteny_sel_reszlet1_div" style="display:none">';
	//s1tyle="display:none"
	echo '<select name="riport_tervteny_sel_reszlet1" id="riport_tervteny_sel_reszlet1" class="select3" style="width:261px">';
	echo '<option value="all">Teljes';
	echo '<option value="szolgkod">Aktuális tevékenység kód összesítés';
	echo '<option value="szerv">Szervezeti összesítés';
	echo '<option value="tagv">Társaság összesítés';
	echo '</select>';
	echo '</div>';

	echo '<div id="riport_tervteny_sel_reszlet1terv_div" style="display:none">';
	//s1tyle="display:none"
	echo '<select name="riport_tervteny_sel_reszlet1terv" id="riport_tervteny_sel_reszlet1terv" class="select3" style="width:261px">';
	echo '<option value="egybe">Időszaki agregálással';
	echo '<option value="kulon">Havi bontással';
	echo '</select>';
	echo '</div>';
echo '</tr>';

echo '</table>';

//Adat2
//s1tyle='margin-top:10px;margin-left:30px;display:inline-block;float:left'
echo "<table id='riport_table_tervteny_2' cellpadding=1 cellspacing=1 class='table_emre'>";

echo '<tr>';
echo '<td colspan=5 style="font-size:18px;font-weight:bold;text-align:center">';
echo 'Adat2';
echo '</tr>';

//Időszak sor - eleje
echo '<tr>';
echo '<th>';
echo 'Időszak';

echo '<th>';
echo 'Év';
echo '<td>';
	echo '<select onchange="riport_tervteny_ev2_change()" id="riport_tervteny_sel_ev2"  mod="riport_tervteny_sel_ev2" mit_id="riport_tervteny_sel_tipus2" csonkolt="0" rejt_kereses="1" class="select2_ajax" style="width:120px">';
	 echo '<option value="keremv">Kérem válassz';
	echo '</select>';

echo '<th>';
echo 'Hó';
echo '<td style="width:150px">';
	//echo '<select  name="riport_tervteny_sel_ho2" multiple id="riport_tervteny_sel_ho2" id="riport_tervteny_sel_ho2" mod="riport_tervteny_sel_ho2" mit_id="riport_tervteny_sel_tipus2" mit2_id="riport_tervteny_sel_ev2" class="select2_ajax" style="width:120px">';
	echo '<select onkeyup="riport_tervteny_listupdate2_listle()" style="display:none" name="riport_tervteny_sel_ho2" multiple id="riport_tervteny_sel_ho2" id="riport_tervteny_sel_ho2" class="select4_multiajax"" style="width:150px">';
	echo '</select>';

echo '</tr>';
//Időszak sor - vége

//Típus - eleje
echo '<tr>';
echo '<th>';
echo 'Típus';
echo '<td colspan=5>';
	echo '<select onchange="riport_tervteny_tipus2_change()" id="riport_tervteny_sel_tipus2" class="select3" style="width:115px">';
	
	echo '<option value="keremv">Kérem válassz';
	
	echo '<option value="teny"';
	if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus2']=='teny')echo ' selected';
	echo '>Tény';
	
	echo '<option value="terv"';
	if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['tipus2']=='terv')echo ' selected';
	echo '>Terv';
	
	echo '</select>';

//Terv alaptípusok - eleje
echo '<span title="Altípus" class="linkm_tooltip"> ';
echo '<select id="riport_tervteny_sel_tervalaptipus2" mod="riport_tervteny_sel_tervalaptipus2" mit_id="riport_tervteny_sel_ev2" class="select2_ajax" style="display:none;width:150px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</span>';
//Terv alaptípusok - vége

echo '</tr>';
//Típus - vége

echo '<tr>';
echo '<th>';
echo 'Szervezeti egység';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_szerv2" multiple id="riport_tervteny_sel_szerv2" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Tevékenység';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_proj2" multiple id="riport_tervteny_sel_proj2" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Tevékenység kód';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_szolgkod2" multiple id="riport_tervteny_sel_szolgkod2" class="select4_multiajax_search" style="width:311px">';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Társaság';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_tagv2" multiple id="riport_tervteny_sel_tagv2" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Munkavállaló';
echo '<td colspan=4>';
	echo '<select style="display:none" name="riport_tervteny_sel_user2" multiple id="riport_tervteny_sel_user2" class="select4_multiajax_search" style="width:311px">';
	echo '<option value="All">Összes';
	echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<th colspan=5>';
echo '</tr>';

echo '</table>';

echo '</div>';

echo '<div id="riport_div_tervteny_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['tervteny']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_leker_terv_teny()" id="riport_leker_terv_teny_submit" value="Terv-tény excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}


?>
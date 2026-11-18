<?php

function admin_ujszolgkapadat_rejt_mutat(){
if(isset($_POST['rejt'])){
 $tmp_mod=array();
 $tmp_mod[0]['admin_szolgkapadatlist_keres_urlaprejt']=$_POST['rejt'];
 mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 //$GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_urlaprejt']=$_POST['rejt'];
 echo 'ok$;$';
}
}

function admin_szerz_szolgkapadat(){
echo 'ok$;$';
admin_szerz_szolgkapadat_urlap();
admin_szerz_szolgkapadat_kereses();
echo '<div id="admin_uj_szolgkapadat_list_keres_tal" style="overflow-x:auto">';
admin_szolgkapadat_user_list();
echo '</div>';
}

function admin_szerz_szolgkapadat_urlap(){
echo '<div class="div_kereshez">';
echo '<span onclick="admin_ujszolgkapadat_rejt_mutat()" class="link_fek_vas">Új szolgáltatáshoz kapcsolódó adatok:</span>';

if(
 (isset($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_urlaprejt']))and
 ($GLOBALS['mira']['user_jog']['admin_szolgkapadatlist_keres_urlaprejt']=='1')
){
 $u_rejt=' style="display:none"';
}else{
 $u_rejt='';
}

echo '<div id="div_admin_szerz_szolgkapadat_urlap"'.$u_rejt.'>';
echo '<table class="table_emre_kek">';

//Sor-1 - eleje
echo '<tr>';
 echo '<td>Szerződéses alapadat';
 echo '<td colspan=5>';
 echo '<select id="admin_ujszolgkapadat_szerzid" class="select2_ajax" csonkolt=1 mod="admin_szerzalapadat_uj" style="width:510px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

 echo '<td>Szerződés módosítás száma';
 echo '<td>';
 echo '<select id="admin_ujszolgkapadat_modszamkezi" class="select2_sima" style="width:45px">';
 for($i=0;$i<=20;$i++)echo '<option value="'.$i.'">'.$i;
 echo '</select>';
 
echo '</tr>';
//Sor-1 - vége

//Sor-1 - eleje
echo '<tr>';
//Cella-1
 echo '<td>Szolgáltatás csoport';
 echo '<td>';
 echo '<select onchange="select2_torles_def(\'admin_ujszolgkapadat_szolgkod\',\'keremv\')" id="admin_ujszolgkapadat_szerzcsopid" class="select2_ajax" csonkolt=0 mod="admin_szolgcsop_uj" style="width:181px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Cella-2
 echo '<td>Szolgáltatás kód';
 echo '<td>';
 //echo '<select id="admin_ujszolgkapadat_szolgkod" class="select2_ajax" csonkolt=0 mod="admin_szolgkod_uj" style="width:160px">';
 echo '<select id="admin_ujszolgkapadat_szolgkod" class="select2_ajax" csonkolt=0 mit_id="admin_ujszolgkapadat_szerzcsopid" mod="admin_szolgkod_csop_uj" style="width:160px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Cella-3
 echo '<td>Utókalkuláció';
 echo '<td>';
 echo '<select id="admin_ujszolgkapadat_tetelutok" class="select3" style="width:120px">';
 echo '<option value="keremv">Kérem válassz';
 echo '<option value="0">Nem';
 echo '<option value="1">Igen';
 echo '</select>';

//Cella-4
 echo '<td>Nettó szerződés díj<br>(eseti/maximális keret)';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_nettoszerzdij" style="width:100px" class="number_penz" maxlength="13" type="text">';
 echo '<label>';
 echo '<input onchange="admin_ujszolgkapadat_nemrelevans_nettoszerzdij()" id="admin_ujszolgkapadat_nettoszerzdij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';
 echo '</tr>';
//Sor-1 - vége

//Sor-2 - eleje
echo '<tr>';

//Cella-1
 echo '<td>Szolgáltásnyújtás megkezdésének<br>időpontja - eredeti';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_szolgkezddate" class="date_tol" style="width:100px" type="text">';
 echo '<label>';
 echo ' Folyamatban';
 echo '<input id="admin_ujszolgkapadat_szolgkezddatefolyamatban" style="vertical-align:bottom" type="checkbox">';
 echo '</label>';

//Cella-2
 echo '<td>Nettó szerződéses havidíj';
 echo '<td>';
 
  echo '<input id="admin_ujszolgkapadat_nettohavidij" style="width:100px;margin-right:5px;vertical-align:top" class="number_penz" maxlength="12" type="text">';//147 széles volt pénznem előtt

  echo '<select id="admin_ujszolgkapadat_nettohavidij_penznem" class="select2_ajax" csonkolt=0 mod="admin_penznem_uj" style="width:55px">';
  echo '<option value="HUF">HUF';
  echo '</select>';

//Cella-3
 echo '<td>Elszámolás típusa';
 echo '<td>';
 echo '<select id="admin_ujszolgkapadat_elsztipusid" class="select2_ajax" csonkolt=1 mod="admin_elsztipus_uj" style="width:120px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Cella-4
 echo '<td>Óradíj';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_oradij" style="width:100px" class="number_penz" maxlength="6" type="text">';
 echo '<label>';
 echo '<input onchange="admin_ujszolgkapadat_nemrelevans_oradij()" id="admin_ujszolgkapadat_oradij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';
echo '</tr>';
//Sor-2 - vége

//Sor-3 - eleje
echo '<tr>';

//Cella-1
 echo '<td>Árajánlat aláírás dátuma';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_arajanlatalair" class="date_tol25" style="width:100px" type="text">';

//Cella-2
 echo '<td>Idei naptári évi éves díj';
 echo '<td>';
  
  echo '<input id="admin_ujszolgkapadat_nettoevesdij" style="width:100px" class="number_penz" maxlength="12" type="text">';//147 széles volt pénznem előtt
 
//Cella-3
 echo '<td>Naturália típus';
 echo '<td>';
 echo '<select id="admin_ujszolgkapadat_naturaliaid" class="select2_ajax" csonkolt=1 mod="admin_nattipus_uj" style="width:120px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Cella-3
 echo '<td>Naturália mennyiség (HAVI)';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_naturaliadarab" class="number_penz_2tizedes" style="width:100px" maxlength="11" type="text">';

echo '</tr>';
//Sor-3 - vége

//Sor-4.0 - eleje
echo '<tr>';

//Cella-1
 echo '<td>Szerződés aláírás dátuma';
 echo '<td>';
 echo '<input id="admin_ujszolgkapadat_alairdate" class="date_tol25" style="width:100px" type="text">';
 
//Cella-2
 echo '<td>Szerződés időtartam vége<br>eredeti (határozott esetén)';
 echo '<td colspan=5>';
 echo '<input id="admin_ujszolgkapadat_szolgorigvegdate" class="date_tol25" style="width:100px" type="text">';

echo '</tr>';
//Sor-4.0 - vége

//Sor-4 - eleje
echo '<tr>';
 //Cella-1
 echo '<td>Tevékenység';
 echo '<td>';
 //echo '<span id="admin_ujszolgkapadat_projektid_szam" onclick="admin_ujszolgkapadat_porjekt_add()" class="link">Tevékenység hozzárendelése</span>';
 echo '<span id="admin_ujszolgkapadat_projektid_szam_uj" onclick="admin_ujszolgkapadat_porjekt_add(\'uj\')" class="link">Tevékenységek hozzáadása</span>';
 echo '<input type=hidden id="admin_ujszolgkapadat_projektid_uj" value="">';
 
 //Cella-2
 echo '<td>Szerződésgazda';
 echo '<td colspan=3>';
 echo '<select id="admin_ujszolgkapadat_usergazdaad" class="select2_ajax" csonkolt=1 mod="admin_usergazda_uj" style="width:399px">';
  echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Cella-2
 echo '<td>Integrációban érintett';
 echo '<td>';
 //echo '<input id="admin_ujszolgkapadat_integerintdate" class="date_tol" style="width:100px" type="text">';
 echo '<select id="admin_ujszolgkapadat_integerintett" class="select3" style="width:120px">';
 echo '<option value="keremv">Kérem válassz';
 echo '<option value="0">Nem';
 echo '<option value="1">Igen';
 echo '</select>';
echo '</tr>';
//Sor-4 - vége

//Sor-5 - eleje
echo '<tr>';
 echo '<td>Általános megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea id="admin_ujszolgkapadat_megj" rows="2" style="width:98%">';
 echo '</textarea>';
echo '</tr>';
//Sor-5 - vége

//Sor-6 - eleje
echo '<tr>';
 echo '<td>TT megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea id="admin_ujszolgkapadat_ttmegj" rows="2" style="width:98%">';
 echo '</textarea>';
echo '</tr>';
//Sor-6 - vége

//Sor-7 - eleje
/*
echo '<tr>';
 echo '<td>Szerződés elérése a hálózaton';
 echo '<td colspan=7>';
 echo '<input id="admin_ujszolgkapadat_tetellink" style="width:98%;margin:0px" maxlength="500" type="text">';
echo '</tr>';
*/
//Sor-7 - vége

echo '<tr><td colspan=8 align=left><input id="admin_ujelsztipus_submit" onclick="admin_ujszolgkapadat()" value="Új szolgaltatáshoz kapcsolódó adatok felvitele" class="submit2" type=submit></tr>';


echo '</table>';
echo '</div>';
echo '</div>';
}

function admin_szolgkapadatlist_keres(){
//if(isset($_POST['szerz_id']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_id']=$_POST['szerz_id'];
if(isset($_POST['mire1']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=$_POST['mire1'];
if(isset($_POST['mit1']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']=$_POST['mit1'];
if(isset($_POST['mit1_value']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1_value']=$_POST['mit1_value'];
if(isset($_POST['mire2']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=$_POST['mire2'];
if(isset($_POST['mit2']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']=$_POST['mit2'];
if(isset($_POST['mit2_value']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2_value']=$_POST['mit2_value'];
if(isset($_POST['mire3']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=$_POST['mire3'];
if(isset($_POST['mit3']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']=$_POST['mit3'];
if(isset($_POST['mit3_value']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3_value']=$_POST['mit3_value'];
if(isset($_POST['szerz_tetel_id']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']=$_POST['szerz_tetel_id'];
if(isset($_POST['akt']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']=$_POST['akt'];
if(isset($_POST['sapszam']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']=$_POST['sapszam'];
echo "ok$;$";
admin_szolgkapadat_user_list();
}

function admin_szerz_szolgkapadat_kereses(){

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']!=""))
 $ker_mire1=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1'];
else $ker_mire1="szerz";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']!=""))
 $ker_mit1=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1'];
else $ker_mit1="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1_value']!=""))
 $ker_mit1_value=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1_value'];
else $ker_mit1_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']!=""))
 $ker_mire2=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2'];
else $ker_mire2="tagv_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']!=""))
 $ker_mit2=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2'];
else $ker_mit2="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2_value']!=""))
 $ker_mit2_value=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2_value'];
else $ker_mit2_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']!=""))
 $ker_mire3=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3'];
else $ker_mire3="szolg_kod";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']!=""))
 $ker_mit3=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3'];
else $ker_mit3="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3_value']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3_value']!=""))
 $ker_mit3_value=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3_value'];
else $ker_mit3_value="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']!=""))
 $ker_szerz_tetel_id=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id'];
else $ker_szerz_tetel_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']!=""))
 $ker_akt=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt'];
else $ker_akt="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']!=""))
 $ker_szerz_sapszam=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam'];
else $ker_szerz_sapszam="";

echo '<div class="div_kereshez"><b>Keresés</b>';//<br>
echo '<table id="admin_szolgkapadatlist_table" class="table_emre_kek">';

echo '<tr>';

echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_szolgkapadatlist_keres_mit1\',\'all\');admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mire1" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire1=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire1=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire1=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire1=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire1=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire1=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire1=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire1=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire1=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire1=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire1=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="folyamatban"';
if($ker_mire1=='folyamatban') echo ' selected';
echo '>Folyamatban';

echo '<option value="penznem"';
if($ker_mire1=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';

echo '<td>';
echo '<select onchange="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mit1" class="select2_ajax" csonkolt=1 mit_id="admin_szolgkapadatlist_keres_mire1" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit1!=''and($ker_mit1!='all'))echo '<option value="'.$ker_mit1.'">'.$ker_mit1_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td>Szolgáltatás ID';
echo '<td>';
echo '<input value="'.$ker_szerz_tetel_id.'" onkeyup="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_szerztetelid" style="width:70px" type="text">';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_szolgkapadatlist_keres_mit2\',\'all\');admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mire2" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire2=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire2=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire2=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire2=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire2=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire2=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire2=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire2=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire2=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire2=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire2=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="folyamatban"';
if($ker_mire2=='folyamatban') echo ' selected';
echo '>Folyamatban';

echo '<option value="penznem"';
if($ker_mire2=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';
echo '<td>';
echo '<select onchange="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mit2" class="select2_ajax" csonkolt=1 mit_id="admin_szolgkapadatlist_keres_mire2" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit2!=''and($ker_mit3!='all'))echo '<option value="'.$ker_mit2.'">'.$ker_mit2_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td><label for="admin_szolgkapadatlist_keres_akt">Aktuális szerződések</label>';// colspan=2
echo '<td>';
if($ker_akt=='1') $akt_prop=' checked';
else $akt_prop='';
echo '<input'.$akt_prop.' onchange="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_akt" type="checkbox">';

echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_szolgkapadatlist_keres_mit3\',\'all\');admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mire3" class="select3" style="width:171px">';

echo '<option value="tagv_kod"';
if($ker_mire3=='tagv_kod') echo ' selected';
echo '>Társaság';

echo '<option value="szerz_tipus"';
if($ker_mire3=='szerz_tipus') echo ' selected';
echo '>Szerződés típus';

echo '<option value="szerz_keret"';
if($ker_mire3=='szerz_keret') echo ' selected';
echo '>Keretszerződés';

echo '<option value="szerz"';//selected
if($ker_mire3=='szerz') echo ' selected';
echo '>Szerződéses alapadat';

echo '<option value="szolg_kod"';
if($ker_mire3=='szolg_kod') echo ' selected';
echo '>Szolgáltatás kód';

echo '<option value="uto_kalk"';
if($ker_mire3=='uto_kalk') echo ' selected';
echo '>Utókalkuláció';

echo '<option value="elsz_tipus"';
if($ker_mire3=='elsz_tipus') echo ' selected';
echo '>Elszámolás típusa';

echo '<option value="naturalia"';
if($ker_mire3=='naturalia') echo ' selected';
echo '>Naturália típus';

echo '<option value="usergazda"';
if($ker_mire3=='usergazda') echo ' selected';
echo '>Szerződésgazda';

echo '<option value="szolg_erv"';
if($ker_mire3=='szolg_erv') echo ' selected';
echo '>Szolgáltatás érvényessége';

echo '<option value="integ_erintett"';
if($ker_mire3=='integ_erintett') echo ' selected';
echo '>Integrációban érintett';

echo '<option value="folyamatban"';
if($ker_mire3=='folyamatban') echo ' selected';
echo '>Folyamatban';

echo '<option value="penznem"';
if($ker_mire3=='penznem') echo ' selected';
echo '>Pénznem';

echo '</select>';
echo '<td>';// colspan=3
echo '<select onchange="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_mit3" class="select2_ajax" csonkolt=1 mit_id="admin_szolgkapadatlist_keres_mire3" mod="admin_szolgkapadat_ker1" style="width:311px">';
if($ker_mit3!=''and($ker_mit3!='all'))echo '<option value="'.$ker_mit3.'">'.$ker_mit3_value;
else echo '<option value="all">Összes';
echo '</select>';

echo '<td>';
echo 'SAP szerződésszám';
echo '<td>';
echo '<input value="'.$ker_szerz_sapszam.'" onkeyup="admin_szolgkapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szolgkapadatlist_keres_szerzsapszam" style="width:70px" type="text">';

echo '</tr>';
echo '</table></div>';
}

function admin_szolgkapadat_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szolgkapadat_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Szerződések</b>';//<br>
echo '<table id="admin_szolgkapadatlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Alapdat<br>ID ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel.szerz_tetel_id";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás<br>ID ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

/*
$order_mezo="szerz_tetel.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Alapadat ID ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);
*/

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_keret";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_date_hatalybelep";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés hatályba<br>lépésének időpontja ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_sapszam";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>SAP szerződésszám ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szerz_tetel_modszam";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Módosítás ID ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szerz_tetel_modszam_kezi";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés<br>módosítás száma ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.szerz_csop_nev";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás csoport ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tetel_adat.szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_szolgkapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod',$order_mezo);

echo "<th>Hibajavítás";
echo '</tr></thead><tbody>';

admin_szolgkapadat_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szolgkapadat','admin_szolgkapadatlist_keres_talszam','admin_szolgkapadatlist_keres_proc');

}

function admin_szolgkapadat_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_id']; 
 
 echo '<td>';
 echo $ert['szerz_tetel_id'];
 echo ' <img onclick="admin_szolgkapadat_reszlet(\''.$ert['szerz_tetel_id'].'\',\''.$ert['szerz_tetel_adat_id'].'\')" title="Részletezés" class="linkimg_tooltip img_resz" src="image/details_18_1.png">';

 /*
 echo '<td>';
 echo $ert['szerz_id'];
 */

 $tilte='<b>'.$ert['tagv_kod_nev'].'</b>';
 $tilte.='<br><b>Szerződéses alapadat ID:</b> '.$ert['szerz_id'];
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte.='<br><b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>';
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].'</span>';
 
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);
 
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']);
 
 echo '<td>';
 echo $ert['szerz_sapszam'];
 
 echo '<td>';
 //if($ert['szerz_tetel_modszam']!='0')

 /*if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
  $ert['szerz_tetel_modszam']='-1';
  $ert['szerz_tetel_akt']='0';
 }*/
 
 /*
 echo $ert['szerz_tetel_modszam'];
 if($ert['szerz_tetel_akt']=='1'){
  echo ' - aktuális';
 }elseif($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
	 echo ' (folyamatban)';
 }
 */
 $statusz_str=szerz_statusz($ert['szerz_tetel_modszam'],$ert['szerz_tetel_szolg_kezd_date_folyamatban'],$ert['szerz_tetel_akt'],$ert['szerz_tetel_akt_folyamatban'],$ert['szerz_tetel_vege']);
 echo $statusz_str;
 
 //Szerződés módosítás száma
 echo '<td>';
 echo $ert['szerz_tetel_modszam_kezi'];
 
 echo '<td>';
 echo $ert['szerz_csop_nev'];
 
 echo '<td>';
 echo $ert['szolg_kod'];
 
 echo '<td align=center>';
 echo '<img onclick="admin_szolgkapadat_mod(\''.$ert['szerz_tetel_id'].'\',\''.$ert['szerz_tetel_adat_id'].'\',\''.$statusz_str.'\')" title="Módosítás" class="linkimg_tooltip" src="image/mod15_2.png">';
 
 echo '</tr>';
}
}
}
}

function admin_ujszolgkapadat_ment(){
//kötelező dolgok ellenőrzése - eleje

if((!isset($_POST['szerz_id']))or((isset($_POST['szerz_id'])and($_POST['szerz_id']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Szerződéses alapadat kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szerz_csop_id']))or((isset($_POST['szerz_csop_id'])and($_POST['szerz_csop_id']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Szolgáltatás csoport kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szolg_kod']))or((isset($_POST['szolg_kod'])and($_POST['szolg_kod']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Szolgáltatás kód kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szerz_tetel_utok']))or((isset($_POST['szerz_tetel_utok'])and($_POST['szerz_tetel_utok']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Utókalkuláció kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szerz_elsz_tipus_id']))or((isset($_POST['szerz_elsz_tipus_id'])and($_POST['szerz_elsz_tipus_id']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Elszámolás típusa kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szerz_naturalia_id']))or((isset($_POST['szerz_naturalia_id'])and($_POST['szerz_naturalia_id']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Naturália típus kiválasztása kötelező!";
 exit;
}

if((!isset($_POST['szerz_usergazda_ad']))or((isset($_POST['szerz_usergazda_ad'])and($_POST['szerz_usergazda_ad']=="keremv")))){
 echo "nook$;$"."Hiba!<br><br>Szerződésgazda kiválasztása kötelező!";
 exit;
}


if((!isset($_POST['szerz_tetel_szolg_kezd_date']))or($_POST['szerz_tetel_szolg_kezd_date']=='')){
 echo "nook$;$"."Hiba!<br><br>Szolgáltásnyújtás megkezdésének időpontjának kitöltése kötelező!";
 exit;	
}
	
if((isset($_POST['szerz_tetel_szolg_kezd_date']))and($_POST['szerz_tetel_szolg_kezd_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_kezd_date']))){
 echo "nook$;$"."Hiba!<br><br>Szolgáltásnyújtás megkezdésének időpontja - eredeti dátuma hibás!";
 exit;
}

if((isset($_POST['szerz_tetel_szolg_origveg_date']))and($_POST['szerz_tetel_szolg_origveg_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_origveg_date']))){
 echo "nook$;$"."Hiba!<br><br>Szerződés időtartam vége eredeti (határozott esetén) dátuma hibás!";
 exit;
}

if((isset($_POST['szerz_tetel_arajanlat_alair']))and($_POST['szerz_tetel_arajanlat_alair']!='')and(!checkmydate($_POST['szerz_tetel_arajanlat_alair']))){
 echo "nook$;$"."Hiba!<br><br>Árajánlat alírás dátuma hibás!";
 exit;
}

if((isset($_POST['szerz_tetel_alair_date']))and($_POST['szerz_tetel_alair_date']!='')and(!checkmydate($_POST['szerz_tetel_alair_date']))){
 echo "nook$;$"."Hiba!<br><br>Alírás dátuma hibás!";
 exit;
}

if((isset($_POST['szerz_tetel_integ_erintett']))and($_POST['szerz_tetel_integ_erintett']=='keremv')){
 echo "nook$;$"."Hiba!<br><br>Integrációban érintett kiválasztása kötelező";
 exit;
}

//Szerződéses alapadat Szerződés hatálybalépésének időpontja kiderítése.
$szerz_date_hatalybelep=keres_mit1_mit1_csak_ertek('szerz','szerz_id',$_POST['szerz_id'],'szerz_date_hatalybelep');

if($szerz_date_hatalybelep==''){
 echo "nook$;$"."Hiba!<br><br>Szerződéses alapadat nem létezik!";
 exit;
}

if(convert_dateszam($_POST['szerz_tetel_szolg_kezd_date'])<(convert_dateszam($szerz_date_hatalybelep))){
 echo "nook$;$"."Hiba!<br><br>Szolgáltásnyújtás megkezdésének időpontja nem lehet korábbi mint a Szerződés hatályba lépésének időpontja!";
 exit;
}

if(
($_POST['szerz_tetel_szolg_origveg_date']!='')and
(convert_dateszam($_POST['szerz_tetel_szolg_origveg_date'])<convert_dateszam($_POST['szerz_tetel_szolg_kezd_date']))
){
 echo "nook$;$"."Hiba!<br><br><b>Szerződés időtartam vége eredeti (határozott esetén)</b> időpontja nem lehet korábbi mint a <b>Szolgáltásnyújtás megkezdésének időpontja</b>!";
 exit;
}

//2: Van-e Ilyen - Csak akkor vihető be, ha $_POST['szerz_id'] nincs már bent, csak akkor új rekord!
//$szerz_id=keres_mit1_mit1('szerz_tetel','szerz_id',$_POST['szerz_id'],'szerz_id');
//$szerz_id=keres_mit2_mit1('szerz_tetel','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_id');
//$szerz_tetel_adat_id =keres_mit2_mit1('szerz_tetel','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szerz_id');
if(mb_strtolower($_POST['szolg_kod'])=='kk99'){
 $szerz_tetel_adat_id='';
}else{
 //$szerz_tetel_adat_id=keres_mit3_mit1_csak_ertek('szerz_tetel_adat','szerz_id',$_POST['szerz_id'],'szerz_csop_id',$_POST['szerz_csop_id'],'szolg_kod',$_POST['szolg_kod'],'szerz_tetel_adat_id');
 $szerz_tetel_adat_id=keres_ment_vane_dupla_szolgkod_nincsvege($_POST['szerz_id'],$_POST['szerz_csop_id'],$_POST['szolg_kod']);
}
//if(is_array($szerz_tetel_adat_id)){
if($szerz_tetel_adat_id!=''){
 echo 'nook$;$Hiba!<br><br>Van már ilyen szolgáltatáshoz kapcsolódó adat!';
 exit;
}else{
 mysqli_autocommit($GLOBALS['mysqli'],false);
 
 $tmp_bk_fo=array();
 
 if((isset($_POST['szerz_tetel_szolg_kezd_date']))and($_POST['szerz_tetel_szolg_kezd_date']!=''))
  $tmp_bk_fo[0]['szerz_tetel_szolg_kezd_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_kezd_date']);

 if(
 (isset($_POST['folyamatban']))and
 (
  ($_POST['folyamatban']=='1')or
  ($_POST['folyamatban']=='0')
 )
 )
  $tmp_bk_fo[0]['szerz_tetel_szolg_kezd_date_folyamatban']=$_POST['folyamatban'];
 
 if((isset($_POST['szerz_tetel_szolg_origveg_date']))and($_POST['szerz_tetel_szolg_origveg_date']!=''))
  $tmp_bk_fo[0]['szerz_tetel_szolg_origveg_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_origveg_date']);

 //$tmp_bk_fo[0]['szerz_tetel_arajanlat_alair']=$_POST['szerz_tetel_arajanlat_alair'];
 $tmp_bk_fo[0]['szerz_tetel_keszito_user_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 be_visz_insert('szerz_tetel',$tmp_bk_fo);
 $szerz_tetel_id=mysqli_insert_id($GLOBALS['mysqli']);
 
 $tmp_bk=array();
 $tmp_bk[0]['szerz_id']=$_POST['szerz_id'];
 $tmp_bk[0]['szerz_tetel_id']=$szerz_tetel_id;
 $tmp_bk[0]['szerz_tetel_akt']='1';
 
 $tmp_bk[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
 
 if((isset($_POST['szerz_csop_id']))and($_POST['szerz_csop_id']!=''))
  $tmp_bk[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
 
 if((isset($_POST['szolg_kod']))and($_POST['szolg_kod']!=''))
  $tmp_bk[0]['szolg_kod']=$_POST['szolg_kod'];

 if((isset($_POST['szerz_tetel_arajanlat_alair']))and($_POST['szerz_tetel_arajanlat_alair']!=''))
  $tmp_bk[0]['szerz_tetel_arajanlat_alair_date']=str_replace(".","-",$_POST['szerz_tetel_arajanlat_alair']);

 if((isset($_POST['szerz_tetel_alair_date']))and($_POST['szerz_tetel_alair_date']!=''))
  $tmp_bk[0]['szerz_tetel_alair_date']=str_replace(".","-",$_POST['szerz_tetel_alair_date']);

 if((isset($_POST['szerz_tetel_utok']))and($_POST['szerz_tetel_utok']!=''))
  $tmp_bk[0]['szerz_tetel_utok']=$_POST['szerz_tetel_utok'];
 
 if((isset($_POST['szerz_tetel_netto_szerzdij']))and($_POST['szerz_tetel_netto_szerzdij']!=''))
  $tmp_bk[0]['szerz_tetel_netto_szerzdij']=$_POST['szerz_tetel_netto_szerzdij'];

 if((isset($_POST['szerz_tetel_netto_havidij']))and($_POST['szerz_tetel_netto_havidij']!=''))
  $tmp_bk[0]['szerz_tetel_netto_havidij']=$_POST['szerz_tetel_netto_havidij'];

 if((isset($_POST['szerz_tetel_netto_havidij_penznem']))and($_POST['szerz_tetel_netto_havidij_penznem']!=''))
  $tmp_bk[0]['szerz_tetel_netto_havidij_penznem']=$_POST['szerz_tetel_netto_havidij_penznem'];

if((isset($_POST['nettoszerzdij_nemrelevans']))and($_POST['nettoszerzdij_nemrelevans']=='1'))
  $tmp_bk[0]['szerz_tetel_netto_szerzdij_nemrelevans']='1';
  
 if((isset($_POST['szerz_elsz_tipus_id']))and($_POST['szerz_elsz_tipus_id']!=''))
  $tmp_bk[0]['szerz_elsz_tipus_id']=$_POST['szerz_elsz_tipus_id'];
  
 if((isset($_POST['szerz_tetel_oradij']))and($_POST['szerz_tetel_oradij']!=''))
  $tmp_bk[0]['szerz_tetel_oradij']=$_POST['szerz_tetel_oradij'];  

 if((isset($_POST['oradij_nemrelevans']))and($_POST['oradij_nemrelevans']=='1'))
  $tmp_bk[0]['szerz_tetel_oradij_nemrelevans']='1';

 if((isset($_POST['szerz_tetel_netto_evesdij']))and($_POST['szerz_tetel_netto_evesdij']!=''))
  $tmp_bk[0]['szerz_tetel_netto_evesdij']=$_POST['szerz_tetel_netto_evesdij']; 
 
 if((isset($_POST['szerz_naturalia_id']))and($_POST['szerz_naturalia_id']!=''))
  $tmp_bk[0]['szerz_naturalia_id']=$_POST['szerz_naturalia_id']; 
 
 if((isset($_POST['szerz_tetel_naturalia_darab']))and($_POST['szerz_tetel_naturalia_darab']!=''))
  $tmp_bk[0]['szerz_tetel_naturalia_darab']=$_POST['szerz_tetel_naturalia_darab']; 
 
 if((isset($_POST['szerz_usergazda_ad']))and($_POST['szerz_usergazda_ad']!=''))
  $tmp_bk[0]['szerz_usergazda_ad']=$_POST['szerz_usergazda_ad'];
  
 if((isset($_POST['szerz_tetel_integ_erintett']))and($_POST['szerz_tetel_integ_erintett']!=''))
  $tmp_bk[0]['szerz_tetel_integ_erintett']=$_POST['szerz_tetel_integ_erintett'];
   
 if((isset($_POST['szerz_tetel_megj']))and($_POST['szerz_tetel_megj']!=''))
  $tmp_bk[0]['szerz_tetel_megj']=$_POST['szerz_tetel_megj'];

 if((isset($_POST['szerz_tetel_tt_megj']))and($_POST['szerz_tetel_tt_megj']!=''))
  $tmp_bk[0]['szerz_tetel_tt_megj']=$_POST['szerz_tetel_tt_megj'];
 
 //if((isset($_POST['szerz_tetel_link']))and($_POST['szerz_tetel_link']!=''))
 // $tmp_bk[0]['szerz_tetel_link']=$_POST['szerz_tetel_link'];
 
 $tmp_bk[0]['szerz_tetel_mod_user_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

 be_visz_insert('szerz_tetel_adat',$tmp_bk);

//projekt bevitel - eleje
 if(!empty($_POST['projektid'])){
  $projekt_id_tomb = explode(',',$_POST['projektid']);
  $szerz_tetel_adat_id=mysqli_insert_id($GLOBALS['mysqli']);
  foreach($projekt_id_tomb as $id){
   $tiszta_id = trim($id);
   if($tiszta_id!==''){
	$tmp_projekt[] = [
                'projekt_id' => $tiszta_id,
                'szerz_tetel_adat_id' => $szerz_tetel_adat_id
            ];   
   }
  }
  
  if((isset($tmp_projekt))and(is_array($tmp_projekt))){
   be_visz_insert('szerz_tetel_adat_projekt',$tmp_projekt);
  }
 }
//projekt bevitel - vége


 mysqli_commit($GLOBALS['mysqli']);
 mysqli_autocommit($GLOBALS['mysqli'],true);
 echo "ok$;$";
 $_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']=$szerz_tetel_id;
 $_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']='all';
 $_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']='all';
 $_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']='all';
 $_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']='';
}

//kötelező dolgok ellenőrzése - vége

}

function admin_ujszolgkapadat_porjekt_add(){
echo 'ok$;$';
echo 'Tevékenység hozzárendelése új szolgáltatáshoz<br><br>';

echo "<b>Szűrés:</b><br>";
echo '<table border=0>';
echo '<tr>';
echo '<td>Tevékenység neve: ';
echo "<input onkeyup='admin_ujszolgkapadatprojektadd_hozz_keress(\"\",\"\")' id='ujszolgkapadatprojektadd_hozzidkod_keress' type=text style='width:250px'>";
echo '</tr>';
echo '<tr>';
echo '<td colspan=2>';
echo "Csak hozzárendelt tevékenységek: ";
echo "<input onchange='admin_ujszolgkapadatprojektadd_hozz_keress_proc(\"\",\"\")' id='ujszolgkapadatprojektadd_hozzid_csakhozz_szur' type='checkbox'>";
echo '<input type=hidden mod="'.$_POST['mod'].'" id="ujszolgkapadatprojektadd_hozzid_mod_szur">';
echo '</tr>';
echo '</table>';

echo "<div id='szolgcsopszolgkod_hozzid_tal_div'>";
$tomb_projek=keres_admin_ujszolgkapadat_projekt("","",0,'');
//$tomb_projek_van=explode(',',$_POST['projekt_id']);
$tomb_projek_van=array_flip(array_filter(array_map('trim', explode(',',$_POST['projekt_id']))));
admin_ujszolgkapadat_projekt_katt_list_ki($tomb_projek,$tomb_projek_van);
echo '</div>';
}

function admin_ujszolgkapadatprojektadd_hozz_keress(){
echo "ok$;$";
$tomb_projek_van=array_flip(array_filter(array_map('trim', explode(',',$_POST['projekt_id']))));
$tomb_projek=keres_admin_ujszolgkapadat_projekt('',$_POST['projekt_nev'],$_POST['csakvan'],$tomb_projek_van);
admin_ujszolgkapadat_projekt_katt_list_ki($tomb_projek,$tomb_projek_van);
}

function admin_ujszolgkapadat_projekt_katt_list_ki($tomb_projek,$tomb_projek_van){

if(is_array($tomb_projek)){
echo "<table style='margin-top:10px' class='table_emre_kek'>";

echo '<thead>';
echo '<tr>';
echo '<th>Tevékenység neve';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_projek as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_projek_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}

echo '<tr>';

echo "<td><label style='cursor:pointer' for='ujszolgkapadatprojekt_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];
if($ert['projekt_inaktiv']=='1')
	 echo ' <i>(inaktív)</i>';

echo "<td align=center>";
echo "<input".$ck." projekt_id='".$ert['projekt_id']."' projekt_nev='".$ert['projekt_nev']."' class='link' onchange='admin_ujszolgkapadatprojekt_hozz_change(\"".$ert['projekt_id']."\",\"".$_POST['mod']."\")' id='ujszolgkapadatprojekt_hozzid_".$ert['projekt_id']."' type='checkbox'>";
echo "</label>";

echo '</tr>';
}
}

echo "</tbody></table>";
table_alja_lepeget('0',$th,'admin_ujszolgkapadatprojekt','admin_ujszolgkapadatprojektlist_keres_talszam','admin_ujszolgkapadatprojektadd_hozz_keress_proc');

}
}

?>
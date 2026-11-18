<?php

function admin_szolgmodadat_mod(){
if(
 (isset($_POST['szerz_tetel_id']))and($_POST['szerz_tetel_id']!='')
){

include_once('admin_szerz_szolgkapadat_mod.php');
$tomb=keres_admin_szolgkapadat_egymodhoz($_POST['szerz_tetel_id'],$_POST['szerz_tetel_adat_id']);
echo 'ok$;$';

if(is_array($tomb)){
 admin_szolgmodadat_mod_kirajzol($tomb[0]);
}else{
 echo 'Nincs találat';
}
}else{
 echo 'adathiány';
}
}

function admin_szolgmodadat_mod_kirajzol($ert){

echo 'Szolgáltatás ID: '.$ert['szerz_tetel_id'];
//echo '<br>Aktuális szerződésmódosítás száma: '.$ert['szerz_tetel_modszam'];
echo '<br>Aktuális módosítás ID: '.$ert['szerz_tetel_modszam'];
//echo '<br>Új szerződésmódosítás száma: '.$ert['szerz_tetel_modszam']+1;
echo '<br>Új módosítás ID: '.$ert['szerz_tetel_modszam']+1;
echo '<table class="table_emre_kek" id="admin_szolgkapadat_reszlet_kirajzol">';

echo '<tbody>';

//Sor-1 - eleje
echo '<tr>';
 echo '<td>Alapdat ID';
 echo '<td>';
 echo $ert['szerz_id'];
 
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte='<b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>Társaság';
 echo '<td colspan=5>';
 //echo $ert['tagv_kod'].' - '.$ert['tagv_kod_nev'];
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].' - '.$ert['tagv_kod_nev'].'</span>';
echo '</tr>';
//Sor-1 - vége

//Sor-2 - eleje
echo '<tr>';
 echo '<td>Keretszerződés';
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);
 
 echo '<td>Szerződés típus';
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>Szerződés hatályba lépésének<br>időpontja';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']);

 echo '<td>Szerződés módosítás száma';
 echo '<td>';
 echo '<select orig_value="'.$ert['szerz_tetel_modszam_kezi'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_modszamkezi" class="select2_sima" style="width:45px">';
 for($i=0;$i<=20;$i++){
	 echo '<option value="'.$i.'"';
	 if($i==$ert['szerz_tetel_modszam_kezi'])echo ' selected';
	 echo '>'.$i;
 }
 echo '</select>';

echo '</tr>';
//Sor-2 - vége

//Sor-3 - eleje
echo '<tr>';
 echo '<td>Szolgáltatás csoport';
 echo '<td>';
 echo $ert['szerz_csop_nev'];

 echo '<td>Szolgáltatás kód';
 echo '<td>';
 echo $ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];

 echo '<td>Utókalkuláció';
 echo '<td>';
 //echo igennem_kod_ki($ert['szerz_tetel_utok']);
 echo '<select orig_value="'.$ert['szerz_tetel_utok'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_tetelutok" class="select3" style="width:120px">';
 echo '<option value="0"';
 if($ert['szerz_tetel_utok']=='0') echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ert['szerz_tetel_utok']=='1') echo ' selected';
 echo '>Igen';
 echo '</select>';
 
 echo '<td>Nettó szerződés díj<br>(eseti/maximális keret)';
 echo '<td>';
 //echo $ert['szerz_tetel_netto_szerzdij'];
 
 if($ert['szerz_tetel_netto_szerzdij_nemrelevans']=='1'){
	 $cknettoszerzdij_inp=' disabled';
	 $cknettoszerzdij_nemrelevans=' checked';
 }else{
	 $cknettoszerzdij_inp='';
	 $cknettoszerzdij_nemrelevans='';
 }
 
 echo '<input'.$cknettoszerzdij_inp.' orig_value="'.$ert['szerz_tetel_netto_szerzdij'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_szerzdij'].'" id="admin_modszolgmodadat_nettoszerzdij" style="width:100px" class="number_penz" maxlength="13" type="text">';
 echo '<label>';
 echo '<input'.$cknettoszerzdij_nemrelevans.' onchange="admin_szolgmodadat_mod_nettoszerzdij_nemrelevans_change()" orig_value="'.$ert['szerz_tetel_netto_szerzdij_nemrelevans'].'" id="admin_modszolgmodadat_nettoszerzdij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';

echo '</tr>';
//Sor-3 - vége

//Sor-4 - eleje
echo '<tr>';

 echo '<td>Szolgáltásnyújtás megkezdésének<br>időpontja - eredeti';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_kezd_date']);

 echo '<td>Nettó szerződéses havidíj';
 echo '<td>';
 //echo $ert['szerz_tetel_netto_havidij'];
 echo '<input orig_value="'.$ert['szerz_tetel_netto_havidij'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_havidij'].'" id="admin_modszolgmodadat_nettohavidij" style="width:100px;margin-right:5px;vertical-align:top" class="number_penz" maxlength="12" type="text">';

  echo '<select orig_value="'.$ert['szerz_tetel_netto_havidij_penznem'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_nettohavidij_penznem" class="select2_ajax" csonkolt=0 mod="admin_penznem_uj" style="width:55px">';
  echo '<option value="'.$ert['szerz_tetel_netto_havidij_penznem'].'">'.$ert['szerz_tetel_netto_havidij_penznem'];
  echo '</select>';
 
 echo '<td>Elszámolás típusa';
 echo '<td>';
 //echo $ert['szerz_elsz_tipus_nev'];
 echo '<select orig_value="'.$ert['szerz_elsz_tipus_id'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_elsztipusid" class="select2_ajax" csonkolt=1 mod="admin_elsztipus_mod" style="width:120px">';
 echo '<option value="'.$ert['szerz_elsz_tipus_id'].'">'.$ert['szerz_elsz_tipus_nev'];
 echo '</select>'; 
 
 echo '<td>Óradíj';
 echo '<td>';
 //echo $ert['szerz_tetel_oradij'];
 
 if($ert['szerz_tetel_oradij_nemrelevans']=='1'){
	 $ckoradij_inp=' disabled';
	 $ckoradij_nemrelevans=' checked';
 }else{
	 $ckoradij_inp='';
	 $ckoradij_nemrelevans='';
 }
 
 echo '<input'.$ckoradij_inp.' orig_value="'.$ert['szerz_tetel_oradij'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_oradij'].'" id="admin_modszolgmodadat_oradij" style="width:100px" class="number_penz" maxlength="6" type="text">';
 echo '<label>';
 echo '<input'.$ckoradij_nemrelevans.' onchange="admin_szolgmodadat_mod_oradij_nemrelevans_change()" orig_value="'.$ert['szerz_tetel_oradij_nemrelevans'].'" id="admin_modszolgmodadat_oradij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';
 
echo '</tr>';
//Sor-4 - vége

//Sor-5.0 - eleje
echo '<tr>';

 echo '<td>Árajánlat aláírás dátuma';
 echo '<td>';
 //echo kidate_format_ev($ert['szerz_tetel_arajanlat_alair']);
 echo '<input orig_value="" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="" id="admin_modszolgmodadat_arajanlatalairdate" class="date_tol" style="width:100px" type="text">';


 echo '<td>Idei naptári évi éves díj';
 echo '<td>';
 echo '<input orig_value="'.$ert['szerz_tetel_netto_evesdij'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_evesdij'].'" id="admin_modszolgmodadat_nettoevesdij" style="width:100px" class="number_penz" maxlength="12" type="text">';

 echo '<td>Naturália típus';
 echo '<td>';
 //echo $ert['szerz_naturalia_nev'];
 echo '<select orig_value="'.$ert['szerz_naturalia_id'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_naturaliaid" class="select2_ajax" csonkolt=1 mod="admin_nattipus_mod" style="width:120px">';
 echo '<option value="'.$ert['szerz_naturalia_id'].'">'.$ert['szerz_naturalia_nev'];
 echo '</select>';
 
 echo '<td>Naturália mennyiség (HAVI)';
 echo '<td>';
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 //echo $ert['szerz_tetel_naturalia_darab'];
 echo '<input orig_value="'.$ert['szerz_tetel_naturalia_darab'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']).'" id="admin_modszolgmodadat_naturaliadarab" class="number_penz_2tizedes" style="width:100px" maxlength="11" type="text">';

echo '</tr>';
//Sor-5.0 - vége

//Sor-5.1 - eleje
echo '<tr>';

 echo '<td>Szerződés aláírás dátuma';
 echo '<td>';
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_alair_date']).'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_alair_date'].'" id="admin_modszolgmodadat_alairdate" class="date_tol" style="width:100px" type="text">';

 echo '<td>Szerződés időtartam<br>eredeti (határozott esetén)';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']);
 //
 
 echo '<td>Szerződés időtartam<br>aktuális (határozott esetén)';
 echo '<td colspan=3>';
 echo '<input orig_value="" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="" id="admin_modszolgmodadat_szolgaktvegdate" class="date_tol" style="width:100px" type="text">'; 

echo '</tr>';
//Sor-5.1 - vége

//Sor-4 - eleje
if(($ert['szerz_tetel_szolg_mod_date']!='')or
(
 ($ert['szerz_tetel_akt_folyamatban']=='1')and($ert['szerz_tetel_modszam']>1)
)
){
echo '<tr>';
 echo '<td>Előző szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td colspan=7>';
 if($ert['szerz_tetel_szolg_mod_date']!=''){
  echo kidate_format_ev($ert['szerz_tetel_szolg_mod_date']);
 }else{
	 $szerz_tetel_szolg_mod_date=keres_mit2_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_id',$ert['szerz_tetel_id'],'szerz_tetel_akt_folyamatban_vanmasik','1','szerz_tetel_szolg_mod_date');
	 if($szerz_tetel_szolg_mod_date!='')echo kidate_format_ev($szerz_tetel_szolg_mod_date);
 }
echo '</tr>';
}
//Sor-4 - vége

//Sor-4 - eleje
echo '<tr>';
 echo '<td>Szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td colspan=7>';
 if($ert['szerz_tetel_akt_folyamatban']=='1'){
	 $dis_moddate=' disabled';
	 $ck_foly=' checked';
 }else{$ck_foly=$dis_moddate='';}
 echo '<input'.$dis_moddate.' orig_value="" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="" id="admin_modszolgmodadat_szolgmoddate" class="date_tol" style="width:100px" type="text">';
 
 echo ' <label>Folyamatban';
 echo '<input'.$ck_foly.' orig_value="'.$ert['szerz_tetel_akt_folyamatban'].'" onchange="admin_modszolgmodadat_folyamatban_change();admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_folyamatban" style="vertical-align:bottom" type="checkbox">';
 echo '</label>';
echo '</tr>';
//Sor-4 - vége

//Sor-6 - eleje
echo '<tr>';
 
 echo '<td>Tevékenység';
 echo '<td>';
 echo '<span title="'.$ert['projekt_nevek'].'" id="admin_ujszolgkapadat_projektid_szam_mod" onclick="admin_ujszolgkapadat_porjekt_add(\'mod\')" class="link">';
 if($ert['projekt_nevek']!=''){
  //echo $ert['projekt_nevek'];
  echo str_hosz_vag($ert['projekt_nevek'],250,'<br>');
 }else{
  echo 'Tevékenységek hozzáadása';
 }
 echo '</span>';
 echo '<input type=hidden onchange="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_ujszolgkapadat_projektid_mod" value="'.$ert['projekt_idek'].'" '.$ert['projekt_id_nevek'].' orig_value="'.$ert['projekt_idek'].'">';

 
 echo '<td>Szerződésgazda';
 echo '<td colspan=3>';
 //echo $ert['szerz_usergazda_nev'];
 echo '<select orig_value="'.$ert['szerz_usergazda_ad'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_usergazdaad" class="select2_ajax" csonkolt=1 mod="admin_usergazda_mod" style="width:513px">';
 echo '<option value="'.$ert['szerz_usergazda_ad'].'">'.$ert['szerz_usergazda_nev'].' ('.$ert['szerz_usergazda_tsz'].', '.$ert['szerz_usergazda_ad'].')';
 if($ert['szerz_usergazda_inaktiv']=='1')echo ' - Inaktív';
 echo '</select>';
 
 echo '<td>Integrációban érintett';
 echo '<td>';
 //echo $ert['szerz_tetel_integ_erint_date'];
 //echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_integ_erint_date']).'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_integ_erint_date'].'" id="admin_modszolgmodadat_integerintdate" class="date_tol" style="width:100px" type="text">';
 
 echo '<select orig_value="'.$ert['szerz_tetel_integ_erintett'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_integerintett" class="select3" style="width:120px">';
 echo '<option value="0"';
 if($ert['szerz_tetel_integ_erintett']=='0') echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ert['szerz_tetel_integ_erintett']=='1') echo ' selected';
 echo '>Igen';
 echo '</select>';


echo '</tr>';
//Sor-6 - vége

//Sor-7 - eleje
echo '<tr>';
 echo '<td>Általános megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea orig_value="'.$ert['szerz_tetel_megj'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_megj" rows="2" style="width:98%">';
 echo $ert['szerz_tetel_megj'];
 echo '</textarea>';
echo '</tr>';
//Sor-7 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>TT megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea orig_value="'.$ert['szerz_tetel_tt_megj'].'" onchange="admin_szolgmodadat_mod_proc_urlap_valt()" onkeyup="admin_szolgmodadat_mod_proc_urlap_valt()" id="admin_modszolgmodadat_ttmegj" rows="2" style="width:98%">';
 echo $ert['szerz_tetel_tt_megj'];
 echo '</textarea>';
echo '</tr>';
//Sor-8 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>Szerződés';
 echo '<td colspan=7>';
 if($ert['szerz_file_szerz_vane']=='1'){
  echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'szerz\')" class="link">'.$ert['szerz_file_szerz_name'].'</span>';
 }
echo '</tr>';
//Sor-8 - vége

//Sor-8.1 - eleje
echo '<tr>';
 echo '<td>Árajánlat';
 echo '<td colspan=7>';
 if($ert['szerz_file_ar_vane']=='1'){
  echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'ar\')" class="link">'.$ert['szerz_file_ar_name'].'</span>';
 }
echo '</tr>';
//Sor-8.1 - vége

echo '</tbody>';
echo '</table>';

echo '<span style="margin-top:10px;display:none;padding:5px;background-color:#D6D6D6;c1olor:#fff;border-radius:5px" id="admin_szolgmodadat_mod_mezok">';
echo 'Módosított mezők:';
echo '<ul style="margin:0px;cursor:pointer" id="admin_szolgmodadat_mod_proc_urlap_valt">';
//echo '<li style="display:none" title="'.$ert['szerz_csop_nev'].'" id="lihiba_admin_modszolgmodadat_szerzcsopid">Szolgáltatás csoport';
//echo '<li style="display:none" title="'.$ert['szolg_kod'].' - '.$ert['szolg_kod_nev'].'" id="lihiba_admin_modszolgmodadat_szolgkod">Szolgáltatás kód';

echo '<li style="display:none" title="'.$ert['szerz_tetel_modszam_kezi'].'" id="lihiba_admin_modszolgmodadat_modszamkezi">Szerződés módosítás száma';

echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_utok']).'" id="lihiba_admin_modszolgmodadat_tetelutok">Utókalkuláció';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_szerzdij'].'" id="lihiba_admin_modszolgmodadat_nettoszerzdij">Nettó szerződés díj (eseti/maximális keret)';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_netto_szerzdij_nemrelevans']).'" id="lihiba_admin_modszolgmodadat_nettoszerzdij_nemrelevans">Nettó szerződés díj (eseti/maximális keret) - Nem releváns';

echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_alair_date']).'" id="lihiba_admin_modszolgmodadat_alairdate">Szerződés aláírás dátuma';
echo '<li style="display:none" title="" id="lihiba_admin_modszolgmodadat_szolgaktvegdate">Szerződés időtartam aktuális (határozott esetén)';
//echo '<li style="display:none" title="'.$ert['szerz_tetel_szolg_kezd_date'].'" id="lihiba_admin_modszolgmodadat_szolgkezddate">Szolgáltásnyújtás megkezdésének időpontja';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_havidij'].'" id="lihiba_admin_modszolgmodadat_nettohavidij">Nettó szerződéses havidíj';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_havidij_penznem'].'" id="lihiba_admin_modszolgmodadat_nettohavidij_penznem">Nettó szerződéses havidíj - Pénznem';
echo '<li style="display:none" title="'.$ert['szerz_elsz_tipus_nev'].'" id="lihiba_admin_modszolgmodadat_elsztipusid">Elszámolás típusa';
echo '<li style="display:none" title="'.$ert['szerz_tetel_oradij'].'" id="lihiba_admin_modszolgmodadat_oradij">Óradíj';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_oradij_nemrelevans']).'" id="lihiba_admin_modszolgmodadat_oradij_nemrelevans">Óradíj - Nem releváns';

echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_szolg_mod_date']).'" id="lihiba_admin_modszolgmodadat_szolgmoddate">Szerződésmódosítás hatályba lépésének dátuma';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_akt_folyamatban']).'" id="lihiba_admin_modszolgmodadat_folyamatban">Szerződésmódosítás folyamatban';

//echo '<li style="display:none" title="'.$ert['szerz_tetel_szolg_origveg_date'].'" id="lihiba_admin_modszolgmodadat_szolgorigvegdate">Szerződés időtartam (határozott esetén)';
echo '<li style="display:none" title="" id="lihiba_admin_modszolgmodadat_arajanlatalairdate">Árajánlat aláírás dátuma';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_evesdij'].'" id="lihiba_admin_modszolgmodadat_nettoevesdij">Idei naptári évi éves díj';
echo '<li style="display:none" title="'.$ert['szerz_naturalia_nev'].'" id="lihiba_admin_modszolgmodadat_naturaliaid">Naturália típus';
echo '<li style="display:none" title="'.kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']).'" id="lihiba_admin_modszolgmodadat_naturaliadarab">Naturália mennyiség (HAVI)';

echo '<li style="display:none" title="'.$ert['projekt_nevek'].'" id="lihiba_admin_ujszolgkapadat_projektid_mod">Tevékenységek';

echo '<li style="display:none" title="'.$ert['szerz_usergazda_nev'].'" ('.$ert['szerz_usergazda_tsz'].', '.$ert['szerz_usergazda_ad'].')'.' id="lihiba_admin_modszolgmodadat_usergazdaad">Szerződésgazda';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_integ_erintett']).'" id="lihiba_admin_modszolgmodadat_integerintett">Integrációban érintett';
echo '<li style="display:none" title="'.$ert['szerz_tetel_megj'].'" id="lihiba_admin_modszolgmodadat_megj">Általános megjegyzés';
echo '<li style="display:none" title="'.$ert['szerz_tetel_tt_megj'].'" id="lihiba_admin_modszolgmodadat_ttmegj">TT megjegyzés';
//echo '<li style="display:none" title="'.$ert['szerz_tetel_link'].'" id="lihiba_admin_modszolgmodadat_tetellink">Szerződés elérése a hálózaton';
echo '</ul>';
echo '</span>';
}

function admin_szolgmodadat_mod_proc_urlap_mentes_proc(){
if(
 (isset($_POST['szerz_tetel_id']))and
 (isset($_POST['szerz_tetel_adat_id']))and
 ($_POST['szerz_tetel_id']!='')and
 ($_POST['szerz_tetel_adat_id']!='')
){

//Ellenőrzés - eleje
$ret='';
if((isset($_POST['szerz_tetel_szolg_mod_date']))and($_POST['szerz_tetel_szolg_mod_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_mod_date']))){
 $ret.='<li>Szerződésmódosítás hatályba lépésének dátuma hibás!';
}

if((isset($_POST['szerz_tetel_alair_date']))and($_POST['szerz_tetel_alair_date']!='')and(!checkmydate($_POST['szerz_tetel_alair_date']))){
 $ret.='<li>Szerződés aláírás dátuma hibás!';
}

if((isset($_POST['szerz_tetel_arajanlat_alair_date']))and($_POST['szerz_tetel_arajanlat_alair_date']!='')and(!checkmydate($_POST['szerz_tetel_arajanlat_alair_date']))){
 $ret.='<li>Árajánlat aláírás dátuma hibás!';
}

if((isset($_POST['szerz_tetel_szolg_aktveg_date']))and($_POST['szerz_tetel_szolg_aktveg_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_aktveg_date']))){
 $ret.='<li>Szerződés időtartam aktuális (határozott esetén) dátuma hibás!';
}

//Szerződés módosítás dátuma nem lehet kisebb, mint az utolsó módosítás dátuma! - eleje

if(
(isset($_POST['szerz_tetel_szolg_mod_date']))and($_POST['szerz_tetel_szolg_mod_date']!='')and
(keres_mit1_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_modszam')>1)and
 (
 (!isset($_POST['akt_folyamatban']))or($_POST['akt_folyamatban']=='0')
 )
){
 
 $most_van_folyamatban=keres_mit1_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_akt_folyamatban');
 if($most_van_folyamatban=='1'){
  $szerz_tetel_szolg_mod_date=keres_mit3_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_id',$_POST['szerz_tetel_id'],'szerz_tetel_akt','1','szerz_tetel_akt_folyamatban_vanmasik','1','szerz_tetel_szolg_mod_date'); 
 }else{
  $szerz_tetel_szolg_mod_date=keres_mit2_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_id',$_POST['szerz_tetel_id'],'szerz_tetel_akt','1','szerz_tetel_szolg_mod_date');
 }
 if(($szerz_tetel_szolg_mod_date!='')and(convert_dateszam($_POST['szerz_tetel_szolg_mod_date'])<(convert_dateszam($szerz_tetel_szolg_mod_date)))){
  $ret.="<li>Szerződésmódosítás hatályba lépésének dátuma nem lehet korábbi mint az előző Szerződésmódosítás hatályba lépésének dátuma!";
 }
}
//Szerződés módosítás dátuma nem lehet kisebb, mint az utolsó módosítás dátuma! - vége

if($ret!=''){
 echo 'nook$;$';
 echo '<b>Szerződésmódosítás mentése sikertelen!</b><br>';
 echo '<ul>';
 echo $ret;
 echo '</ul>';
 exit;
}
//Ellenőrzés - vége

mysqli_autocommit($GLOBALS['mysqli'],false);

//0: Korábbi adatok lekeressük
include_once('admin_szerz_szolgkapadat_mod.php');
 $tomb=keres_admin_szolgkapadat_egymodhoz($_POST['szerz_tetel_id'],$_POST['szerz_tetel_adat_id']);
if(is_array($tomb)){
//1: Utolsó szerz_tetel_modszam kitalálása
$szerz_tetel_modszam=keres_mit2_mit1_csak_ertek("szerz_tetel_adat",'szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_akt','1','szerz_tetel_modszam');

//2 szerz_tetel_akt=1
 $tmp_mod_n=array();
 if((isset($_POST['akt_folyamatban']))and($_POST['akt_folyamatban']=='1')){
	$tmp_mod_n[0]['szerz_tetel_akt_folyamatban_vanmasik']='1';
	mod_egy_fel_tom2('szerz_tetel_adat',$tmp_mod_n[0],"szerz_tetel_id",$_POST['szerz_tetel_id'],'szerz_tetel_akt','1');
 }else{
	 $tmp_mod_n[0]['szerz_tetel_akt']='0';
	 
	 if((isset($_POST['szerz_tetel_szolg_mod_date']))and($_POST['szerz_tetel_szolg_mod_date']!='')){
	  $_POST['szerz_tetel_szolg_mod_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_mod_date']);
	  $tmp_mod_n[0]['szerz_tetel_szolg_modveg_date']=date("Y-m-d", strtotime(str_replace(".","-",$_POST['szerz_tetel_szolg_mod_date']).' -1 day'));
	 }
	
	//Tehát 0-ra változott
	if(keres_mit1_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_akt_folyamatban')=='1'){
	 $tmp_mod_n[0]['szerz_tetel_akt_folyamatban_vanmasik']='0';
	 mod_egy_fel_tom3('szerz_tetel_adat',$tmp_mod_n[0],"szerz_tetel_id",$_POST['szerz_tetel_id'],'szerz_tetel_akt','1','szerz_tetel_akt_folyamatban_vanmasik','1');
	}else{
	 mod_egy_fel_tom2('szerz_tetel_adat',$tmp_mod_n[0],"szerz_tetel_id",$_POST['szerz_tetel_id'],'szerz_tetel_akt','1');
	}
	
 }
 
 $tmp_mod=array();
 if(isset($_POST['szerz_tetel_id']))$tmp_mod[0]['szerz_tetel_id']=$_POST['szerz_tetel_id'];
 $tmp_mod[0]['szerz_id']=$tomb[0]['szerz_id'];
 $tmp_mod[0]['szerz_csop_id']=$tomb[0]['szerz_csop_id'];
 $tmp_mod[0]['szolg_kod']=$tomb[0]['szolg_kod'];
 //$tmp_mod[0]['szerz_tetel_szolg_kezd_date']=$tomb[0]['szerz_tetel_szolg_kezd_date'];
 
 $tmp_mod[0]['szerz_tetel_akt']='1';
 
 if((isset($_POST['akt_folyamatban']))and($_POST['akt_folyamatban']=='1')){
  $tmp_mod[0]['szerz_tetel_akt_folyamatban']='1';
 }
 
 $tmp_mod[0]['szerz_tetel_modszam']=$szerz_tetel_modszam+1;
 
 if(isset($_POST['szerz_tetel_modszam_kezi'])){
  $tmp_mod[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
 }else{
  $tmp_mod[0]['szerz_tetel_modszam_kezi']=$tomb[0]['szerz_tetel_modszam_kezi'];
 }
 
 if(isset($_POST['szerz_tetel_utok']))$tmp_mod[0]['szerz_tetel_utok']=$_POST['szerz_tetel_utok'];
 else $tmp_mod[0]['szerz_tetel_utok']=$tomb[0]['szerz_tetel_utok'];
 
 if(isset($_POST['szerz_tetel_netto_szerzdij'])){
	 if($_POST['szerz_tetel_netto_szerzdij']!=''){
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij']=$_POST['szerz_tetel_netto_szerzdij'];
	 }else{
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij']=null;
	 }
 }else $tmp_mod[0]['szerz_tetel_netto_szerzdij']=$tomb[0]['szerz_tetel_netto_szerzdij'];
 
 if(isset($_POST['nettoszerzdij_nemrelevans'])){
	if($_POST['nettoszerzdij_nemrelevans']=='1'){
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij_nemrelevans']='1';
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij']=null;
	}else{
		$tmp_mod[0]['szerz_tetel_netto_szerzdij_nemrelevans']=null;
	}
 }else{
	 $tmp_mod[0]['szerz_tetel_netto_szerzdij_nemrelevans']=$tomb[0]['szerz_tetel_netto_szerzdij_nemrelevans'];
 }

//Árajánlat aláírás dátuma
 if(isset($_POST['szerz_tetel_arajanlat_alair_date'])){
	 if($_POST['szerz_tetel_arajanlat_alair_date']!=''){
	  $tmp_mod[0]['szerz_tetel_arajanlat_alair_date']=str_replace(".","-",$_POST['szerz_tetel_arajanlat_alair_date']);
	 }else{
	  $tmp_mod[0]['szerz_tetel_arajanlat_alair_date']=null;
	 }//Ha nincs, akkor üres
 }else $tmp_mod[0]['szerz_tetel_arajanlat_alair_date']=null;
 
//Szerződás aláírás dátuma
 if(isset($_POST['szerz_tetel_alair_date'])){
	 if($_POST['szerz_tetel_alair_date']!=''){
	  $tmp_mod[0]['szerz_tetel_alair_date']=str_replace(".","-",$_POST['szerz_tetel_alair_date']);
	 }else{
	  $tmp_mod[0]['szerz_tetel_alair_date']=null;
	 }
 }else{ 
  if($tomb[0]['szerz_tetel_alair_date']!='')
   //$tmp_mod[0]['szerz_tetel_alair_date']=str_replace(".","-",$tomb[0]['szerz_tetel_alair_date']);
   $tmp_mod[0]['szerz_tetel_alair_date']=$tomb[0]['szerz_tetel_alair_date'];
  else $tmp_mod[0]['szerz_tetel_alair_date']=null;  
 }
//Szerződés időtartam aktuális (határozott esetén)
 if(isset($_POST['szerz_tetel_szolg_aktveg_date'])){
	 if($_POST['szerz_tetel_szolg_aktveg_date']!=''){
	  $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_aktveg_date']);
	 }else{
	  $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=null;
	 }
 }else{
	 if($tomb[0]['szerz_tetel_szolg_aktveg_date']!='')
	  //$tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=str_replace(".","-",$tomb[0]['szerz_tetel_szolg_aktveg_date']);
	  $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=$tomb[0]['szerz_tetel_szolg_aktveg_date'];
	 else $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=null;
 }
 
// if(isset($_POST['szerz_tetel_szolg_kezd_date']))$tmp_mod[0]['szerz_tetel_szolg_kezd_date']=$_POST['szerz_tetel_szolg_kezd_date'];
 if(isset($_POST['szerz_tetel_netto_havidij'])){
	 if($_POST['szerz_tetel_netto_havidij']!=''){
	  $tmp_mod[0]['szerz_tetel_netto_havidij']=$_POST['szerz_tetel_netto_havidij'];
	 }else{
	  $tmp_mod[0]['szerz_tetel_netto_havidij']=null;
	 }
 }else $tmp_mod[0]['szerz_tetel_netto_havidij']=$tomb[0]['szerz_tetel_netto_havidij'];
 
 if(isset($_POST['szerz_tetel_netto_havidij_penznem']))$tmp_mod[0]['szerz_tetel_netto_havidij_penznem']=$_POST['szerz_tetel_netto_havidij_penznem'];
 else $tmp_mod[0]['szerz_tetel_netto_havidij_penznem']=$tomb[0]['szerz_tetel_netto_havidij_penznem'];

 if(isset($_POST['szerz_elsz_tipus_id']))$tmp_mod[0]['szerz_elsz_tipus_id']=$_POST['szerz_elsz_tipus_id'];
 else $tmp_mod[0]['szerz_elsz_tipus_id']=$tomb[0]['szerz_elsz_tipus_id'];
 
 if(isset($_POST['szerz_tetel_oradij'])){
	if($_POST['szerz_tetel_oradij']!=''){
	 $tmp_mod[0]['szerz_tetel_oradij']=$_POST['szerz_tetel_oradij'];
	}else{
	 $tmp_mod[0]['szerz_tetel_oradij']=null;
	}
 }else $tmp_mod[0]['szerz_tetel_oradij']=$tomb[0]['szerz_tetel_oradij'];

 if(isset($_POST['oradij_nemrelevans'])){
	if($_POST['oradij_nemrelevans']=='1'){
	 $tmp_mod[0]['szerz_tetel_oradij_nemrelevans']='1';
	 $tmp_mod[0]['szerz_tetel_oradij']=null;
	}else{
	 $tmp_mod[0]['szerz_tetel_oradij_nemrelevans']=null;
	}
 }else{
	 $tmp_mod[0]['szerz_tetel_oradij_nemrelevans']=$tomb[0]['szerz_tetel_oradij_nemrelevans'];
 }

 if(isset($_POST['szerz_tetel_szolg_mod_date'])){
	 $tmp_mod[0]['szerz_tetel_szolg_mod_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_mod_date']);
 }elseif((isset($_POST['akt_folyamatban']))and($_POST['akt_folyamatban']=='1')){//Ha folyamatban 1, akkor a dátum mező üres
  $tmp_mod[0]['szerz_tetel_szolg_mod_date']=null;
 }else{
	 $tmp_mod[0]['szerz_tetel_szolg_mod_date']=str_replace(".","-",$tomb[0]['szerz_tetel_szolg_mod_date']);
 }

 //if(isset($_POST['szerz_tetel_szolg_origveg_date']))$tmp_mod[0]['szerz_tetel_szolg_origveg_date']=$_POST['szerz_tetel_szolg_origveg_date'];
 //else $tmp_mod[0]['szerz_tetel_szolg_origveg_date']=$tomb[0]['szerz_tetel_szolg_origveg_date'];
	 
 if(isset($_POST['szerz_tetel_netto_evesdij']))$tmp_mod[0]['szerz_tetel_netto_evesdij']=$_POST['szerz_tetel_netto_evesdij'];
 else $tmp_mod[0]['szerz_tetel_netto_evesdij']=$tomb[0]['szerz_tetel_netto_evesdij'];
	 
 if(isset($_POST['szerz_naturalia_id']))$tmp_mod[0]['szerz_naturalia_id']=$_POST['szerz_naturalia_id'];
 else $tmp_mod[0]['szerz_naturalia_id']=$tomb[0]['szerz_naturalia_id'];
 
 if(isset($_POST['szerz_tetel_naturalia_darab'])){
	 if($_POST['szerz_tetel_naturalia_darab']!=''){
	  $tmp_mod[0]['szerz_tetel_naturalia_darab']=$_POST['szerz_tetel_naturalia_darab'];
	 }else{
	  $tmp_mod[0]['szerz_tetel_naturalia_darab']=null;
	 }
 }else $tmp_mod[0]['szerz_tetel_naturalia_darab']=$tomb[0]['szerz_tetel_naturalia_darab'];
 
 if(isset($_POST['szerz_usergazda_ad']))$tmp_mod[0]['szerz_usergazda_ad']=$_POST['szerz_usergazda_ad'];
 else $tmp_mod[0]['szerz_usergazda_ad']=$tomb[0]['szerz_usergazda_ad'];
	 
 if(isset($_POST['szerz_tetel_integ_erintett'])){
  if($_POST['szerz_tetel_integ_erintett']!='')
   $tmp_mod[0]['szerz_tetel_integ_erintett']=$_POST['szerz_tetel_integ_erintett'];
  else $tmp_mod[0]['szerz_tetel_integ_erintett']=null;
 }else $tmp_mod[0]['szerz_tetel_integ_erintett']=$tomb[0]['szerz_tetel_integ_erintett'];
 
 if(isset($_POST['szerz_tetel_megj']))$tmp_mod[0]['szerz_tetel_megj']=$_POST['szerz_tetel_megj'];
 else $tmp_mod[0]['szerz_tetel_megj']=$tomb[0]['szerz_tetel_megj'];
	 
 if(isset($_POST['szerz_tetel_tt_megj']))$tmp_mod[0]['szerz_tetel_tt_megj']=$_POST['szerz_tetel_tt_megj'];
 else $tmp_mod[0]['szerz_tetel_tt_megj']=$tomb[0]['szerz_tetel_tt_megj'];

 /*if(isset($_POST['szerz_tetel_link']))$tmp_mod[0]['szerz_tetel_link']=$_POST['szerz_tetel_link'];
 else $tmp_mod[0]['szerz_tetel_link']=$tomb[0]['szerz_tetel_link'];*/
 
 $tmp_mod[0]['szerz_tetel_mod_user_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

 /*if(isset($tomb[0]['kpi_nemrelevans']))
	$tmp_mod[0]['kpi_nemrelevans']=$tomb[0]['kpi_nemrelevans'];*/

//Ha az akt_folyamatban=0 és az most a lementett akt_folyamatban=1, akkor módosítás és nembevitel!
if(
(isset($_POST['akt_folyamatban']))and
($_POST['akt_folyamatban']=='0')and
(keres_mit1_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_akt_folyamatban')=='1')
){
 $tmp_mod[0]['szerz_tetel_akt_folyamatban']='0';
 $tmp_mod[0]['szerz_tetel_modszam']--;
 mod_egy_fel_tom('szerz_tetel_adat',$tmp_mod[0],"szerz_tetel_adat_id",$_POST['szerz_tetel_adat_id']);
 $projektid_mod='modosit';
}else{
 be_visz_insert("szerz_tetel_adat",$tmp_mod);
 $szerz_tetel_adat_id=mysqli_insert_id($GLOBALS['mysqli']);
 $projektid_mod='bevitel';
}

//Tevékenységek elintézése - eleje
 if(isset($_POST['projektid'])){
 //if(!empty($_POST['projektid'])){
  $projekt_id_tomb = explode(',',$_POST['projektid']);
  if(is_array($projekt_id_tomb)){
	  
  if($projektid_mod=='modosit'){
	  $t_s_id=$_POST['szerz_tetel_adat_id'];
  }else{
	  $t_s_id=$szerz_tetel_adat_id; 
  }
  
  foreach($projekt_id_tomb as $id){
   $tiszta_id = trim($id);
   if($tiszta_id!==''){
	if($projektid_mod=='modosit'){
	 $tmp_projekt[] = ['projekt_id' => $tiszta_id,'szerz_tetel_adat_id' => $_POST['szerz_tetel_adat_id']];
	}else{
	 $tmp_projekt[] = ['projekt_id' => $tiszta_id,'szerz_tetel_adat_id' => $szerz_tetel_adat_id];
	}
   }
  }
  }


if($projektid_mod=='modosit'){
 if((isset($tmp_projekt))and(is_array($tmp_projekt))){
  torles('szerz_tetel_adat_projekt','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id']);
  if((isset($tmp_projekt))and(is_array($tmp_projekt))){
   be_visz_replace('szerz_tetel_adat_projekt',$tmp_projekt);
  }
 }
}else{//Ekkor bevitel
  if((isset($tmp_projekt))and(is_array($tmp_projekt))){
   be_visz_insert('szerz_tetel_adat_projekt',$tmp_projekt);
  }
}
  }
//Tevékenységek elintézése - vége

//KPI típus szerződés összerendelés lementése ha van - eleje
if(
(isset($tomb[0]['szerz_id']))and
(isset($tomb[0]['szerz_csop_id']))and
(isset($tomb[0]['szerz_tetel_modszam_kezi']))and
(isset($_POST['szerz_tetel_modszam_kezi']))and
($tomb[0]['szerz_tetel_modszam_kezi']!=$_POST['szerz_tetel_modszam_kezi'])
){//Ekkor változott a szerződés szám, kpi másolni kell és ellenőrzés
//Régi KPI lekérdezése
$tomb_szerz_kpi=keres_mit3('szerz_kpi','szerz_id',$tomb[0]['szerz_id'],'szerz_csop_id',$tomb[0]['szerz_csop_id'],'szerz_tetel_modszam_kezi',$tomb[0]['szerz_tetel_modszam_kezi']);
if(is_array($tomb_szerz_kpi)){//Ha nincs, nincs, de ha van, akkor se csináljuk meg.
	$tomb_szerz_kpi_uj_vane=keres_mit3('szerz_kpi','szerz_id',$tomb[0]['szerz_id'],'szerz_csop_id',$tomb[0]['szerz_csop_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi']);
	if(!is_array($tomb_szerz_kpi_uj_vane)){
	$tmp_kpi_alap=array();
	$tmp_kpi_alap[0]['szerz_id']=$tomb[0]['szerz_id'];
	$tmp_kpi_alap[0]['szerz_csop_id']=$tomb[0]['szerz_csop_id'];
	$tmp_kpi_alap[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
	$tmp_kpi_alap[0]['kpi_nemrelevans']=$tomb_szerz_kpi[0]['kpi_nemrelevans'];
	$tmp_kpi_alap[0]['kpi_osszekapcs_ck']='1';
	$tmp_kpi_alap[0]['kpi_megj']=$tomb_szerz_kpi[0]['kpi_megj'];
	be_visz_insert('szerz_kpi',$tmp_kpi_alap);
	$szerz_kpi_id_uj = mysqli_insert_id($GLOBALS['mysqli']);
	//KPI másolása
	$tomb_kpi_old=keres_mit1('szerz_kpi_osszekapcs','szerz_kpi_id',$tomb_szerz_kpi[0]['szerz_kpi_id']);
	foreach($tomb_kpi_old as $is => $ert){
		$tomb_kpi_old[$is]['szerz_kpi_id']=$szerz_kpi_id_uj;
	}
	be_visz_insert('szerz_kpi_osszekapcs',$tomb_kpi_old);
	}
}
}
//KPI típus szerződés összerendelés lementése ha van - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo 'ok$;$';
}else{
 echo 'adathiány';
}

}else{
 echo 'adathiány';
}
}
?>